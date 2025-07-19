<?php
class Load
{
    public function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : 'Login/index';
        $arrUrl = explode("/", $url);
        
        $controller = $arrUrl[0];
        $method = isset($arrUrl[1]) ? $arrUrl[1] : 'index';
        $params = '';
        
        if (isset($arrUrl[2]) && $arrUrl[2] != '') {
            for ($i = 2; $i < count($arrUrl); $i++) {
                $params .= $arrUrl[$i] . ',';
            }
            $params = trim($params, ',');
        }
        
        $controller = ucwords($controller);
        $controllerFile = "Controllers/" . $controller . ".php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controller();
            
            if (method_exists($controller, $method)) {
                $controller->{$method}($params);
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }
    }
    
    private function loadError()
    {
        require_once "Controllers/Errors.php";
        $errors = new Errors();
        $errors->index();
    }
}