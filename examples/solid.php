<?php
//Функциональные требования.
//1. Формирование отчета. Пользователь системы имеет возможность сформировать отчет по заказам 
//с отображением информации о дата заказа, кол-ве позиций, сумме заказа, валюте
//2. Отображение отчета на экране. Пользователь может увидеть результат отчета в виде таблицы на экране 
//не функциональные требования
//Необходима возможность в дальнейшем печатать в другие форматы например csv,json


//Domain Api

namespace Domain;

interface ReportProcess {

	public function process(array $orders);
}

class Report {

	protected $driver;

	function __construct(ReportProcess $driver) {
		$this->driver = $driver;
	}

	public function createByOrders(array $orders) {
		return $this->driver->process($orders);
	}

}

class Order {

	protected $id;

	protected $date;

	protected $summ;

	protected $posCount;

	protected $currency;

	function __construct($id, $date, $summ, $posCount, $currency) {
		$this->id		 = $id;
		$this->date		 = $date;
		$this->summ		 = $summ;
		$this->posCount	 = $posCount;
		$this->currency	 = $currency;
	}

	public function getId() {
		return $this->id;
	}

	public function getDate() {
		return $this->date;
	}

	public function getsumm() {
		return $this->summ;
	}

	public function getPosCount() {
		return $this->posCount;
	}

	public function getcurrency() {
		return $this->currency;
	}

}

//My Project

namespace Project;

class OrderFactory {

	public function createDemoList() {
		return [
			new \Domain\Order(1, "2018-05-30", 112, 5, "RUR"),
			new \Domain\Order(2, "2018-05-25", 1474, 10, "RUR"),
			new \Domain\Order(3, "2018-05-26", 1701, 19, "RUR")
		];
	}

}

class ReportHtml implements \Domain\ReportProcess {

	public function process(array $orders) {
		
		$html = "<table style=\"border:1px solid #ccc\">";
		
		foreach ($orders as $order) {
			$html .= sprintf(
					"<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", 
					$order->getId(), 
					$order->getdate(),
					$order->getSumm(), 
					$order->getposCount(),
					$order->getCurrency()
			);
		}
		
		$html .= "</table>";
		
		return $html;
	}

}

class ReportSerialize implements \Domain\ReportProcess{
	
	public function process(array $orders) {
		//var_dump($orders);
		return serialize($orders);
	}
	
}

$orderFactory	 = new OrderFactory();
$report			 = new \Domain\Report( new ReportSerialize() );
//get list
$orders			 = $orderFactory->createDemoList();
//create report
$result			 = $report->createByOrders($orders);


echo $result;
