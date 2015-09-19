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
	<form action="<?=$arResult['PATH']?>">
		<div class="vdo-orderlogin-number">
			<?=GetMessage('VDO_ORDER_NUMBER')?> <input size="5" maxlength="5" pattern="\d{1,5}" name="vdonumber" type="text">
		</div>
		<div class="vdo-orderlogin-customer">
			<?=GetMessage('VDO_CUSTOMER')?> <input size="20" maxlength="50" name="vdocustomer" type="text">
		</div>
		<div class="vdo-orderlogin-submit">
			<input  value="Проверить" type="submit">
		</div>
	</form>
</div>
<br>