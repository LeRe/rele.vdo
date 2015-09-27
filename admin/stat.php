<?
use Rele\Vdo\OrderTable;
use Rele\Vdo\UsedPartsTable;
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
Loc::loadMessages(__FILE__);
$APPLICATION->SetTitle(Loc::getMessage("VDO_TITLE"));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

if(Main\Loader::includeModule('rele.vdo')) {

    if(OrderTable::isTableExists() and UsedPartsTable::isTableExists())
    {
		$numRecordOrders = OrderTable::getCount();
		$numRecordUsedParts = UsedPartsTable::getCount();

		echo Loc::getMessage('VDO_TABLE_ORDERS').' '.$numRecordOrders.' '.Loc::getMessage('VDO_RECORDS');
		echo '<br>';
		echo Loc::getMessage('VDO_TABLE_USED_PARTS').' '.$numRecordUsedParts.' '.Loc::getMessage('VDO_RECORDS');
    }
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
