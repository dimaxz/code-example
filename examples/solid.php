<?php

//пользователь системы имеет возможность сформировать отчет по заказам 
//с отображением информации о дата заказа, кол-ве позиций, сумме заказа, валюте
//отчет в виде таблицы на экране с дальнейшей возможностю печатать в другие форматы
//пользователь системы
//отчет (сформировать отчет)
//заказ

//Domain Api
namespace Domain;
class Report{
    
    public function createByOrders(array $orders){
     
        $html = "<table>";
        foreach($orders as $order){
            $html .= sprintf(
                "<tr><td>%s</td><td>%s</td></tr>",
                $order->getId(),
                $order->getdate()
                );
        }    
        $html .= "</table>";
        return $html; 
    }
    
}

class Order{
    protected $id;
    protected $date;
    protected $summ;
    protected $posCount;
    protected $currency;
    
    function __construct($id,$date,$summ,$posCount,$currency){
        $this->id = $id;
        $this->date = $date;
        $this->summ = $summ;
        $this->posCount = $posCount;
        $this->currency = $currency;
    }
    
    public function getId(){
        return $id;
    }   
    public function getDate(){
        return $date;
    }   
    public function getsumm(){
        return $summ;
    }   
    public function getPosCount(){
        return $posCount;
    }   
    public function getcurrency(){
        return $currency;
    }   
}

//My Project
namespace Project;
class OrderFactory{
    
    public function createDemoList(){
        return [
            new \Domain\Order(1,"2018-05-30",112,5,"RUR"),
            new \Domain\Order(2,"2018-05-25",1474,10,"RUR")
            ];
    }
    
}

$orderFactory = new OrderFactory();
$report = new \Domain\Report;

//get list
$orders = $orderFactory->createDemoList();


//create report
$result = $report->createByOrders($orders);
var_dump($result);

