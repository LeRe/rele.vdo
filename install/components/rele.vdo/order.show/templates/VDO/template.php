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

<div class="bx_page vdo-order">
	<img style="float: right;" src="<?=$templateFolder?>/images/utilities.png" alt="" height="154" width="154">
	<?if($arResult['ERROR'] != ''):?>
		<?=$arResult['ERROR']?>
	<?else:?>
		<?=GetMessage('VDO_WORK_ORDER_NUMBER')?> <strong><?=$arResult['ORDER_NUMBER']?></strong>
		&nbsp;<?=GetMessage('VDO_FROM')?>&nbsp;<strong><?=$arResult['ORDER_DATE']?></strong>  <br>
		<?=GetMessage('VDO_READY')?>&nbsp;<strong><?=$arResult['ORDER_READY_DATE']?></strong>
		&nbsp;<?=GetMessage('VDO_ISSUED')?>&nbsp;<strong><?=$arResult['ORDER_OUT_DATE']?></strong>  <br>
		<?=GetMessage('VDO_CUSTOMER_NOTIFIED')?> <strong><?=$arResult['ORDER_CUSTOMER_ALERT']?></strong>  <br>
		<?=GetMessage('VDO_EQUIPMENT')?> <strong><?=$arResult['ORDER_EQUIPMENT']?></strong>  <br>
		<?=GetMessage('VDO_ALLEGED_DEFECT')?> <strong><?=$arResult['ORDER_REASON']?></strong>  <br>
		<?=GetMessage('VDO_CUSTOMER')?> <strong><?=$arResult['ORDER_CUSTOMER']?></strong>  <br>
		<?=GetMessage('VDO_RESPONSIBLE_ENGINEER')?> <strong><?=$arResult['ORDER_ENGINEER']?></strong>  <br>

		<?if(isset($arResult['USED_PARTS'])):?>
			<br>
			<strong><?=GetMessage('VDO_SERVICES_PROVIDED')?></strong>
			<table  class="table-style style-colorheader" cellspacing="0" cellpadding="0" border="0">
				<thead>
	                <tr>
	                    <th><?=GetMessage('VDO_NUMBER')?></th>
	                    <th><?=GetMessage('VDO_NOMENCLATURE')?></th>
	                    <th><?=GetMessage('VDO_QTY')?></th>
	                    <th><?=GetMessage('VDO_COST')?></th>
	                    <th><?=GetMessage('VDO_SUM')?></th>
	                </tr>
	            </thead>
	            <tbody>
				<?foreach($arResult['USED_PARTS'] as $value):?>
					<tr>
						<td><?=$value['POSITION_NUMBER']?></td>
						<td><?=$value['NOMENCLATURE']?></td>
						<td><?=$value['AMOUNT']?></td>
						<td><?=$value['COST']?></td>
						<td><?=$value['SUM']?></td>
					</tr>
				<?endforeach;?>
	            </tbody>
	            <tfoot>
	                <tr>
	                    <td colspan="4"><strong><?=GetMessage('VDO_TOTAL')?></strong></td>
	                    <td><strong><?=$arResult['SUM']?></strong></td>
	                </tr>
	            </tfoot>
			</table>
		<?endif;?>
	<?endif;?>
	<div class="clb"></div>
</div>