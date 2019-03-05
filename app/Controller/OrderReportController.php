<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// debug($portions);exit;

			$order_reports = array_reduce($orders, function($acc, $order) use ($portions) {
				$orderName = $order['Order']['name'];
				$acc[$orderName] = array();
				foreach ($order['OrderDetail'] as $orderDetail) {
					$quantity = $orderDetail['quantity'];
					$filteredPortions = array_filter($portions, function ($portion) use ($orderDetail) {
						return $portion['Item']['name'] == $orderDetail['Item']['name'];
					});
	
					foreach ($filteredPortions as $portion) {
						foreach ($portion['PortionDetail'] as $portionDetail) {
							$ingredientName = $portionDetail['Part']['name'];
							$value = $portionDetail['value'] * $quantity;
							if(array_key_exists($ingredientName, $acc[$orderName])) {
								$acc[$orderName][$ingredientName] += $value;
							} else {
								$acc[$orderName][$ingredientName] = $value;
							} 
						}
					}
				} 
				return $acc;
			}, array());

			$this->set('order_reports', $order_reports);
			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}
	}