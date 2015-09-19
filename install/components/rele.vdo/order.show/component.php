<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$arResult['ERROR'] = '';
if(isset( $_REQUEST['vdonumber']) && isset($_REQUEST['vdocustomer']) ) {

	$orderNumber = trim($_REQUEST['vdonumber']);
	$orderCustomer = trim($_REQUEST['vdocustomer']);

	if($orderNumber == '' || $orderCustomer == '' )
	{
		//Input parameters must have a value
		//TODO Переделать через arResult и шаблон, добавить в order.login javascript проверку заполнения полей
		$arResult['ERROR'] = GetMessage('VDO_NECESSARY_NUMBER_CUSTOMER');
	}
	else
	{
		if(CModule::IncludeModule('rele.vdo'))
		{
			$row = Rele\Vdo\OrderTable::getRow(array(
			    'filter' => array(
			    				'ORDER_NUMBER' => $orderNumber,
								'CUSTOMER' => $orderCustomer
								)
			));
		
			if(isset($row['ORDER_NUMBER'])){
				$arResult['ORDER_NUMBER'] = $row['ORDER_NUMBER']; 
			}
			if(isset($row['CUSTOMER'])){
				$arResult['ORDER_CUSTOMER'] = $row['CUSTOMER'];
			}
			if(isset($row['ORDER_DATE'])){
				$arResult['ORDER_DATE'] = $row['ORDER_DATE'];
			}
			if(isset($row['READY_DATE'])){
				$arResult['ORDER_READY_DATE'] = $row['READY_DATE'];
			}
			if(isset($row['OUT_DATE'])){
				$arResult['ORDER_OUT_DATE'] = $row['OUT_DATE'];
			}
			if(isset($row['CUSTOMER_ALERT'])){
				$arResult['ORDER_CUSTOMER_ALERT'] = $row['CUSTOMER_ALERT'];
			}
			if(isset($row['EQUIPMENT'])){
				$arResult['ORDER_EQUIPMENT'] = $row['EQUIPMENT'];
			}
			if(isset($row['REASON'])){
				$arResult['ORDER_REASON'] = $row['REASON'];
			}
			if(isset($row['ENGINEER'])){
				$arResult['ORDER_ENGINEER'] = $row['ENGINEER'];
			}

			if(isset($arResult['ORDER_READY_DATE']))
			{
				if($arResult['ORDER_READY_DATE'] == '')
				{
					$arResult['ORDER_READY_DATE'] = GetMessage('VDO_NO');
				}
				else
				{
					$arResult['ORDER_READY_DATE'] = GetMessage('VDO_YES').', '.$arResult['ORDER_READY_DATE'];	
				}
			}

			if(isset($arResult['ORDER_OUT_DATE']))
			{
				if($arResult['ORDER_OUT_DATE'] == '')
				{
					$arResult['ORDER_OUT_DATE'] = GetMessage('VDO_NO');
				}
				else
				{
					$arResult['ORDER_OUT_DATE'] = GetMessage('VDO_YES').', '.$arResult['ORDER_OUT_DATE'];	
				}
			}	

			if(isset($arResult['ORDER_CUSTOMER_ALERT']))
			{
				if($arResult['ORDER_CUSTOMER_ALERT'] == 1) 
				{
					$arResult['ORDER_CUSTOMER_ALERT'] = GetMessage('VDO_NOTIFIED');
				}
				elseif($arResult['ORDER_CUSTOMER_ALERT'] == 0)
				{
					$arResult['ORDER_CUSTOMER_ALERT'] = GetMessage('VDO_NOT_NOTIFIED');
				}
			}

			if(isset($arResult['ORDER_NUMBER']))
			{
				$arOrder = Array(
						'POSITION_NUMBER' => 'ASC'
					);
				$arSelect = Array(
					"ORDER_NUMBER",
					"POSITION_NUMBER",
					"NOMENCLATURE",
					"AMOUNT",
					"COST",
					"SUM",
					"VAT"
					);
				$arFilter = Array(
						'ORDER_NUMBER' => $arResult['ORDER_NUMBER']
					);

				$result = Rele\Vdo\UsedPartsTable::getList(
					array(
						    'filter' => $arFilter,
						    'select' => $arSelect,
						    'order' => $arOrder
						));
					
				while($row = $result->fetch())
				{
					$arResult['USED_PARTS'][$row['POSITION_NUMBER']]['POSITION_NUMBER'] = $row['POSITION_NUMBER'];
					$arResult['USED_PARTS'][$row['POSITION_NUMBER']]['NOMENCLATURE'] = $row['NOMENCLATURE'];
					$arResult['USED_PARTS'][$row['POSITION_NUMBER']]['AMOUNT'] = $row['AMOUNT'];
					$arResult['USED_PARTS'][$row['POSITION_NUMBER']]['COST'] = $row['COST'];
					$arResult['USED_PARTS'][$row['POSITION_NUMBER']]['SUM'] = $row['SUM'];
					$arResult['USED_PARTS'][$row['POSITION_NUMBER']]['VAT'] = $row['VAT'];
				}

				$arResult['SUM'] = 0;
				$arResult['VAT'] = 0;
				foreach ($arResult['USED_PARTS'] as $value) {
					$arResult['SUM'] += $value['SUM'];
					$arResult['VAT'] += $value['VAT'];
				}
			}
			else
			{
				$arResult['ERROR'] = GetMessage('VDO_NOT_FOUND_NUMBER_CUSTOMER');
			}	
		}
	}

	$this->IncludeComponentTemplate();
}