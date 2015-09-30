<?
namespace Rele\Vdo;
use Rele\Vdo\OrderTable;
use Rele\Vdo\UsedPartsTable;
use Rele\Vdo\Options;

/**
* ImportCSV - обеспечивает загрузку данных заказ-нарядов в таблицы модуля.
*
*/
class ImportCSV 
{
	/** @var string $fullPath2Folder Содержит полный путь к папке содержащей импортируемые файлы */
	private static $fullPath2Folder = '';

	/** @var string $orderFileName	 Содержит имя файла с данными по заказ-нарядам */
	private static $orderFileName = '';

	/** @var string $usedPartsFileName	Содержит имя файла с данными по использованным запчастям */
	private static $usedPartsFileName = '';

	/** @var array  $listForDelete		Содержит список файлов подлежащих удалению после импортирования данных */
	private static $listForDelete = array();

    /** @var array  $orderFields		Содержит название полей для файла содержащего данные по заказ-нарядам */
	private static $orderFields = array('ORDER_NUMBER', 'ORDER_DATE', 'READY_DATE', 
										'OUT_DATE', 'CUSTOMER_ALERT', 'EQUIPMENT', 
										'REASON', 'ENGINEER', 'CUSTOMER');

	/** @var array  $usedPartsFields	Содержит название полей для файла содержащего данные по использованным запчастям */
	private static $usedPartsFields = array(
											'ORDER_NUMBER', 'POSITION_NUMBER', 'NOMENCLATURE', 
											'AMOUNT', 'COST', 'SUM', 'VAT');

	/**
	* Проверяет заголовки CSV.
	*
	* Осуществляет проверку заголовков CSV в файле на предмет соответствия заданным заголовкам.
	*   
	* @param string $fileName Имя файла подлежащего проверке
	* @param array $fields Массив содержащий поля, наличие которых необходимо проверить в файле $fileName
	*
	* @return boolean Возвращает true если заголовок файла совпадает с заданными параметрами, иначе false
	*/
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

	/**
	* Проверяет файлы.
	*
	* Осуществляет проверку файлов заданных в свойствах класса $orderFileName и $usedPartsFileName.
	* Проверяется наличие файлов на диске и соответствие заголовков. 
	*
	* @deprecated В данный момент не используется, фунционал метода реализован в ImportCSV::findFiles()
	*
	* @return boolean Возвращает true в случае если файлы удовлетворяют условиям, иначе false
	*/
	private static function checkFiles()
	{
		if(self::$fullPath2Folder === '')
		{
			self::$fullPath2Folder = $_SERVER['DOCUMENT_ROOT'].Options::getOrderWorkFolder();	
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

	/**
	* Ищет файлы с данными для импорта.
	*
	* Из настроек модуля определяет папку предназначенную для импорта файлов. 
	* Ищет файлы с данными в заданной папке. При поиске файлы отбираются предварительно по расширению. 
	* Далее файлы проверяются на соответствие заголовку.
	*
	* @return boolean Возвращает true в случае успешного определения имен файлов, иначе false
	*/
	public static function findFiles() 
	{
		if(self::$fullPath2Folder === '')
		{
			self::$fullPath2Folder = $_SERVER['DOCUMENT_ROOT'].Options::getOrderWorkFolder();
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

		return false;
	}

	/**
	* Загружает данные в таблицы модуля.
	*
	* В соответствии с настройками модуля при загрузке может производиться перекодировка даннх из CP1251 в UTF-8.
	* В случае успешной загрузки данных файлы удаляются.
	*
	* @return string Возвращает строку содержащую PHP код, который будет использован при следующем запуске данной функции.
	*		  Подразумевается использование данного метода в качестве агента Bitrix. 
	*/
	static function loadData()
	{
		if(self::$fullPath2Folder === '')
		{
			self::$fullPath2Folder = $_SERVER['DOCUMENT_ROOT'].Options::getOrderWorkFolder();
		}
		setlocale(LC_ALL, 'ru_RU.utf8');

		if(self::findFiles())
		{
			OrderTable::clearTable();
			UsedPartsTable::clearTable();

			$handle = fopen('php://memory','w+');
			if(Options::isOrderEncodingEnable()) 
			{
				fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents(self::$fullPath2Folder.self::$orderFileName)));
			}
			else
			{
				fwrite($handle, file_get_contents(self::$fullPath2Folder.self::$orderFileName));
			}			
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
	
			$handle = fopen('php://memory','w+');
			if(Options::isOrderEncodingEnable()) 
			{
				fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents(self::$fullPath2Folder.self::$usedPartsFileName)));
			}
			else
			{
				fwrite($handle, file_get_contents(self::$fullPath2Folder.self::$usedPartsFileName));
			}
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
}
