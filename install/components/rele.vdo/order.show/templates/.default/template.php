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

<?if($arResult['ERROR'] != ''):?>
	<?=$arResult['ERROR']?>
<?else:?>
	<?=GetMessage('VDO_WORK_ORDER_NUMBER')?> <?=$arResult['ORDER_NUMBER']?> от <?=$arResult['ORDER_DATE']?>  <br>
	<?=GetMessage('VDO_READY')?> <?=$arResult['ORDER_READY_DATE']?> <?=GetMessage('VDO_ISSUED')?> <?=$arResult['ORDER_OUT_DATE']?>  <br>
	<?=GetMessage('VDO_CUSTOMER_NOTIFIED')?> <?=$arResult['ORDER_CUSTOMER_ALERT']?>  <br>
	<?=GetMessage('VDO_EQUIPMENT')?> <?=$arResult['ORDER_EQUIPMENT']?>  <br>
	<?=GetMessage('VDO_ALLEGED_DEFECT')?> <?=$arResult['ORDER_REASON']?>  <br>
	<?=GetMessage('VDO_CUSTOMER')?> <?=$arResult['ORDER_CUSTOMER']?>  <br>
	<?=GetMessage('VDO_RESPONSIBLE_ENGINEER')?> <?=$arResult['ORDER_ENGINEER']?>  <br>
	<?if(isset($arResult['USED_PARTS'])):?>
			<br><br>
			<?=GetMessage('VDO_SERVICES_PROVIDED')?>
			<table  border="1" style="border-collapse: collapse;">
				<tr>
					<td><?=GetMessage('VDO_NUMBER')?></td>
					<td><?=GetMessage('VDO_NOMENCLATURE')?></td>
					<td><?=GetMessage('VDO_QTY')?></td>
					<td><?=GetMessage('VDO_COST')?></td>
					<td><?=GetMessage('VDO_SUM')?></td>
					<td><?=GetMessage('VDO_INCLUDING_VAT')?></td>
				</tr>

				<?foreach($arResult['USED_PARTS'] as $value):?>
					<tr>
						<td><?=$value['POSITION_NUMBER']?></td>
						<td><?=$value['NOMENCLATURE']?></td>
						<td><?=$value['AMOUNT']?></td>
						<td><?=$value['COST']?></td>
						<td><?=$value['SUM']?></td>
						<td><?=$value['VAT']?></td>
					</tr>
				<?endforeach;?>
			</table>
			<?=GetMessage('VDO_TOTAL')?> <?=$arResult['SUM']?><br>
			<?=GetMessage('VDO_VAT')?> <?=$arResult['VAT']?>
	<?endif;?>
<?endif;?>