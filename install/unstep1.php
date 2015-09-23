<?IncludeModuleLangFile(__FILE__);?>

<form action="<?echo $APPLICATION->GetCurPage()?>">
	<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?=LANGUAGE_ID?>">
	<input type="hidden" name="id" value="rele.vdo">
	<input type="hidden" name="uninstall" value="Y">
	<input type="hidden" name="step" value="2">
	<?echo CAdminMessage::ShowMessage(GetMessage('MOD_UNINST_WARN'));?>
	<p><?=GetMessage('VDO_YOU_CAN_SAVE');?></p>
	<p>
		<input type="checkbox" name="savedata" id="savedata" value="Y" checked>
		<label for="savedata"><?=GetMessage('VDO_SAVE_TABLES');?></label>
	</p>
	<input type="submit" name="inst" value="<?echo GetMessage('MOD_UNINST_DEL')?>">
</form>