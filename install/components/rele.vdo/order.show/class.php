<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Application;

class COrderShow extends CBitrixComponent
{
	public function executeComponent()
	{
		$app = Application::getInstance();
		$context = $app->getContext();
		$request = $context->getRequest();

		$this->arResult['ERROR'] = '';
		if(isset($request['vdonumber']) && isset($request['vdocustomer']) ) {

			$orderNumber = trim($request['vdonumber']);
			$orderCustomer = trim($request['vdocustomer']);

			if($orderNumber == '' || $orderCustomer == '' )
			{
				//Input parameters must have a value
				$this->arResult['ERROR'] = GetMessage('VDO_NECESSARY_NUMBER_CUSTOMER');
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
						$this->arResult['ORDER_NUMBER'] = $row['ORDER_NUMBER']; 
					}
					if(isset($row['CUSTOMER'])){
						$this->arResult['ORDER_CUSTOMER'] = $row['CUSTOMER'];
					}
					if(isset($row['ORDER_DATE'])){
						$this->arResult['ORDER_DATE'] = $row['ORDER_DATE'];
					}
					if(isset($row['READY_DATE'])){
						$this->arResult['ORDER_READY_DATE'] = $row['READY_DATE'];
					}
					if(isset($row['OUT_DATE'])){
						$this->arResult['ORDER_OUT_DATE'] = $row['OUT_DATE'];
					}
					if(isset($row['CUSTOMER_ALERT'])){
						$this->arResult['ORDER_CUSTOMER_ALERT'] = $row['CUSTOMER_ALERT'];
					}
					if(isset($row['EQUIPMENT'])){
						$this->arResult['ORDER_EQUIPMENT'] = $row['EQUIPMENT'];
					}
					if(isset($row['REASON'])){
						$this->arResult['ORDER_REASON'] = $row['REASON'];
					}
					if(isset($row['ENGINEER'])){
						$this->arResult['ORDER_ENGINEER'] = $row['ENGINEER'];
					}

					if(isset($this->arResult['ORDER_READY_DATE']))
					{
						if($this->arResult['ORDER_READY_DATE'] == '')
						{
							$this->arResult['ORDER_READY_DATE'] = GetMessage('VDO_NO');
						}
						else
						{
							$this->arResult['ORDER_READY_DATE'] = GetMessage('VDO_YES').', '.$this->arResult['ORDER_READY_DATE'];	
						}
					}

					if(isset($this->arResult['ORDER_OUT_DATE']))
					{
						if($this->arResult['ORDER_OUT_DATE'] == '')
						{
							$this->arResult['ORDER_OUT_DATE'] = GetMessage('VDO_NO');
						}
						else
						{
							$this->arResult['ORDER_OUT_DATE'] = GetMessage('VDO_YES').', '.$this->arResult['ORDER_OUT_DATE'];	
						}
					}	

					if(isset($this->arResult['ORDER_CUSTOMER_ALERT']))
					{
						if($this->arResult['ORDER_CUSTOMER_ALERT'] == 1) 
						{
							$this->arResult['ORDER_CUSTOMER_ALERT'] = GetMessage('VDO_NOTIFIED');
						}
						elseif($this->arResult['ORDER_CUSTOMER_ALERT'] == 0)
						{
							$this->arResult['ORDER_CUSTOMER_ALERT'] = GetMessage('VDO_NOT_NOTIFIED');
						}
					}

					if(isset($this->arResult['ORDER_NUMBER']))
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
								'ORDER_NUMBER' => $this->arResult['ORDER_NUMBER']
							);

						$result = Rele\Vdo\UsedPartsTable::getList(
							array(
								    'filter' => $arFilter,
								    'select' => $arSelect,
								    'order' => $arOrder
								));
							
						while($row = $result->fetch())
						{
							$this->arResult['USED_PARTS'][$row['POSITION_NUMBER']]['POSITION_NUMBER'] = $row['POSITION_NUMBER'];
							$this->arResult['USED_PARTS'][$row['POSITION_NUMBER']]['NOMENCLATURE'] = $row['NOMENCLATURE'];
							$this->arResult['USED_PARTS'][$row['POSITION_NUMBER']]['AMOUNT'] = $row['AMOUNT'];
							$this->arResult['USED_PARTS'][$row['POSITION_NUMBER']]['COST'] = $row['COST'];
							$this->arResult['USED_PARTS'][$row['POSITION_NUMBER']]['SUM'] = $row['SUM'];
							$this->arResult['USED_PARTS'][$row['POSITION_NUMBER']]['VAT'] = $row['VAT'];
						}

						$this->arResult['SUM'] = 0;
						$this->arResult['VAT'] = 0;
						foreach ($this->arResult['USED_PARTS'] as $value) {
							$this->arResult['SUM'] += $value['SUM'];
							$this->arResult['VAT'] += $value['VAT'];
						}
					}
					else
					{
						$this->arResult['ERROR'] = GetMessage('VDO_NOT_FOUND_NUMBER_CUSTOMER');
					}	
				}
			}

			$this->IncludeComponentTemplate();
		}
	}
}
