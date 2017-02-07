<?php
/**
 * Boostack: User_InfoEntity.Class.php
 * ========================================================================
 * Copyright 2014-2017 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 2.4
 */
class User_Info extends BaseClass
{

    protected $first_name;
    protected $last_name;
    protected $locale;
    protected $city;
    protected $state;
    protected $country;
    protected $zip;
    protected $about_me;
    protected $tel;
    protected $cell;
    protected $profession;
    protected $company;
    protected $birthday;
    protected $movies;
    protected $music;
    protected $political;
    protected $interests;
    protected $tv;
    protected $religion;
    protected $pic_big;
    protected $sex;
    protected $name;

    const TABLENAME = "boostack_user_info";

    protected $default_values = [
        "first_name" => "",
        "last_name" => "",
        "locale" => "",
        "city" => "",
        "state" => "",
        "country" => "",
        "zip" => "",
        "about_me" => "",
        "tel" => "",
        "cell" => "",
        "profession" => "",
        "company" => "",
        "birthday" => "",
        "movies" => "",
        "music" => "",
        "political" => "",
        "interests" => "",
        "tv" => "",
        "religion" => "",
        "pic_big" => "",
        "sex" => "",
        "name" => "",
    ];

    public function __construct($id = null)
    {
        parent::init($id);
    }

}

?>