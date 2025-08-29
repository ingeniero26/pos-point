<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\BackupNotification;
use Symfony\Component\Console\Output\BufferedOutput;

class CreateBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificationEmail;

    public function __construct($notificationEmail)
    {
        $this->notificationEmail = $notificationEmail;
    }

    public function handle()
    {
        try {
            Log::info('Iniciando proceso de backup');
            
            $backupConfig = config('backup.backup');
            Log::info('Configuración del backup:', ['config' => $backupConfig]);
            
            $backupDiskName = $backupConfig['destination']['disks'][0];
            Log::info('Usando disco: ' . $backupDiskName);
            
            $backupDisk = Storage::disk($backupDiskName);
            
            $backupPath = $backupConfig['name'];
            Log::info('Ruta de backups: ' . $backupPath);
            
            $output = new BufferedOutput();
            $exitCode = Artisan::call('backup:run', [
                '--only-db' => true,
            ], $output);

            if ($exitCode === 0) {
                Log::info('Backup creado correctamente');
                $backups = $backupDisk->files($backupPath);
                Log::info('Archivos encontrados en el disco:', ['files' => $backups]);
                
                if (count($backups) > 0) {
                    $latestBackup = $backups[0];
                    Log::info('Backup encontrado en disco: ' . $latestBackup);
                } else {
                    Log::warning('No se encontraron backups en el disco');
                }
                
                if (config('mail.default') !== 'log') {
                    Mail::to($this->notificationEmail)->send(new BackupNotification());
                    Log::info('Correo de notificación enviado a: ' . $this->notificationEmail);
                } else {
                    Log::warning('El correo está configurado para usar el driver log');
                }
                
                return true;
            } else {
                $errorOutput = $output->fetch();
                Log::error('Error al crear el backup.', ['exit_code' => $exitCode, 'output' => $errorOutput]);
                throw new Exception('Error al crear el backup. Código de salida: ' . $exitCode . ' - ' . $errorOutput);
            }
        } catch (Exception $e) {
            Log::error('Error al crear backup: ' . $e->getMessage());
            throw $e;
        }
    }
}
