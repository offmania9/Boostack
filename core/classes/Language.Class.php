<?php

class Language {

    const LANGUAGE_FILES_PATH = "core/lang/";
    const LANGUAGE_FILES_EXTENSION = ".inc.php";

    public static function getLanguage() {
        global $objSession;
        $boostack = Boostack::getInstance();
        $defaultLanguage = $boostack->getConfig("language_default");
        $language = null;

        if($boostack->getConfig("language_force_default") == TRUE) {
            $language = $defaultLanguage;
        }
        else if(!empty($_GET['lang'])) {
            $language = Utils::sanitizeInput($_GET['lang']);
        }
//        else {
//            if ($boostack->getConfig("session_on") && $objSession->SESS_LANGUAGE !== "") { // if is set in the user session
//                $language = $objSession->SESS_LANGUAGE;
//            } else { // if isn't set in the user session, fetch it from browser
//                if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
//                    $language = explode(',', Utils::sanitizeInput($_SERVER['HTTP_ACCEPT_LANGUAGE']));
//                    $language = strtolower(substr(chop($language[0]), 0, 2));
//                }
//            }
//        }
        if(in_array($language,$boostack->getConfig("enabled_languages"))) return $language;
        return $defaultLanguage;
    }

    public static function setSessionLanguage($lang) {
        global $objSession;
        $boostack = Boostack::getInstance();
        if ($boostack->getConfig("session_on"))
            $objSession->SESS_LANGUAGE = $lang;
    }

    public static function findLanguageFile($lang) {
        $filePath = ROOTPATH.self::LANGUAGE_FILES_PATH.$lang.self::LANGUAGE_FILES_EXTENSION;
        if(is_file($filePath)) {
            return $filePath;
        }
        throw new Exception("Language file ".$filePath." not found");
    }




}