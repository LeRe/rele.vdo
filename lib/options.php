<?
namespace Rele\Vdo;

class Options
{
	public static function isVatIncluded()
	{
		return \COption::GetOptionString("rele.vdo", "vat_included_default") == 'Y'? true: false;
	}
	public static function SetVatIncluded($flag = "N")
	{
		\COption::SetOptionString("rele.vdo", "vat_included_default", $flag=='Y'?'Y':'N');
		return true;
	}

	public static function getOrderWorkFolder()
	{
		$path = \COption::GetOptionString("rele.vdo", "importcsv_work_folder_default");
		return $path;
	}
	public static function setOrderWorkFolder($path = '/upload/')
	{
		\COption::SetOptionString("rele.vdo", "importcsv_work_folder_default", $path);
		return true;
	}

	public static function isOrderEncodingEnable()
	{
		return \COption::GetOptionString("rele.vdo", "importcsv_cp1251_utf8_encoding_default") == 'Y'? true: false;
	}
	public static function setOrderEncodingEnable($flag = "Y")
	{
		\COption::SetOptionString("rele.vdo", "importcsv_cp1251_utf8_encoding_default", $flag=='Y'?'Y':'N');
		return true;	
	}
}