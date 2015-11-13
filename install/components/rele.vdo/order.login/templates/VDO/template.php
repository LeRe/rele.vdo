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

<div id="vdo-orderLogin-popup" style="display:none;">
</div>

<script type="text/javascript">
	BX.message(
		{
			JS_VDO_NOT_ENOUGH_DATA: '<?=GetMessageJS('VDO_NOT_ENOUGH_DATA');?>',
			JS_VDO_ORDER_NOT_FOUND: '<?=GetMessageJS('VDO_ORDER_NOT_FOUND');?>',
		}
	);
	BX.ready(
		function(){
			vdo.componentPath = '<?=$arResult['COMPONENT_PATH']?>';
			var listenerVdoLoginForm = function(event)
					{
						vdo.buttonHandler(listenerVdoLoginForm);
					};
			BX.bind(BX("vdo-orderLogin-submit"), "click", 
				function(event)
				{
					event.preventDefault();
				}
			);	
			BX.bind(BX("vdo-orderLogin-submit"), "click", listenerVdoLoginForm);	
		});
</script>

<div class="vdo-orderLogin">
	<form name="vdoOrderLoginForm" action="<?=$arResult['PATH']?>">
		<div class="vdo-orderLogin-number">
			<?=GetMessage('VDO_ORDER_NUMBER')?> <input size="5" maxlength="5" pattern="\d{1,5}" name="vdonumber" type="text">
		</div>
		<div class="vdo-orderLogin-customer">
			<?=GetMessage('VDO_CUSTOMER')?> <input size="20" maxlength="50" name="vdocustomer" type="text">
		</div>
		<input  value="<?=GetMessage('VDO_CHECK')?>" type="submit" id="vdo-orderLogin-submit">
	</form>
</div>
<br>
