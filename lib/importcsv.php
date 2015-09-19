<?
namespace Rele\Vdo;
use Bitrix\Main\HttpApplication;
use Rele\Vdo\OrderTable;
use Rele\Vdo\UsedPartsTable;

class ImportCSV 
{
	private static $workFolder = '/upload/';  //TODO Вынести в настройки модуля
	private static $fullPath2Folder = '';
	private static $orderFileName = ''; //vdo_orders.csv
	private static $usedPartsFileName = ''; //vdo_used_parts.csv
	private static $listForDelete = array();
	private static $orderFields = array('ORDER_NUMBER', 'ORDER_DATE', 'READY_DATE', 
										'OUT_DATE', 'CUSTOMER_ALERT', 'EQUIPMENT', 
										'REASON', 'ENGINEER', 'CUSTOMER');
	private static $usedPartsFields = array(
											'ORDER_NUMBER', 'POSITION_NUMBER', 'NOMENCLATURE', 
											'AMOUNT', 'COST', 'SUM', 'VAT');
	
	private static function checkCsvHeader($fileName, $fields)
	{
		$result = true; 
		if(($handle = fopen($fileName, "r")) !==false)
		{
			$header = fgetcsv($handle);
			if($header !== $fields)
			{
				$result = false;		
			}
			fclose($handle);
		}
		else
		{
			$result = false;
		}

		return $result;
	}

	private static function checkFiles()
	{
		if(self::$fullPath2Folder === '')
		{
			self::$fullPath2Folder = $_SERVER['DOCUMENT_ROOT'].self::$workFolder;	
		}
		$isAllGood = true;
	
		if(file_exists(self::$fullPath2Folder.self::$orderFileName) && 
			file_exists(self::$fullPath2Folder.self::$usedPartsFileName)) {

			$isAllGood = self::checkCsvHeader(self::$fullPath2Folder.self::$orderFileName, 
				self::$orderFields);
			if($isAllGood)
			{
				$isAllGood = self::checkCsvHeader(self::$fullPath2Folder.self::$usedPartsFileName, 
					self::$usedPartsFields);
			}
		}
		else 
		{
			$isAllGood = false;
		}
		return $isAllGood;				
	}

	public static function findFiles() 
	{
		if(self::$fullPath2Folder === '')
		{
			self::$fullPath2Folder = $_SERVER['DOCUMENT_ROOT'].self::$workFolder;
		}
		
		$arFilesInFolder = scandir(self::$fullPath2Folder);
		foreach ($arFilesInFolder as $key => $value) {
			if(is_file(self::$fullPath2Folder.$value)) 
			{
				$arFileName = explode('.', $value);
				if($arFileName[1] == 'csv')
				{
					if(self::checkCsvHeader(self::$fullPath2Folder.$value, self::$orderFields))
					{
						$mTime = filemtime(self::$fullPath2Folder.$value);
						$arOrdersFiles[$mTime] = $value; 
					}
					elseif (self::checkCsvHeader(self::$fullPath2Folder.$value, self::$usedPartsFields)) 
					{
						$mTime = filemtime(self::$fullPath2Folder.$value);
						$arUsedPartsFiles[$mTime] = $value;	
					}
				}
			}
		}

		krsort($arOrdersFiles, SORT_NUMERIC);
		self::$orderFileName = reset($arOrdersFiles);
		if(self::$orderFileName === false)
		{
			self::$orderFileName = '';	
		}
		krsort($arUsedPartsFiles, SORT_NUMERIC);
		self::$usedPartsFileName = reset($arUsedPartsFiles);
		if(self::$usedPartsFileName === false)
		{
			self::$usedPartsFileName = '';
		}

		self::$listForDelete = array_merge($arOrdersFiles, $arUsedPartsFiles);

		if(self::$orderFileName !== '' &&
			self::$usedPartsFileName !== '' &&
			count(self::$listForDelete) > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}

	static function loadData()
	{
		if(self::$fullPath2Folder === '')
		{
			self::$fullPath2Folder = $_SERVER['DOCUMENT_ROOT'].self::$workFolder;
		}
		setlocale(LC_ALL, 'ru_RU.utf8');

		if(self::findFiles())
		{
			self::clearTable(new OrderTable);
			self::clearTable(new UsedPartsTable);

			$handle = fopen('php://memory','w+');
			fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents(self::$fullPath2Folder.self::$orderFileName)));
			rewind($handle);		
			while(($data = fgetcsv($handle)) !== false)
			{
				if($data === self::$orderFields)
				{
					continue;
				}
				OrderTable::add(array(
					'ORDER_NUMBER' => $data[0],
					'ORDER_DATE' => trim($data[1]),	
					'READY_DATE' => trim($data[2]),	
					'OUT_DATE' => trim($data[3]),
					'CUSTOMER_ALERT' => trim($data[4]),
					'EQUIPMENT' => trim($data[5]),
					'REASON' => trim($data[6]),
					'ENGINEER' => trim($data[7]),
					'CUSTOMER' => trim($data[8])
				));
			}
			fclose($handle);
	
			//TODO make the option in the settings module for reencoding
			$handle = fopen('php://memory','w+');
			fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents(self::$fullPath2Folder.self::$usedPartsFileName)));
			rewind($handle);			
			while(($data = fgetcsv($handle)) !== false)
			{
				if($data === self::$usedPartsFields)
				{
					continue;
				}			
				UsedPartsTable::add(array(
						'ORDER_NUMBER' => $data[0],
						'POSITION_NUMBER' => $data[1],
						'NOMENCLATURE' => trim($data[2]),
						'AMOUNT' => $data[3],
						'COST' => $data[4],
						'SUM' => $data[5],
						'VAT' => $data[6]
				));
			}
			fclose($handle);
		
			foreach (self::$listForDelete as $value) {
				if(!unlink(self::$fullPath2Folder.$value))
				{
					AddMessage2Log('Can`t delete file: '.self::$fullPath2Folder.$value);
				}
			}
		}
		return 'Rele\Vdo\ImportCSV::loadData();';
	}

	static function clearTable($oTable)
	{
		if($oTable::isTableExists())
		{
			HttpApplication::getConnection()->query("delete from ".$oTable::getTableName());
		}
	}
}
