<?php

class ComparingURLs {
	private $index;
	private $arrayOfFirstURL;
	private $arrayOfSecondURL;
	private $arrayOfConclusion;

	function __construct() {
		$this->index				= 0;
		$this->arrayOfFirstURL		= array();
		$this->arrayOfSecondURL		= array();
		$this->arrayOfConclusion	= array();
	}

	function __destruct() {
		unset($this->index);
		unset($arrayOfFirstURL);
		unset($arrayOfSecondURL);
		unset($arrayOfConclusion);
	}

	private function compareURLs($URL1, $URL2) {
		$contentOfURL1 = "";
		$contentOfURL2 = "";

		$this->getContentOfURL($URL1, $contentOfURL1);
		$this->getContentOfURL($URL2, $contentOfURL2);

		if (strcmp($contentOfURL1, $contentOfURL2) === 0) {
			return true;
		} else {
			return false;
		}
	}
	
	private function getContentOfURL($URL, &$contentOfURL) {
		$curl = curl_init($URL);
		curl_setopt($curl, CURLOPT_FAILONERROR,		true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION,	true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,	true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,	false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,	false);
		$contentOfURL = curl_exec($curl);
		curl_close($curl);
	}

	private function getFilePath() {
		$uploadedFilePath = "../uploads/" . basename($_FILES["fileInput"]["name"]);

		if ($this->uploadFile($uploadedFilePath) === true) {
			return $uploadedFilePath;
		} else {
			return null;
		}
	}

	private function getConclusions() {
		for ($i = 0; $i < $this->index; $i++) {
			if ($this->compareURLs($this->arrayOfFirstURL[$i], $this->arrayOfSecondURL[$i])) {
				$this->arrayOfConclusion[$i] = "same";
			} else {
				$this->arrayOfConclusion[$i] = "different";
			}
		}
	}

	private function uploadFile($uploadedFilePath) {
		if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $uploadedFilePath) === true) {
			return true;
		} else {
			echo "Sorry, there was an error uploading your file.";
			return false;
		}
	}

	public function compareTwoURLs() {
		$this->index 				= 1;
		$this->arrayOfFirstURL[0]	= $_POST["URL1"];
		$this->arrayOfSecondURL[0]	= $_POST["URL2"];
		$this->getConclusions();
	}

	public function compareListOfURLsFromHTML() {
		$flag			= true;
		$filePathOfHTML	= $this->getFilePath();
		$fileHandle		= fopen($filePathOfHTML, "r");

		if ($fileHandle) {
			while (($line = fgets($fileHandle)) !== false) {
				if (stripos($line, "href=")) {
					$line = substr($line, strpos($line, "\"") + 1, strrpos($line, "\"") - strpos($line, "\"") - 1);
					if ($flag) {
						$this->arrayOfFirstURL[$this->index] = $line;
					} else {
						$this->arrayOfSecondURL[$this->index] = $line;
						$this->index++;
					}

					$flag = !$flag;
				}
			}

			$this->getConclusions();

			fclose($fileHandle);
			unlink($filePathOfHTML);
		} else {
			echo "Can't find the file.";
		}
	}

	public function compareListOfURLsFromCSV() {
		$filePathOfCSV	= $this->getFilePath();
		$contentOfCVS	= file_get_contents($filePathOfCSV);
		$arrayOfURLs	= str_getcsv($contentOfCVS, ",");

		for ($i = 0; $i < count($arrayOfURLs); $i++) {
			if (($i % 2) === 0) {
				$this->arrayOfFirstURL[$this->index]	= $arrayOfURLs[$i];
			} else {
				$this->arrayOfSecondURL[$this->index]	= $arrayOfURLs[$i];
				$this->index++;
			}
		}

		$this->getConclusions();
		unset($arrayOfURLs);
		unlink($filePathOfCSV);
	}

	public function getResults() {
		return array('firstURL' => $this->arrayOfFirstURL, 'secondURL' => $this->arrayOfSecondURL, 'conclusion' => $this->arrayOfConclusion);
	}
}