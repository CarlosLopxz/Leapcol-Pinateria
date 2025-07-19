<?php
class LoginModel extends Mysql
{
    private $intIdUsuario;
    private $strEmail;
    private $strPassword;
    private $strToken;

    public function __construct()
    {
        parent::__construct();
    }

    public function loginUser(string $email, string $password)
    {
        $this->strEmail = $email;
        $this->strPassword = $password;
        $sql = "SELECT idusuario, nombre, apellido, status, password, rolid FROM usuarios WHERE 
                email = '$this->strEmail' AND status = 1";
        $request = $this->select($sql);
        
        if (!empty($request)) {
            $result = password_verify($this->strPassword, $request['password']);
            if ($result) {
                $_SESSION['idUser'] = $request['idusuario'];
                $_SESSION['login'] = true;

                $sql = "SELECT u.idusuario, u.nombre, u.apellido, u.email, r.idrol, r.nombrerol, u.status 
                        FROM usuarios u 
                        INNER JOIN roles r ON u.rolid = r.idrol 
                        WHERE u.idusuario = {$_SESSION['idUser']}";
                $request = $this->select($sql);
                $_SESSION['userData'] = $request;
                return $request;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUserEmail(string $email)
    {
        $this->strEmail = $email;
        $sql = "SELECT idusuario, nombre, apellido, status FROM usuarios WHERE 
                email = '$this->strEmail' AND status = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function setTokenUser(int $iduser, string $token)
    {
        $this->intIdUsuario = $iduser;
        $this->strToken = $token;
        $sql = "UPDATE usuarios SET token = ? WHERE idusuario = $this->intIdUsuario";
        $arrData = array($this->strToken);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function getUsuario(string $email, string $token)
    {
        $this->strEmail = $email;
        $this->strToken = $token;
        $sql = "SELECT idusuario FROM usuarios WHERE 
                email = '$this->strEmail' AND 
                token = '$this->strToken' AND 
                status = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function insertPassword(int $iduser, string $password)
    {
        $this->intIdUsuario = $iduser;
        $this->strPassword = $password;
        $sql = "UPDATE usuarios SET password = ?, token = ? WHERE idusuario = $this->intIdUsuario";
        $arrData = array($this->strPassword, "");
        $request = $this->update($sql, $arrData);
        return $request;
    }
    
    public function sessionLogin(int $iduser)
    {
        $this->intIdUsuario = $iduser;
        $sql = "SELECT u.idusuario, u.nombre, u.apellido, u.email, r.idrol, r.nombrerol, u.status 
                FROM usuarios u 
                INNER JOIN roles r ON u.rolid = r.idrol 
                WHERE u.idusuario = {$this->intIdUsuario}";
        $request = $this->select($sql);
        return $request;
    }
}