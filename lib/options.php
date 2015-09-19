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
}