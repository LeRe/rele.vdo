<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("T_VDO_ORDER_LOGIN_DESC_DETAIL"),
	"DESCRIPTION" => GetMessage("T_VDO_ORDER_LOGIN_DESC_DETAIL_DESC"),
	"ICON" => "",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => GetMessage('T_VDO'),
		"CHILD" => array(
			"ID" => "order",
			"NAME" => GetMessage("T_VDO_ORDER_DESC"),			
		),
	),
);