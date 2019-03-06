<?php
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

	class MemberController extends AppController{
		
		public function index() {
			$this->set('title', __('Member Migration Form'));
		}

		public function upload_excel() {
      ini_set('memory_limit','256M');
      set_time_limit(0);

      $this->autoRender = false;
      $this->request->onlyAllow('ajax');

      if ($this->request->is('post')) {
        if ($this->isValidExcelFile($this->data['Member']['file']['type'])) {
          $this->migrateExcelToDb($this->data['Member']['file']['tmp_name']);
        } else {
          throw new BadRequestException('Invalid File');
        }
      } else {
        throw new MethodNotAllowedException();
      }
      return json_encode(array('data' => 'Migration Successful'));
    }

    /**
     * Reads excel file and migrate it to DB
     *
     * @param string $file excel file to be migrated
     */
    private function migrateExcelToDb($file) {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      $spreadsheet = $reader->load($file);
      $sheetData = $spreadsheet->getActiveSheet()->toArray();

      array_shift($sheetData);
      foreach ($sheetData as $key => $value) {
        list($memberType, $memberNo) = explode(' ', $value[3]);
        $date = DateTime::createFromFormat('d/m/Y', $value[0]);
        $this->Member->save(
          array(
            'name' => $value[2],
            'no' => $memberNo,
            'type' => $memberType,
            'company' => $value[5]
          )
        );

        $this->Member->Transaction->save(
          array(
            'member_id' => $this->Member->id,
            'member_name' => $value[2],
            'member_paytype' => $value[4],
            'member_company' => $value[5],
            'date' => $date->format('Y-m-d'),
            'year' => $date->format('Y'),
            'month' => $date->format('m'),
            'ref_no' => $value[1],
            'receipt_no' => $value[8],
            'payment_method' => $value[6],
            'batch_no' => $value[7],
            'cheque_no' => $value[9],
            'payment_type' => $value[10],
            'renewal_year' => $value[11],
            'subtotal' => $value[12],
            'tax' => $value[13],
            'total' => $value[14],
          )
        );

        $this->Member->Transaction->TransactionItem->save(
          array(
            'transaction_id' => $this->Member->Transaction->id,
            'description' => "Being Payment for : {$value[10]} : {$date->format('Y')}",
            'quantity' => 1,
            'unit_price' => $value[12],
            'sum' => $value[12],
            'table' => 'Member',
            'table_id' => $this->Member->id,
          )
        );

        $this->Member->Transaction->TransactionItem->clear();
        $this->Member->Transaction->clear();
        $this->Member->clear();
      }
    }
    
    /**
     * Check whether the mimeType is a valid Excel File
     *
     * @param string $mimeType the mimeType of the file
     * @return boolean return true when valid mmimeType otherwise false
     */
    private function isValidExcelFile($mimeType) {
      $validMimeTypes = array('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      return in_array($mimeType, $validMimeTypes);
    }
}
