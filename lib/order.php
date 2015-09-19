<?
namespace Rele\Vdo;
use Bitrix\Main\Entity;

class OrderTable extends TableUtils
{	
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'vdo_orders';
	}

	public static function getMap()
	{
		return array(
				new Entity\IntegerField(
					'ORDER_NUMBER',
					array(
						'primary' => true
						)
					),
				new Entity\StringField('ORDER_DATE'),
				new Entity\StringField('READY_DATE'),					
				new Entity\StringField('OUT_DATE'),
				new Entity\StringField('CUSTOMER_ALERT'),
				new Entity\StringField('EQUIPMENT'),
				new Entity\StringField('REASON'),
				new Entity\StringField('ENGINEER'),
				new Entity\StringField('CUSTOMER')
			);
	}

	public static function addSampleData()
	{
		self::add(array(
				'ORDER_NUMBER' => 594,
				'ORDER_DATE' => '22.05.15',	
				'READY_DATE' => '25.05.15',	
				'OUT_DATE' => '25.05.15',
				'CUSTOMER_ALERT' => '0',
				'EQUIPMENT' => 'APC Back-UPS ES 700',
				'REASON' => 'Рабочий, максимально заменить батарею',
				'ENGINEER' => 'Лавров Николай Иванович',
				'CUSTOMER' => 'Калюжная София Ивановна'
			));
		self::add(array(
				'ORDER_NUMBER' => 606,
				'ORDER_DATE' => '25.05.15',	
				'READY_DATE' => '25.05.15',				
				'OUT_DATE' => '25.05.15',
				'CUSTOMER_ALERT' => '1',
				'EQUIPMENT' => 'HP LJ 1320n',
				'REASON' => 'Замена тернопленки',
				'ENGINEER' => 'Козырев Дмитрий Викторович',
				'CUSTOMER' => 'Группа компаний Энергокомплект МФ'
			));
		self::add(array(
				'ORDER_NUMBER' => 612,
				'ORDER_DATE' => '26.05.15',
				'READY_DATE' => '26.05.15',				
				'OUT_DATE' => '26.05.15',
				'CUSTOMER_ALERT' => '1',
				'EQUIPMENT' => 'Системный блок',
				'REASON' => '1. Заменить USB-порта на фронтоне (если возможно). 2. Установить серебристый кард-ридер вместо флоппи',
				'ENGINEER' => 'Морозов Михаил Юрьевич',
				'CUSTOMER' => 'Новоселов Василий Васильевич'
			));
	}	
}				