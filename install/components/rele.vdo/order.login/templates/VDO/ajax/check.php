<?
require ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$answer = array('orderExist' => false);

if(isset($_REQUEST['vdonumber']) and  isset($_REQUEST['vdocustomer'])) 
{
	$orderNumber = $_REQUEST['vdonumber'];
	$orderCustomer = $_REQUEST['vdocustomer'];

	if(CModule::IncludeModule('rele.vdo'))
	{
		$row = Rele\Vdo\OrderTable::getRow(array(
		    'filter' => array(
		    				'ORDER_NUMBER' => $orderNumber,
							'CUSTOMER' => $orderCustomer
						)
		));	
		if($row != null){
			$answer['orderExist'] = true;
		}
	}	
}

echo json_encode($answer);

require ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');