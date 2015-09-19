<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arComponentParameters = array(
	"GROUPS" => array(
		"PARAMS" => array(
			"NAME" => GetMessage("VDO_ORDER_LOGIN_PARAMS"),
		),
	)
);

$arComponentParameters["PARAMETERS"]["PATH"] = array(
	"NAME" => GetMessage("VDO_ORDER_LOGIN_SHOW_PATH"), 
	"TYPE" => "STRING",
	"MULTIPLE" => "N",
	"ADDITIONAL_VALUES" => "N",
	"DEFAULT" => '={SITE_DIR."order/show.php"}',
	"PARENT" => "PARAMS",
);