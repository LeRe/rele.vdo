<?
IncludeModuleLangFile(__FILE__);

$aMenu = array(
	"parent_menu" => "global_menu_services",
	"section" => "vdo",
	"sort" => 10,
	"text" => GetMessage("VDO_AM"),
	"title"=> GetMessage("VDO_AM_ALT"),
	"items_id" => "menu_vdo",
	"items" => array(
		array(
			"text" => GetMessage("VDO_AM_STAT"),
			"url" => "vdo_stat.php?lang=".LANGUAGE_ID,
			"more_url" => array(),
			"title" => GetMessage("VDO_AM_STAT_ALT")
		),
		array(
			"text" => GetMessage("VDO_AM_MNG_ORDERS"),
			"url" => "vdo_mng_orders.php?lang=".LANGUAGE_ID,
			"more_url" => array(),
			"title" => GetMessage("VDO_AM_MNG_ORDERS_ALT")
		),
	)
);

return $aMenu;