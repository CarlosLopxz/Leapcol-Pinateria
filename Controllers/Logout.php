<?php
/**
 * Controlador para cerrar sesión
 */
class Logout extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}