<?
namespace Rele\Vdo;
use Bitrix\Main\Entity;

class UsedPartsTable extends TableUtils
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'vdo_used_parts';
	}

	public static function getMap()
	{
		return array(
				new Entity\IntegerField('ORDER_NUMBER',
					array(
							'primary' => true
						)
					),				
				new Entity\IntegerField('POSITION_NUMBER',
					array(
							'primary' => true
						)
					),
				new Entity\StringField('NOMENCLATURE'),
				new Entity\IntegerField('AMOUNT'),
				new Entity\FloatField('COST'),
				new Entity\FloatField('SUM'),
				new Entity\FloatField('VAT')
			);
	}

	public static function addSampleData()
	{
		self::add(array(
				'ORDER_NUMBER' => 594,
				'POSITION_NUMBER' => 1,
				'NOMENCLATURE' => 'Диагностика',
				'AMOUNT' => 1,
				'COST' => 400,
				'SUM' => 400,
				'VAT' => 61.02
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 1,
				'NOMENCLATURE' => 'Термопленка HP 1200 (1200)',
				'AMOUNT' => 1,
				'COST' => 1350,
				'SUM' => 1350,
				'VAT' => 205.93
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 2,
				'NOMENCLATURE' => 'RL1-0540/RL1-0542 Ролик под. бумаги LJ 1320',
				'AMOUNT' => 1,
				'COST' => 550,
				'SUM' => 550,
				'VAT' => 83.9
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 3,
				'NOMENCLATURE' => 'RM1-1298 Отделительная площадка HP 1320/1160(ориг)',
				'AMOUNT' => 1,
				'COST' => 600,
				'SUM' => 600,
				'VAT' => 91.53
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 4,
				'NOMENCLATURE' => 'Резиновый вал OEM HP LJ 1160/1320',
				'AMOUNT' => 1,
				'COST' => 950,
				'SUM' => 950,
				'VAT' => 144.92
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 5,
				'NOMENCLATURE' => 'RU5-0307 Шестерня привода HP 1320/1160 (oem)',
				'AMOUNT' => 1,
				'COST' => 350,
				'SUM' => 350,
				'VAT' => 53.39
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 6,
				'NOMENCLATURE' => 'Профилактика принтера A4 (900)',
				'AMOUNT' => 1,
				'COST' => 900,
				'SUM' => 900,
				'VAT' => 137.29
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 7,
				'NOMENCLATURE' => 'Профилактика дополнительной опции',
				'AMOUNT' => 1,
				'COST' => 300,
				'SUM' => 300,
				'VAT' => 45.76
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 8,
				'NOMENCLATURE' => 'Заправка картриджа 750',
				'AMOUNT' => 1,
				'COST' => 750,
				'SUM' => 750,
				'VAT' => 114.41
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'POSITION_NUMBER' => 9,
				'NOMENCLATURE' => 'Свч барабан HP 1160/1320 (Fuji)',
				'AMOUNT' => 1,
				'COST' => 650,
				'SUM' => 650,
				'VAT' => 99.15
			));
		self::add(array(
				'ORDER_NUMBER' => 612,
				'POSITION_NUMBER' => 1,
				'NOMENCLATURE' => 'Ремонт USB порта',
				'AMOUNT' => 1,
				'COST' => 500,
				'SUM' => 500,
				'VAT' => 76.27
			));
	}	
}