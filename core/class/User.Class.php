<?php

/**
 * Boostack: User.Class.php
 * ========================================================================
 * Copyright 2014-2017 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 2.3
 */
class User
{

    private $dbfield;

    private $id;

    private $active;

    private $privilege;

    private $name;

    private $username;

    private $pwd;

    private $email;

    private $last_access;

    private $session_cookie;

    private $pic_square;

    private $pdo;

    private $excluse_from_update = array(
        "id",
        "active",
        "username",
        "email",
        "last_access",
        "session_cookie"
    );

    const TABLENAME = "boostack_user";

    public function __construct($id = -1, $init = true)
    {
        $this->pdo = Database_PDO::getInstance();
        if ($id != - 1) {
            if ($init) {
                $sql = "SELECT * FROM " . self::TABLENAME . " WHERE id ='" . $id . "' ";
                $fields = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
                if (get_class($this) != __CLASS__)
                    $this->dbfield = $fields;
                $this->id = $fields["id"];
                $this->active = $fields["active"];
                $this->privilege = $fields["privilege"];
                $this->name = $fields["name"];
                $this->username = $fields["username"];
                $this->pwd = $fields["pwd"];
                $this->email = $fields["email"];
                $this->last_access = $fields["last_access"];
                $this->session_cookie = $fields["session_cookie"];
                $this->pic_square = $fields["pic_square"];
            } else {
                $sql = "SELECT id FROM " . self::TABLENAME . " WHERE id ='" . $id . "' ";
                $fields = $this->pdo->query($sql)->fetch();
                $this->id = $fields["id"];
            }
        }
    }

    public function prepare($post_array)
    {
        global $default_profilepic;
        $fields["active"] = (! isset($post_array["active"])) ? "0" : $post_array["active"];
        $fields["privilege"] = (!isset($post_array["privilege"]) || $post_array["privilege"] == "") ? "0" : $post_array["privilege"];
        $fields["name"] = (!isset($post_array["name"]) || $post_array["name"] == "") ? "" : $post_array["name"];
        $fields["username"] = $post_array["username"];
        if (!isset($post_array["pwd"]) || $post_array["pwd"] == "")
            $this->excluse_from_update[] = "pwd";
        else
            $fields["pwd"] = self::passwordToHash($post_array["pwd"]);
        
        $fields["email"] = $post_array["email"];
        $fields["last_access"] = "0";
        $fields["session_cookie"] = (! isset($post_array["session_cookie"])) ? "" : $post_array["session_cookie"];
        $fields["pic_square"] = (!isset($post_array["pic_square"]) || $post_array["pic_square"] == "") ? $default_profilepic : $post_array["pic_square"];
        
        foreach ($fields as $key => $value)
            $this->$key = $value; // OBJECT UPDATE
        
        return $fields;
    }

    public function passwordToHash($clearpassword)
    {
        if (version_compare(PHP_VERSION, '5.5.0') >= 0)
            return password_hash($clearpassword,PASSWORD_DEFAULT);
        else
            return hash("sha512", $clearpassword);
    }

    public function insert($post_array)
    {
        $fields = self::prepare($post_array);
        
        $sql_1 = "INSERT INTO " . self::TABLENAME . " (id";
        $sql_2 = "VALUES(NULL";
        foreach ($fields as $key => $value) {
            if ($key == "id")
                continue;
            $sql_1 .= ",$key";
            $sql_2 .= ",'$value'";
            // $this->$key = $value; #OBJECT UPDATE
        }
        $sql_1 .= ") ";
        $sql_2 .= ")";
        
        $sql = $sql_1 . $sql_2;
        $this->pdo->query($sql);
        $this->id = $this->pdo->lastInsertId();
        return true;
    }

