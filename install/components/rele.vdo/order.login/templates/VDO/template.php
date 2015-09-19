<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<?CUtil::InitJSCore(Array('ajax','popup'));?>

<script type="text/javascript">
	BX.message(
		{
			JS_VDO_NOT_ENOUGH_DATA: '<?=GetMessageJS('VDO_NOT_ENOUGH_DATA');?>',
			JS_VDO_ORDER_NOT_FOUND: '<?=GetMessageJS('VDO_ORDER_NOT_FOUND');?>',
		}
	);
	vdo.componentPath = '<?=$arResult['COMPONENT_PATH']?>';
</script>

<div class="vdo-orderlogin">
	<form name="vdoOrderLoginForm" action="<?=$arResult['PATH']?>">
		<div class="vdo-orderlogin-number">
			<?=GetMessage('VDO_ORDER_NUMBER')?> <input size="5" maxlength="5" pattern="\d{1,5}" name="vdonumber" type="text">
		</div>
		<div class="vdo-orderlogin-customer">
			<?=GetMessage('VDO_CUSTOMER')?> <input size="20" maxlength="50" name="vdocustomer" type="text">
		</div>
		<div class="vdo-orderlogin-submit">
			<input  value="<?=GetMessage('VDO_CHECK')?>" type="button" onclick="vdo.buttonHandler();">
		</div>
	</form>
</div>
<br>