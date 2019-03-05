<?php

class FileUploadController extends AppController {
	public function index() {
		$this->set('title', __('File Upload Answer'));

		if ($this->request->is('post')) {
			if (!empty($this->data)) {
				if ($this->isValidCsvFile($this->data['FileUpload']['file']['type'])) {
					$data = $this->toArray($this->data['FileUpload']['file']['tmp_name']);
					$this->FileUpload->saveAll($data);

					$this->setSuccess('File Successfully Uploaded.');
				} else {
					$this->setError('Please upload a valid CSV file.');
				}
			} else{
				$this->setError('Please choose a file to upload.');
			}
		}

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
	}

	/**
	 * Transforms the csv file into array
	 *
	 * @param string $csvFile csv file tmp location
	 * @return json the json response required by datatables
	 */
	private function toArray($csvFile) {
		ini_set('auto_detect_line_endings', TRUE);

		$rows = array_map('str_getcsv', file($csvFile));
		$header = array_map('strtolower', array_shift($rows));
		return array_map(function($row) use($header) {
			return array_combine($header, $row);
		}, $rows);
	}

	/**
	 * Transforms the csv file into array
	 *
	 * @param string $mimeType the mimeType of the file
	 * @return boolean return true when valid mmimeType otherwise false
	 */
	private function isValidCsvFile($mimeType) {
		$validMimeTypes = array('application/vnd.ms-excel', 'text/csv');
		return in_array($mimeType, $validMimeTypes);
	}
}