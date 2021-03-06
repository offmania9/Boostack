<?php
/**
 * Boostack: global.env.php
 * ========================================================================
 * Copyright 2014-2021 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 4
 */


/**
 * PATHS
 */

$config["css_path"] = "assets/css/";
$config["js_path"] = "assets/js/";
$config["image_path"] = "assets/img/";
$config["template_path"] = "template/";
$config["mail_template_path"] = "template/mail/";
$config["language_path"] = "../lang/";
$config["language_file_extension"] = ".inc.json";

$config["default_js_files"] = array("lib/popper.js","lib/require.js","helpers.js","init.js");
$config["default_ie_js_files"] = array("lib/html5shiv.js","lib/respond.js");
$config["default_css_files"] = array("lib/bootstrap.css","lib/animate.css","style.css");/*,"custom.css"*/

$config["default_error_page"] = "error.phtml";

/**
 * GENERAL INFO & SEO
 */

$config["sitename"] = "getBoostack.com";
$config["project_name"] = "Boostack";
$config["project_sitename"] = "getBoostack.com";
$config["project_version"] = "4";
$config["project_mission"] = "getBoostack.com - Improve your development and build a modern website in minutes";
$config["viewport"] = "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0";
$config["html_lang"] = "en";
$config["site_title"] = "Boostack - The lightest full stack Framework for PHP";
$config["site_keywords"] = "boostack, php, framework, website, productive, simplicity, seo, secure, mysql, open-source"; // comma separated
$config["site_description"] = "A full stack Framework for PHP. Improve your development and build a modern website in minutes";
$config["site_author"] = "stefano spagnolo";

$config["url_logo"] = $config["image_path"]."boostack_logo_x210.png";
$config["url_logo_dark"] = $config["image_path"]."boostack_logo_x210.png";
$config["site_shortcuticon"] = $config["image_path"]."favicon.ico";
$config["appletouchicon_144"] = $config["image_path"]."apple-touch-icon-144-precomposed.png";
$config["appletouchicon_114"] = $config["image_path"]."apple-touch-icon-114-precomposed.png";
$config["appletouchicon_72"] = $config["image_path"]."apple-touch-icon-72-precomposed.png";
$config["appletouchicon_def"] = $config["image_path"]."apple-touch-icon-57-precomposed.png";


/**
 * SOCIAL
 */

$config["twitter"] = "@getBoostack";
$config["gplus"] = "https://plus.google.com/+BoostackFramework/";


/**
 * FACEBOOK META TAGS
 */

$config["facebookMetaTag"] = TRUE;
$config["og_type"] = "website";
$config["og_title"] = $config["site_title"];
$config["og_url"] = $config['url'];
$config["og_image"] = $config['url'].$config["url_logo"];
$config["og_description"] = $config["site_description"];
$config["fb_app_id"] = "";
$config["fb_app_secret"] = "";
$config["fb_admins"] = "";


/**
 * CUSTOM VARIABLES
 */

$filterField_Log = '{
 "id": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=,<,<=,>,>=",
   "filter":"numeric",
   "valueType":"number"
  }],
  "level": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=",
   "filter":"text",
   "valueType":"text"
  }],
 "datetime": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=,<,<=,>,>=",
   "filter":"numeric",
   "valueType":"number"
  }],
  "username": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=",
   "filter":"text",
   "valueType":"text"
  }],
  "ip": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=",
   "filter":"text",
   "valueType":"text"
  }],
  "useragent": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=",
   "filter":"text",
   "valueType":"text"
  }],
    "referrer": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=",
   "filter":"text",
   "valueType":"text"
  }],
  "query": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=",
   "filter":"text",
   "valueType":"text"
  }],
  "message": [{
   "canFilter":"true",
   "rule":"like,not like,<>,=",
   "filter":"text",
   "valueType":"text"
  }]
}';

CONST PRIVILEGE_SYSTEM = 0;
CONST PRIVILEGE_SUPERADMIN = 1;
CONST PRIVILEGE_ADMIN = 2;
CONST PRIVILEGE_USER = 3;
?>