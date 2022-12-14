<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\ModuleManager;

if(!CModule::IncludeModule("iblock"))
	return;

$mediaProperty = array(
	"" => GetMessage("MAIN_NO"),
);
$sliderProperty = array(
	"" => GetMessage("MAIN_NO"),
);
$propertyList = CIBlockProperty::GetList(
	array("sort"=>"asc", "name"=>"asc"),
	array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"])
);
while ($property = $propertyList->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	$id = $property["CODE"]? $property["CODE"]: $property["ID"];
	if ($property["PROPERTY_TYPE"] == "S")
	{
		$mediaProperty[$id] = "[".$id."] ".$property["NAME"];
	}
	if ($property["PROPERTY_TYPE"] == "F")
	{
		$sliderProperty[$id] = "[".$id."] ".$property["NAME"];
	}
}

$arTemplateParameters = array(
	"DISPLAY_DATE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
	"MEDIA_PROPERTY" => array(
		"NAME" => GetMessage("TP_BN_MEDIA_PROPERTY"),
		"TYPE" => "LIST",
		"VALUES" => $mediaProperty,
	),
	"SLIDER_PROPERTY" => array(
		"NAME" => GetMessage("TP_BN_SLIDER_PROPERTY"),
		"TYPE" => "LIST",
		"VALUES" => $sliderProperty,
	),
);

if ($arCurrentValues["USE_SHARE"] == "Y")
{
	$arTemplateParameters["LIST_USE_SHARE"] = array(
		"NAME" => GetMessage("TP_BN_LIST_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"VALUE" => "Y",
		"DEFAULT" => "N",
	);

	$arTemplateParameters["SHARE_TEMPLATE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
		"DEFAULT" => "",
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"REFRESH"=> "Y",
	);

	if (trim($arCurrentValues["SHARE_TEMPLATE"]) == '')
		$shareComponentTemplate = false;
	else
		$shareComponentTemplate = trim($arCurrentValues["SHARE_TEMPLATE"]);

	include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/bitrix/main.share/util.php");

	$arHandlers = __bx_share_get_handlers($shareComponentTemplate);

	$arTemplateParameters["SHARE_HANDLERS"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arHandlers["HANDLERS"],
		"DEFAULT" => $arHandlers["HANDLERS_DEFAULT"],
	);

	$arTemplateParameters["SHARE_SHORTEN_URL_LOGIN"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_LOGIN"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
	
	$arTemplateParameters["SHARE_SHORTEN_URL_KEY"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_KEY"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

$arTemplateParameters['NEWSSORT'] = array(
    'NAME' => GetMessage("SORT_NEWS"),
    'TYPE' => 'LIST',
    'VALUES' => array(
        "Created_date" => GetMessage("SORT_NEWS_OPTION_1"),
        "Name" => GetMessage("SORT_NEWS_OPTION_2"),
    ),
);

$arTemplateParameters['TIME_CACHE'] = array(
    'NAME' => GetMessage("TIME_CACHE_NAME"),
    'TYPE' => 'STRING',
    "DEFAULT" => "",
);

$arThemes = array();
if (ModuleManager::isModuleInstalled('bitrix.eshop'))
{
	$arThemes['site'] = GetMessage('TP_BN_THEME_SITE');
}

$arThemes['blue'] = GetMessage('TP_BN_THEME_BLUE');
$arThemes['green'] = GetMessage('TP_BN_THEME_GREEN');
$arThemes['red'] = GetMessage('TP_BN_THEME_RED');
$arThemes['wood'] = GetMessage('TP_BN_THEME_WOOD');
$arThemes['yellow'] = GetMessage('TP_BN_THEME_YELLOW');
$arThemes['black'] = GetMessage('TP_BN_THEME_BLACK');

$arTemplateParameters['TEMPLATE_THEME'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage("TP_BN_TEMPLATE_THEME"),
	'TYPE' => 'LIST',
	'VALUES' => $arThemes,
	'DEFAULT' => 'blue',
	'ADDITIONAL_VALUES' => 'Y',
);
