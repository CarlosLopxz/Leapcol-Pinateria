<?php
class Login extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        // No redirigimos automáticamente al dashboard
    }

    public function login()
    {
        $data['page_tag'] = "Login - " . NOMBRE_EMPRESA;
        $data['page_title'] = "Login";
        $data['page_name'] = "login";
        $this->views->getView($this, "Login", $data);
    }
    
    // Método por defecto
    public function index()
    {
        $this->login();
    }

    public function loginUser()
    {
        if ($_POST) {
            if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $strPassword = $_POST['txtPassword'];
                $requestUser = $this->model->loginUser($strEmail, $strPassword);
                
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecta.');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['status'] == 1) {
                        $_SESSION['idUser'] = $arrData['idusuario'];
                        $_SESSION['login'] = true;

                        $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        $_SESSION['userData'] = $arrData;
                        
                        $arrResponse = array('status' => true, 'msg' => 'ok');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function resetPass()
    {
        if ($_POST) {
            if (empty($_POST['txtEmailReset'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $token = token();
                $strEmail = strtolower(strClean($_POST['txtEmailReset']));
                $arrData = $this->model->getUserEmail($strEmail);

                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Usuario no encontrado.');
                } else {
                    $idpersona = $arrData['idusuario'];
                    $nombreUsuario = $arrData['nombre'] . ' ' . $arrData['apellido'];

                    $url_recovery = BASE_URL . 'login/confirmUser/' . $strEmail . '/' . $token;
                    $requestUpdate = $this->model->setTokenUser($idpersona, $token);

                    if ($requestUpdate) {
                        $dataUsuario = array(
                            'nombreUsuario' => $nombreUsuario,
                            'email' => $strEmail,
                            'asunto' => 'Recuperar cuenta - ' . NOMBRE_EMPRESA,
                            'url_recovery' => $url_recovery
                        );
                        
                        // Aquí se enviaría el correo, pero por ahora solo mostramos la URL
                        $arrResponse = array(
                            'status' => true, 
                            'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.',
                            'url' => $url_recovery
                        );
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function confirmUser(string $params)
    {
        if (empty($params)) {
            header('Location: ' . BASE_URL . 'login');
        } else {
            $arrParams = explode(',', $params);
            $strEmail = strClean($arrParams[0]);
            $strToken = strClean($arrParams[1]);
            $arrResponse = $this->model->getUsuario($strEmail, $strToken);
            
            if (empty($arrResponse)) {
                header("Location: " . BASE_URL . 'login');
            } else {
                $data['page_tag'] = "Cambiar contraseña";
                $data['page_name'] = "cambiar_contrasenia";
                $data['page_title'] = "Cambiar Contraseña";
                $data['email'] = $strEmail;
                $data['token'] = $strToken;
                $data['idpersona'] = $arrResponse['idusuario'];
                $this->views->getView($this, "cambiar_password", $data);
            }
        }
        die();
    }

    public function setPassword()
    {
        if (empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])) {
            $arrResponse = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdpersona = intval($_POST['idUsuario']);
            $strPassword = $_POST['txtPassword'];
            $strPasswordConfirm = $_POST['txtPasswordConfirm'];
            $strEmail = strClean($_POST['txtEmail']);
            $strToken = strClean($_POST['txtToken']);

            if ($strPassword != $strPasswordConfirm) {
                $arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales.');
            } else {
                $arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
                if (empty($arrResponseUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'Error de datos.');
                } else {
                    $strPassword = password_hash($strPassword, PASSWORD_DEFAULT);
                    $requestPass = $this->model->insertPassword($intIdpersona, $strPassword);

                    if ($requestPass) {
                        $arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con éxito.');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intente más tarde.');
                    }
                }
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}