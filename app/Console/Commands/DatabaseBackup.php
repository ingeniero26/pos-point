<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup {--path=}';
    protected $description = 'Crear backup de la base de datos';

    public function handle()
    {
        $filename = 'backup-' . Carbon::now()->format('Y-m-d-H-i-s') . '.sql';
        $path = $this->option('path') ?: storage_path('app/backups');
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $fullPath = $path . '/' . $filename;
        
        // Detectar la ruta de mysqldump automáticamente
        $mysqldumpPath = $this->getMysqldumpPath();
        
        if (!$mysqldumpPath) {
            $this->error('mysqldump no encontrado. Instala MySQL o agrega la ruta al PATH.');
            return;
        }
        
        $command = sprintf(
            '%s --user=%s --password=%s --host=%s %s > %s',
            $mysqldumpPath,
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.database'),
            $fullPath
        );

        exec($command, $output, $return);

        if ($return === 0) {
            $this->info("Backup creado exitosamente: {$filename}");
        } else {
            $this->error("Error al crear el backup");
        }
    }
    
    private function getMysqldumpPath()
    {
        // Rutas comunes donde puede estar mysqldump
        $possiblePaths = [
            'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe',
            'C:\Program Files\MySQL\MySQL Server 5.7\bin\mysqldump.exe',
            'C:\xampp\mysql\bin\mysqldump.exe',
            'C:\wamp64\bin\mysql\mysql8.0.21\bin\mysqldump.exe',
            'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe',
            'mysqldump', // Si está en PATH
        ];
        
        foreach ($possiblePaths as $path) {
            if ($path === 'mysqldump') {
                // Verificar si está en PATH
                exec('where mysqldump', $output, $return);
                if ($return === 0) {
                    return 'mysqldump';
                }
            } elseif (file_exists($path)) {
                return $path;
            }
        }
        
        return null;
    }
}