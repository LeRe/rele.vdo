<?
namespace Rele\Vdo;

/*
*  Класс для работы с инфоблоками. Его методы позволяют создавать, удалять и проверять 
*  существование инфоблоков необходимых для работы модуля 
*
*  С переходом на таблицы этот класс и его методы потеряли актуальность.
*  
*  Работоспособность после перехода на намеспейсы НЕ ПРОВЕРЯЛАСЬ!!!
*
*  Требуется вынести сообщения в $MESS
*	
*/

class Iblocks 
{
	private function isTablesExist()
	{
		$orderIBlockID = 0;
		$usedPartsIBlockID = 0;
		if(CModule::IncludeModule("iblock"))
		{
			$iblocks = CIBlock::GetList(
					Array("SORT"=>"ASC"),
					Array(
							'TYPE' => 'vdo',
						)
				);
		   while($arIBlock = $iblocks->GetNext()) //цикл по всем блокам
		   {
				switch ($arIBlock['NAME']) {
					case 'Order':
						$orderIBlockID = $arIBlock['ID'];
						break;
					case 'usedParts':
						$usedPartsIBlockID = $arIBlock['ID'];
						break;					
				}
		   }
		}

		if($orderIBlockID && $usedPartsIBlockID)
		{
			//Сохраняем ID инфоблоков в опциях модуля
			COption::SetOptionInt('vdo', 'order_iblock_id', $orderIBlockID,
				'Идентификатор инфоблока содержащего информацию о заказ-нарядах');
			COption::SetOptionInt('vdo', 'usedparts_iblock_id', $usedPartsIBlockID,
				'Идентификатор инфоблока содержащего информацию о использованных материалах');
			return true;
		}
		else
		{
			return false;
		}
	}

	function createIBlocks() 
	{
		global $DB;
		if(CModule::IncludeModule("iblock"))
		{
			//Creating iBlock type
			$arFields = Array(
				'ID' => 'vdo',
				'SECTIONS' => 'Y',
				'IN_RSS' => 'N',
				'SORT' => 100,
				'LANG' => Array(
					'en' => Array(
							'NAME' => 'VDO',
							'SECTION_NAME' => 'Sections',
							'ELEMENT_NAME' => 'Elements'
						),
					'ru' => Array(
							'NAME' => 'ВДО',
							'SECTION_NAME' => 'Разделы',
							'ELEMENT_NAME' => 'Элементы'
						)
					)
				);

			$obBlockType = new CIBlockType;
			$DB->StartTransaction();
			$res = $obBlockType->Add($arFields);
			if(!$res)
			{
				$DB->Rollback();
				echo 'Error: '.$obBlockType->LAST_ERROR.'<br>';
			}
			else
			{
				$DB->Commit();
			}

			//Привязка инфоблоков к сайту, необходимо сделать выбор
			$LID = array('s1');

			// iBlocks creating			
			$arFieldsOrder = Array(
				'ACTIVE' => 'Y',
				'NAME' => 'Order',
				'IBLOCK_TYPE_ID' => 'vdo',
				'LID' => $LID
				);

			$arFieldsUsedParts = Array(
				'ACTIVE' => 'Y',
				'NAME' => 'usedParts',
				'IBLOCK_TYPE_ID' => 'vdo',
				'LID' => $LID
				);

			$ib = new CIBlock;
			$orderIBlockID = $ib->Add($arFieldsOrder);
			$usedPartsIBlockID = $ib->Add($arFieldsUsedParts);

			//Добавить свойства для элементов 
			$ibp = new CIBlockProperty;

			$arFieldsName = Array(
					Array('Номер заказ-наряда','ORDER_NUMBER'),
					Array('Дата заказ-наряда','ORDER_DATE'),
					Array('Дата готовности','READY_DATE'),
					Array('Дата выдачи','OUT_DATE'),
					Array('Оповещение клиента','CUSTOMER_ALERT'),
					Array('Техника','EQUIPMENT'),
					Array('Заявленная неисправность','REASON'),	
					Array('Ответственный инженер','ENGINEER'),
					Array('Контрагент','CUSTOMER')
				);

			foreach ($arFieldsName as $value) {
				$arFields = Array(
						'NAME' => $value[0],
						'CODE' => $value[1],
						'IBLOCK_ID' => $orderIBlockID
					);
				$ibp->Add($arFields);
			}

			$arFieldsName = Array(
					Array('Номер заказ-наряда','ORDER_NUMBER'),
					Array('Номер','POSITION_NUMBER'),
					Array('Номенклатура','NOMENCLATURE'),
					Array('Количество','AMOUNT'),
					Array('Цена','COST'),
					Array('Сумма','SUM'),
					Array('НДС','VAT')
				);

			foreach ($arFieldsName as $value) {
				$arFields = Array(
						'NAME' => $value[0],
						'CODE' => $value[1],
						'IBLOCK_ID' => $usedPartsIBlockID
					);
				$ibp->Add($arFields);
			}
			//Сохраняем ID созданных инфоблоков в опциях модуля
			COption::SetOptionInt('vdo', 'order_iblock_id', $orderIBlockID,
				'Идентификатор инфоблока содержащего информацию о заказ-нарядах');
			COption::SetOptionInt('vdo', 'usedparts_iblock_id', $usedPartsIBlockID,
				'Идентификатор инфоблока содержащего информацию о использованных материалах');
		}
	}	

	function deleteIBlocks()
	{	
		global $DB;
		if(CModule::IncludeModule("iblock"))
		{
			//Delete iBlock type and all info blocks same type
			$DB->StartTransaction();
			if(!CIBlockType::Delete('vdo'))
			{
				$DB->Rollback();
				echo 'Delete iBlock type error!';
			}
			else
			{
				$DB->Commit();
			}					
			// Удаляем опции модуля в которых сохранены ID удаляемых инфоблоков
			//COption::RemoveOption('vdo', 'order_iblock_id');
			//COption::RemoveOption('vdo', 'usedparts_iblock_id');	
		}
	}	
}