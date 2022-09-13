<?
if(!defined("B_PROLOG_INCLUDED")|| B_PROLOG_INCLUDED!==true)DIE();
$arComponentDescription = array(

        "NAME" => "Обычное имя",//свое имя
        "DESCRIPTION" => '',
        "PATH" => array(
            "ID" => "catalog",
            "CHILD" => array(
                "ID" => "contentnews",
                "NAME" => GetMessage("NEWS_CATALOG"),
                "SORT" => 310
            )
        ),
    "CACHE_PATH" => "Y",
    "COMPLEX" => "Y"
    );
?>