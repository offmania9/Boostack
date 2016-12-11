<?php

/**
 * Boostack: User_Registration.Class.php
 * ========================================================================
 * Copyright 2014-2017 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 2.3
 */
class User_Registration extends User_Info
{

    private $activation_date;

    private $access_code;

    private $ip;

    private $join_date;

    private $join_idconfirm;
    
    // private $excluse_from_update = array("id", "active","oauth_provider","oauth_uid","oauth_token","oauth_secret","activation_date","username","email","wall_count","ip","join_date","join_idconfirm","last_access","session_cookie","privacy" );
    const TABLENAME = "boostack_user_registration";

    const TABLENAME2 = "boostack_user";

    public function __construct($id = -1)
    {
        parent::__construct($id);
        if ($id != - 1) {
            $fields = $this->dbfield;
            $this->activation_date = $fields["activation_date"];
            $this->access_code = $fields["access_code"];
            $this->ip = $fields["ip"];
            $this->join_date = $fields["join_date"];
            $this->join_idconfirm = $fields["join_idconfirm"];
        }
    }

    public function prepare($post_array)
    {
        $fields["activation_date"] = (isset($post_array["activation_date"])) ? $post_array["activation_date"] : 0;
        $fields["access_code"] = (isset($post_array["access_code"])) ? $post_array["access_code"] : "";
        $fields["ip"] = Utils::getIpAddress();
        $fields["join_date"] = time();
        $fields["join_idconfirm"] = md5($fields["ip"] . $fields["join_date"]);
        foreach ($fields as $key => $value)
            $this->$key = $value; // OBJECT UPDATE
        return $fields;
    }

    public function insert($post_array)
    {
        parent::insert($post_array);
        $fields = self::prepare($post_array);
        $sql_1 = "INSERT INTO " . self::TABLENAME . " (id";
        $sql_2 = "VALUES('" . parent::__get("id") . "'";
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
        return true;
    }

    public function __get($property_name)
    {
        if (isset($this->$property_name)) {
            return ($this->$property_name);
        } else {
            return (parent::__get($property_name));
        }
    }

    public function __set($property_name, $val)
    {
        if (isset($this->$property_name)) {
            $this->$property_name = $val;
            $sql = "UPDATE " . self::TABLENAME . " SET $property_name='" . $val . "'  WHERE id ='" . $this->id . "' ";
            $this->pdo->query($sql);
        } else
            parent::__set($property_name, $val);
    }

    public function getIdByEmail($email)
    {
        $sql = "SELECT id FROM " . self::TABLENAME2 . " WHERE email ='" . $email . "' ";
        $q2 = $this->pdo->query($sql)->fetch();
        return ($q2) ? NULL : $q2[0];
    }
}
?>