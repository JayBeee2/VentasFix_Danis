<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba los diferentes niveles de log para verificar su funcionamiento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando prueba de logs...');
        
        // Probando diferentes niveles de log
        Log::emergency('Mensaje de nivel emergency');
        $this->line('Log emergency registrado');
        
        Log::alert('Mensaje de nivel alert');
        $this->line('Log alert registrado');
        
        Log::critical('Mensaje de nivel critical');
        $this->line('Log critical registrado');
        
        Log::error('Mensaje de nivel error');
        $this->line('Log error registrado');
        
        Log::warning('Mensaje de nivel warning');
        $this->line('Log warning registrado');
        
        Log::notice('Mensaje de nivel notice');
        $this->line('Log notice registrado');
        
        Log::info('Mensaje de nivel info');
        $this->line('Log info registrado');
        
        Log::debug('Mensaje de nivel debug');
        $this->line('Log debug registrado');
        
        // Probando log con contexto
        Log::info('Mensaje con contexto', ['user_id' => 1, 'action' => 'test']);
        $this->line('Log con contexto registrado');
        
        // Probando log de excepción
        try {
            throw new \Exception('Esta es una excepción de prueba');
        } catch (\Exception $e) {
            Log::error('Error capturado: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString()
            ]);
            $this->line('Log de excepción registrado');
        }
        
        $this->info('Prueba de logs completada. Revisa el archivo de logs en storage/logs/laravel.log');
        $this->line('');
        $this->line('Para ver el archivo de log, ejecuta: tail -f storage/logs/laravel.log');
        
        return Command::SUCCESS;
    }
}
