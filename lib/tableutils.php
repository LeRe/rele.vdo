<?
namespace Rele\Vdo;
use Bitrix\Main\Entity;
use Bitrix\Main\HttpApplication;

abstract class TableUtils extends Entity\DataManager 
{
	public static function isTableExists()
	{
		return HttpApplication::getConnection()->isTableExists(static::getTableName());
	}

	public static function createTable()
	{	
		if(!self::isTableExists()){
			static::getEntity()->createDbTable();
		}
		return self::isTableExists();
	}

	static public function clearTable()
	{
		if(self::isTableExists())
		{
			HttpApplication::getConnection()->query("delete from ".static::getTableName());
		}
	}

	public static function dropTable()
	{	
		if(self::isTableExists())
		{
			HttpApplication::getConnection()->query("drop table ".static::getTableName());
		}
	}
}