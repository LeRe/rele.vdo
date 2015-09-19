<?
namespace Rele\Vdo;

class Utils
{
	public static function vatEnable($ID, $arFields)
	{
		$res = Array("VAT_INCLUDED" => 'Y');
		\CCatalogProduct::Update($ID, $res);
	}

	public static function setVatHandler()
	{
		RegisterModuleDependences("catalog", "OnProductAdd", "rele.vdo", "Rele\Vdo\Utils", "vatEnable");
	}

	public static function unSetVatHandler()
	{
		UnRegisterModuleDependences("catalog", "OnProductAdd", "rele.vdo", "Rele\Vdo\Utils", "vatEnable");
	}
}