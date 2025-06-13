<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    /**
     * Registra un mensaje de error y lo muestra en la consola
     *
     * @param string $message Mensaje de error
     * @param array $context Contexto adicional (opcional)
     * @return void
     */
    public static function error($message, array $context = [])
    {
        // Registrar en el archivo de logs
        Log::error($message, $context);
        
        // Si estamos en modo debug, mostrar en la consola
        if (config('app.debug')) {
            echo "<script>console.error(" . json_encode($message) . ");</script>";
            
            if (!empty($context)) {
                echo "<script>console.error('Contexto:', " . json_encode($context) . ");</script>";
            }
        }
    }
    
    /**
     * Registra un mensaje informativo y lo muestra en la consola
     *
     * @param string $message Mensaje informativo
     * @param array $context Contexto adicional (opcional)
     * @return void
     */
    public static function info($message, array $context = [])
    {
        // Registrar en el archivo de logs
        Log::info($message, $context);
        
        // Si estamos en modo debug, mostrar en la consola
        if (config('app.debug')) {
            echo "<script>console.info(" . json_encode($message) . ");</script>";
            
            if (!empty($context)) {
                echo "<script>console.info('Contexto:', " . json_encode($context) . ");</script>";
            }
        }
    }
    
    /**
     * Registra un mensaje de advertencia y lo muestra en la consola
     *
     * @param string $message Mensaje de advertencia
     * @param array $context Contexto adicional (opcional)
     * @return void
     */
    public static function warning($message, array $context = [])
    {
        // Registrar en el archivo de logs
        Log::warning($message, $context);
        
        // Si estamos en modo debug, mostrar en la consola
        if (config('app.debug')) {
            echo "<script>console.warn(" . json_encode($message) . ");</script>";
            
            if (!empty($context)) {
                echo "<script>console.warn('Contexto:', " . json_encode($context) . ");</script>";
            }
        }
    }
    
    /**
     * Muestra los datos en la consola (para depuración)
     *
     * @param mixed $data Datos a mostrar
     * @param string $label Etiqueta (opcional)
     * @return void
     */
    public static function debug($data, $label = 'Debug')
    {
        if (config('app.debug')) {
            $dataJson = json_encode($data);
            echo "<script>console.group(" . json_encode($label) . ");</script>";
            echo "<script>console.log(" . $dataJson . ");</script>";
            echo "<script>console.groupEnd();</script>";
        }
    }
    
    /**
     * Registra información de una excepción y la muestra en la consola
     *
     * @param \Exception|\Throwable $exception La excepción
     * @return void
     */
    public static function exception($exception)
    {
        $message = get_class($exception) . ': ' . $exception->getMessage();
        $context = [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ];
        
        self::error($message, $context);
    }
} 