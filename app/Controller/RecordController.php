<?php
	class RecordController extends AppController{
	
		public $components = array('Paginator');
	
		public function index(){
			ini_set('memory_limit','256M');
			set_time_limit(0);

			$this->setFlash('Listing Record page too slow, try to optimize it.');

			$this->set('title',__('List Record'));
		}

		/**
		 * Retrieves the records list based on the information provided by the datatables
		 *
		 * @return json the json response required by datatables
		 */
		public function listings()
		{
			$this->autoRender = false;
			$this->Paginator->settings = $this->getPaginationSettings($this->data);
			$data = $this->Paginator->paginate('Record');
			$totalCount = $this->params->paging['Record']['count'];

			$pagination = array(
				"iTotalRecords" => $totalCount,
				"iTotalDisplayRecords" => $totalCount,
				"aaData" => $this->toDatatableData($data)
			);
			return json_encode($pagination);
		}

		/**
		 * Generates a pagination settings based on the POST params
		 *
		 * @param array $data The POST params
		 * @return array $settings Array of configuration settings.
		 */
		private function getPaginationSettings($data) {
			/**
			 * For the SQL part optimization, only select fields that are needed for the table on our view.
			 * Also change the type of the `name` field to VARCHAR and specify a length which is 15
			 * since the max name that we have as of the moment is 'Record 1000' that has length which is < 15.
			 * I'm assuming that `name` field should not be duplicated so we need to add index to it by making it
			 * a unique field 
			 */
			$sortDir = isset($data['sSortDir_0']) ? $data['sSortDir_0']: 'asc';
			$searchKeyword = isset($data['sSearch']) ? $data['sSearch'] : '';
			$limit = isset($data['iDisplayLength']) ? $data['iDisplayLength'] : 10;
			$page = isset($data['iDisplayStart']) ? $data['iDisplayStart'] : 1;
			$order = isset($data['iSortCol_0']) ? $data['iSortCol_0'] : '0';
			$orderList = array(
				'0' => array('Record.id' => $sortDir),
				'1' => array('Record.name' => $sortDir),
			);

			$settings = array(
				'fields' => array('Record.id', 'Record.name'),
				'limit' => $limit,
				'page' => $page,
				'order' => $orderList[$order],
				'recursive' => 0,
				'conditions' => array(
					array(
						'OR' => array(
							'Record.id LIKE' => "%{$searchKeyword}%",
							'Record.name LIKE' => "%{$searchKeyword}%"
						)
					)
				)
			);
			return $settings;
		}

		/**
		 * Transforms Model query results into an Array of records
		 *
		 * @param array $records Model query results
		 * @return array list of records with id and name only
		 */
		private function toDatatableData($records) {
			return array_map(function($record) {
				return array(
					$record['Record']['id'],
					$record['Record']['name']
				);
			}, $records);
		}
	}