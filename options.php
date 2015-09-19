<?
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'rele.vdo');

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Text\String;

if(!$USER->IsAdmin())
{
	$APPLICATION->authForm(Array(Loc::getMessage("VDO_REQ_ADMIN"), 'ERROR'));
}

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

Loc::loadMessages($context->getServer()->getDocumentRoot()."/bitrix/modules/main/options.php");
Loc::loadMessages(__FILE__);

$arAllOptions = array(
	array("vat_included_default", GetMessage("VDO_VAT_INCLUDED_DEFAULT"), array("checkbox")),
);

$tabControl = new CAdminTabControl("tabControl", array(
		array(
				"DIV" => "edit1",
				"TAB" => Loc::getMessage("VDO_TAB_SETTINGS"), 
				"TITLE" => Loc::getMessage("VDO_TAB_TITLE_SETTINGS"),
			),
	));


CModule::IncludeModule(ADMIN_MODULE_NAME);

if($REQUEST_METHOD=="POST" && strlen($Update.$Apply.$RestoreDefaults) > 0 && check_bitrix_sessid())
{
	if(strlen($RestoreDefaults)>0)
	{
		foreach ($arAllOptions as $arOption) {
			$name = $arOption[0];
			COption::RemoveOption(ADMIN_MODULE_NAME, $name);
		}
		
	}
	else
	{
		foreach($arAllOptions as $arOption)
		{
			$name = $arOption[0];
			$val = trim($_REQUEST[$name], " \t\n\r");
			if($arOption[2][0]=="checkbox" && $val!="Y")
				$val="N";
			COption::SetOptionString(ADMIN_MODULE_NAME, $name, $val, $arOption[1]);

			if(Rele\Vdo\Options::isVatIncluded()) 
			{
				Rele\Vdo\Utils::setVatHandler();
			}
			else
			{
				Rele\Vdo\Utils::unSetVatHandler();
			}

		}
	}

	if(strlen($_REQUEST["back_url_settings"]) > 0)
	{
		if((strlen($Apply) > 0) || (strlen($RestoreDefaults) > 0))
			LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode(ADMIN_MODULE_NAME)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam());
		else
			LocalRedirect($_REQUEST["back_url_settings"]);
	}
	else
	{
		LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode(ADMIN_MODULE_NAME)."&lang=".urlencode(LANGUAGE_ID)."&".$tabControl->ActiveTabParam());
	}
}
?>

<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?echo LANG?>">
<?
$tabControl->Begin();
$tabControl->BeginNextTab();

foreach($arAllOptions as $arOption):
	$val = COption::GetOptionString(ADMIN_MODULE_NAME, $arOption[0]);
	$type = $arOption[2];
?>
	<tr>
		<td width="40%" nowrap <?if($type[0]=="textarea") echo 'class="adm-detail-valign-top"'?>>
			<label for="<?echo htmlspecialcharsbx($arOption[0])?>"><?echo $arOption[1]?>:</label>
		<td width="60%">
			<?if($type[0]=="checkbox"):?>
				<input type="checkbox" name="<?echo htmlspecialcharsbx($arOption[0])?>" id="<?echo htmlspecialcharsbx($arOption[0])?>" value="Y"<?if($val=="Y")echo" checked";?>>
			<?elseif($type[0]=="text"):?>
				<input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($arOption[0])?>" id="<?echo htmlspecialcharsbx($arOption[0])?>">
			<?elseif($type[0]=="textarea"):?>
				<textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialcharsbx($arOption[0])?>" id="<?echo htmlspecialcharsbx($arOption[0])?>"><?echo htmlspecialcharsbx($val)?></textarea>
			<?elseif($type[0]=="selectbox"):
				?><select name="<?echo htmlspecialcharsbx($arOption[0])?>"><?
				foreach ($type[1] as $key => $value)
				{
					?><option value="<?echo $key?>"<?if($val==$key)echo" selected"?>><?echo htmlspecialcharsbx($value)?></option><?
				}
				?></select><?
			endif?>
		</td>
	</tr>
	<?endforeach?>

<?$tabControl->Buttons();?>
	<input type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>" class="adm-btn-save">
	<input type="submit" name="Apply" value="<?=GetMessage("MAIN_OPT_APPLY")?>" title="<?=GetMessage("MAIN_OPT_APPLY_TITLE")?>">

	<?if(strlen($_REQUEST["back_url_settings"])>0):?>	
		<input type="button" name="Cancel" value="<?=GetMessage("MAIN_OPT_CANCEL")?>" title="<?=GetMessage("MAIN_OPT_CANCEL_TITLE")?>" onclick="window.location='<?echo htmlspecialcharsbx(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
		<input type="hidden" name="back_url_settings" value="<?=htmlspecialcharsbx($_REQUEST["back_url_settings"])?>">
	<?endif?>

	<input type="submit" name="RestoreDefaults" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" onclick="return confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>')" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">
	<?=bitrix_sessid_post();?>
<?$tabControl->End();?>
</form>