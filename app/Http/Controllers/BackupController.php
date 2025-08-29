<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BackupNotification;
use App\Jobs\CreateBackupJob;
use Spatie\Backup\BackupDestination\BackupDestination;
use Exception;

class BackupController extends Controller
{
    protected $maxBackups = 10;
    protected $notificationEmail;

    public function __construct()
    {
        $this->middleware('admin');
        $this->notificationEmail = config('backup.notifications.email', 'admin@example.com');
        
        // Verificar si el email está configurado
        if (!$this->notificationEmail) {
            Log::warning('No se ha configurado una dirección de correo para las notificaciones de backup');
        }
    }
    // Listar todos los backups
    public function index()
    {
        try {
            // Obtener la configuración del backup
            $backupConfig = config('backup.backup');
            Log::info('Configuración del backup:', ['config' => $backupConfig]);
            
            // Verificar el disco de destino
            $backupDiskName = $backupConfig['destination']['disks'][0];
            Log::info('Usando disco: ' . $backupDiskName);
            
            $backupDisk = Storage::disk($backupDiskName);
            
            // Verificar si el disco existe y está configurado correctamente
            if (!$backupDisk) {
                Log::error('No se puede acceder al disco de backup: ' . $backupDiskName);
                return back()->with('error', 'No se puede acceder al disco de backup');
            }

            // Obtener la ruta base de los backups
            $backupPath = $backupConfig['name'];
            Log::info('Buscando backups en: ' . $backupPath);
            
            $backupFiles = $backupDisk->files($backupPath);
            
            Log::info('Archivos encontrados en el disco:', ['files' => $backupFiles]);

            // Ordenar backups por fecha (más reciente primero)
            usort($backupFiles, function($a, $b) use ($backupDisk) {
                return $backupDisk->lastModified($b) - $backupDisk->lastModified($a);
            });

            $backups = [];
            foreach ($backupFiles as $file) {
                if ($backupDisk->exists($file)) {
                    $backups[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => $this->formatBytes($backupDisk->size($file)),
                        'date' => $backupDisk->lastModified($file),
                        'formatted_date' => date('Y-m-d H:i:s', $backupDisk->lastModified($file))
                    ];
                }
            }

            // Limpiar backups antiguos si exceden el límite
            $this->cleanOldBackups($backupDisk, $backups);

            return view('admin.backups.index', compact('backups'))
                ->with('last_backup_status', $this->getLastBackupStatus())
                ->with('maxBackups', $this->maxBackups);
        } catch (Exception $e) {
            Log::error('Error al listar backups: ' . $e->getMessage());
            return back()->with('error', 'Error al listar los backups: ' . $e->getMessage());
        }
    }

    // Crear un nuevo backup
    public function store(Request $request)
    {
        try {
            // Dispatch the backup job
            CreateBackupJob::dispatch($this->notificationEmail);
            
            // Esperar un momento para que el job se inicie
            sleep(1);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Backup iniciado correctamente'
                ]);
            }

            return redirect()->back()->with('success', 'Backup iniciado correctamente.');
        } catch (Exception $e) {
            Log::error('Error al crear backup: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al iniciar el backup: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al iniciar el backup: ' . $e->getMessage());
        }
    }

    // Descargar un backup
    public function download($fileName)
    {
        try {
            $filePath = config('backup.backup.name') . '/' . $fileName;
            $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

            if ($disk->exists($filePath)) {
                return $disk->download($filePath);
            }

            throw new Exception('El backup no existe.');
        } catch (Exception $e) {
            Log::error('Error al descargar backup: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al descargar el backup: ' . $e->getMessage());
        }
    }
    

    // Eliminar un backup
    public function destroy($fileName)
    {
        $this->authorize('admin.backups.delete');

        try {
            $filePath = config('backup.backup.name') . '/' . $fileName;
            $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

            if ($disk->exists($filePath)) {
                $disk->delete($filePath);
                Log::info('Backup eliminado: ' . $fileName);
                return redirect()->back()->with('success', 'Backup eliminado correctamente.');
            }

            throw new Exception('El backup no existe.');
        } catch (Exception $e) {
            Log::error('Error al eliminar backup: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el backup: ' . $e->getMessage());
        }
    }
    

    // Formatear tamaño en bytes a KB, MB, GB, etc.
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
    }

    // Limpiar backups antiguos
    private function cleanOldBackups($disk, $backups)
    {
        if (count($backups) > $this->maxBackups) {
            $backupsToDelete = array_slice($backups, $this->maxBackups);
            foreach ($backupsToDelete as $backup) {
                try {
                    $disk->delete($backup['path']);
                    Log::info('Backup antiguo eliminado: ' . $backup['name']);
                } catch (Exception $e) {
                    Log::error('Error al eliminar backup antiguo: ' . $e->getMessage());
                }
            }
        }
    }

    // Obtener estado del último backup
    private function getLastBackupStatus()
    {
        $status = [
            'has_backup' => false,
            'last_backup_date' => null,
            'last_backup_size' => null
        ];

        $backupDisk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $backupFiles = $backupDisk->files(config('backup.backup.name'));

        if (!empty($backupFiles)) {
            usort($backupFiles, function($a, $b) use ($backupDisk) {
                return $backupDisk->lastModified($b) - $backupDisk->lastModified($a);
            });

            $lastBackup = $backupFiles[0];
            $status['has_backup'] = true;
            $status['last_backup_date'] = date('Y-m-d H:i:s', $backupDisk->lastModified($lastBackup));
            $status['last_backup_size'] = $this->formatBytes($backupDisk->size($lastBackup));
        }

        return $status;
    }
    }