    public function update($post_array, $excluse = NULL)
    {
        $fields = self::prepare($post_array);
        $sql = "UPDATE " . self::TABLENAME . " SET ";
        foreach ($fields as $key => $value) {
            if (in_array($key, $this->excluse_from_update) || in_array($key, $excluse))
                continue;
            $sql .= "$key='" . $value . "',";
            // $this->$key = $value; #OBJECT UPDATE
        }
        $sql = substr($sql, 0, - 1);
        $sql .= " WHERE id='" . $this->id . "'";
        $this->pdo->query($sql);
        return true;
    }

    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLENAME . " WHERE id='" . $this->id . "'";
        $q = $this->pdo->query($sql);
        return ($q->rowCount() == 0);
    }

    public function __get($property_name)
    {
        if (isset($this->$property_name)) {
            return ($this->$property_name);
        } else {
            return (NULL);
        }
    }

    public function __set($property_name, $val)
    {
        $this->$property_name = $val;
        $sql = "UPDATE " . self::TABLENAME . " SET $property_name='" . $val . "'  WHERE id ='" . $this->id . "' ";
        $this->pdo->query($sql);
    }

    public function isRegisterbyUsername($username)
    {
        $sql = "SELECT id FROM " . self::TABLENAME . " WHERE username ='" . $username . "' ";
        $q = $this->pdo->query($sql);
        $q2 = $q->fetch();
        return ($q->rowCount() == 0) ? NULL : $q2[0];
    }

    public function isUsernameRegistered($username)
    {
        $sql = "SELECT id FROM " . self::TABLENAME . " WHERE username ='" . $username . "' ";
        $q = $this->pdo->query($sql);
        $q2 = $q->fetch();
        return ($q->rowCount() == 0) ? NULL : $q2[0];
    }

    public function getUserIDByEmail($email, $throwException = true)
    {
        $sql = "SELECT id FROM " . self::TABLENAME . " WHERE email ='" . $email . "' ";
        $q = $this->pdo->query($sql);
        $q2 = $q->fetch();
        if ($q->rowCount() == 0)
            if ($throwException)
                throw new Exception("Attention! User or Email not found.",0);
        return false;
        
        return $q2[0];
    }

    public function checkUserExistsByEmail($email, $throwException = true)
    {
        $sql = "SELECT id FROM " . self::TABLENAME . " WHERE email ='" . $email . "' ";
        $q = $this->pdo->query($sql);
        $q2 = $q->fetch();
        if ($q->rowCount() == 0){
            if ($throwException)
                throw new Exception("Attention! User or Email not found.",1);
            return false;
        }
        return true;
    }

    public function checkEmailFormat($email, $throwException = true)
    {
        $regexp = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
        if ($email == "" || ! preg_match($regexp, $email) || strlen($email >= 255)){
            if ($throwException)
                throw new Exception("This E-mail address is wrong.",2);
        return false;
        }
        return true;
    }

    public function checkEmailIntoDB($email, $throwException = true)
    {
        if ($this->pdo->query("SELECT id FROM " . self::TABLENAME . " WHERE email = '" . $email . "'")->rowCount() == 0){
            if ($throwException)
                throw new Exception("Username or password not valid.",3);
        return false;
        }
        return true;
    }

    /*
     *  Effettua il login
     */
    public function tryLogin($username, $password, $cookieRememberMe, $usernameIsEmail=false, $throwException = true)
    {
        global $objSession, $boostack;
        if ($usernameIsEmail) {
            if (!self::checkUserExistsByEmail($username)) {
                $boostack->writeLog("User -> tryLogin: User doesn't exist by Email Address", "user");
                if ($throwException)
                    throw new Exception("Username or password not valid.", 6);
                return false;
            }
        }
            
        $objSession->LogOut();
        $objSession->Login($username, $password,$usernameIsEmail);
        if (!$objSession->IsLoggedIn()){
            $boostack->writeLog("User -> tryLogin: Username or password not valid.","user");
            if ($throwException)
                throw new Exception("Username or password not valid.",5);
            return false;
        }

        if ($cookieRememberMe) {
            $user = $objSession->GetUserObject();
            $user->refreshRememberMeCookie();
        }
        $boostack->writeLog("[Login] uid: ".$objSession->GetUserID(),"user");
        return true;
    }

    /*
     *  Genera il valore del remember-me cookie
     */
    public function generateCookieHash(){
        return  md5(time()).md5(Utils::getIpAddress() . Utils::getUserAgent());
    }

    /*
     *  Aggiorna il valore del remember-me cookie
     *  dopo un login
     */
    public function refreshRememberMeCookie() {
        global $boostack;
        $cookieHash = $this->generateCookieHash();
        setcookie($boostack->getConfig("cookie_name"), $cookieHash, time() + $boostack->getConfig("cookie_expire"), '/');
        $this->pdo->query("UPDATE " . self::TABLENAME . " SET session_cookie = '$cookieHash' WHERE id = '" . $this->id . "'");
    }

}
?>