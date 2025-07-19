<?php
/**
 * Modelo para auditoría de accesos
 */
class AuditoriaModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Registra el acceso a un módulo
     * @param int $idUsuario ID del usuario
     * @param string $nombre Nombre del usuario
     * @param string $rol Rol del usuario
     * @param string $modulo Nombre del módulo accedido
     * @return bool
     */
    public function registrarAccesoModulo($idUsuario, $nombre, $rol, $modulo)
    {
        // Por ahora solo registramos en log, en el futuro se puede guardar en base de datos
        $fecha = date('Y-m-d H:i:s');
        $log = "[$fecha] Usuario: $nombre (ID: $idUsuario, Rol: $rol) - Accedió al módulo: $modulo\n";
        
        // Crear directorio de logs si no existe
        $logDir = 'Logs';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        // Guardar en archivo de log
        $logFile = $logDir . '/accesos_' . date('Y-m-d') . '.log';
        file_put_contents($logFile, $log, FILE_APPEND);
        
        return true;
    }
}