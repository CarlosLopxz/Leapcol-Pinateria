<?php
class Errors extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $data['page_tag'] = "Error 404 - Página no encontrada";
        $data['page_title'] = "Error 404";
        $data['page_name'] = "error";
        $this->views->getView($this, "error", $data);
    }
}