<?IncludeModuleLangFile(__FILE__);?>

<form action="<?echo $APPLICATION->GetCurPage()?>">
	<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?=LANGUAGE_ID?>">
	<input type="hidden" name="id" value="rele.vdo">
	<input type="hidden" name="install" value="Y">
	<input type="hidden" name="step" value="2">
	<?echo CAdminMessage::ShowMessage(GetMessage('MOD_INSTALL'));?>

	<p><?=GetMessage('VDO_YOU_CAN_INSTALL_SAMPLE');?></p>
	<p>
		<input type="checkbox" name="sampledata" id="sampledata" value="Y">
		<label for="sampledata"><?=GetMessage('VDO_INSTALL_SAMPLE');?></label>
	</p>
	<input type="submit" name="inst" value="<?echo GetMessage('MOD_INSTALL_BUTTON')?>">
</form>