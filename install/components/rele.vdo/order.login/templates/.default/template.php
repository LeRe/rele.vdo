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

<div class="vdo-orderlogin">
	<?=GetMessage('VDO_CHECK_REPAIR_STATUS')?><br>
	<form method="get" action="<?=$arResult['PATH']?>">
		<div class="vdo-orderlogin-number" style="float: left;"><?=GetMessage('VDO_ORDER_NUMBER')?> 
			<input type="text" size="5" maxlength="5" pattern="\d{1,5}" name="vdonumber">
		</div>
		<div class="vdo-orderlogin-customer" style="float: left; margin: 0px 10px;"><?=GetMessage('VDO_CUSTOMER')?> 
			<input type="text" size="20" maxlength="50" name="vdocustomer">
		</div> 
		<div class="vdo-orderlogin-submit"><input type="submit" value="Проверить"></div>
	</form>
</div>