<?php
	class FormatController extends AppController{
		
		public function q1(){
			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
		}
		
		public function q1_detail() {
			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
		}

		public function q1_success() {
			// Redirect to q1 if no selection is found, usually this scenario will happen if the user manually
			// types in the q1_success url in the browser
			if (!isset($this->data['Type'])) {
				return $this->redirect(array("controller" => "format", "action" => "q1"));
			}
			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
		}
		
	}