<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Rele\Vdo\ImportCSV;
use Rele\Vdo\OrderTable;
use Rele\Vdo\UsedPartsTable;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);
$APPLICATION->SetTitle(GetMessage("VDO_TITLE"));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>

<?
$actionReply = '';
$clearUri = '/bitrix/admin/vdo_mng_orders.php?vdo_action=clear&lang='.LANGUAGE_ID;
$loadUri = '/bitrix/admin/vdo_mng_orders.php?vdo_action=load&lang='.LANGUAGE_ID;

if(Main\Loader::includeModule('rele.vdo')) 
{
	if(isset($_REQUEST['vdo_action']) and ($_REQUEST['vdo_action'] == 'clear' or $_REQUEST['vdo_action'] == 'load'))
	{
			switch ($_REQUEST['vdo_action']) {
				case 'clear':
					OrderTable::clearTable();
					UsedPartsTable::clearTable();
					$actionReply = Loc::getMessage('VDO_TABLE_CLEAR');
					break;
				case 'load':
					ImportCSV::loadData();
					$actionReply = Loc::getMessage('VDO_ATTEMPT_LOAD_SUCCESSFUL');
					break;
			}		
	}

	$numRecordOrders = OrderTable::getCount();
}
?>

<?php if ($actionReply != ''): ?>
	<div style="padding: 20px; color: red;">
		<?=$actionReply?>
	</div>
<?php endif; ?>

<div style="padding: 20px;">
	<?=Loc::getMessage('VDO_TABLES_CONTAIN_INFORMATION')?> <?=$numRecordOrders?> <?=Loc::getMessage('VDO_ORDERS')?>
</div>

<div style="padding: 20px;">
	<input 
		type="button" 
		class="adm-btn" 
		value="<?=Loc::getMessage('VDO_CLEAR')?>" 
		title="<?=Loc::getMessage('VDO_CLEAR_ALT')?>"
		onclick="location.href = '<?=$clearUri?>';" 
	>
	<input 
		type="button" 
		class="adm-btn" 
		value="<?=Loc::getMessage('VDO_LOAD')?>" 
		title="<?=Loc::getMessage('VDO_LOAD_ALT')?>"
		onclick="location.href = '<?=$loadUri?>';"
	>
</div>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
