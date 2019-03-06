<?php
	class TransactionItem extends AppModel{
		public $belongsTo = array('Member');
    public $hasMany = array(
      'Transaction' => array(
        'conditions' => array(
            'Transaction.valid' => 1
          )
        )
      );
	}