<?php

define("ABSOLUTE_PATH", $_SERVER["DOCUMENT_ROOT"]."/DrinkStore/");
define("URL", "http://localhost/DrinkStore/");

define("ENV_FAJL", ABSOLUTE_PATH."app/config/.env");
define("LOG_FAJL", ABSOLUTE_PATH."app/data/log.txt");
define("GRESKE_FAJL", ABSOLUTE_PATH."app/data/greske.txt");


define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));

function env($naziv){

    $podaci = file(ENV_FAJL);

    $vrednost = "";
    foreach($podaci as $key=>$value){
        $konfig = explode("=", $value);
        if($konfig[0]==$naziv){
            $vrednost = trim($konfig[1]);
        }
    }
    return $vrednost;
}

?>