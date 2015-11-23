<?php
namespace src;

class ComparingURLs {
	private $index;
	private $arrayOfFirstURL;
	private $arrayOfSecondURL;
	private $arrayOfConclusion;

	/**
	 * [Initialize all the properties]
	 */
	public function __construct() {
		$this->index				= 0;
		$this->arrayOfFirstURL		= array();
		$this->arrayOfSecondURL		= array();
		$this->arrayOfConclusion	= array();
	}

	/**
	 * [Uninitialize all the properties]
	 */
	public function __destruct() {
		unset($this->index);
		unset($this->arrayOfFirstURL);
		unset($this->arrayOfSecondURL);
		unset($this->arrayOfConclusion);
	}

	/**
	 * [Get contents of two URLs and compare the contents whether are same or different]
	 * @param  [string]  $URL1 [first URL]
	 * @param  [string]  $URL2 [second URL]
	 * @return [boolean]       [return true or false if two URLs are the same or different]
	 */
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
	
	/**
	 * [Get content of URL and assign into contentOfURL]
	 * @param [string]   $URL           [a URL of webpage]
	 * @param [string &] &$contentOfURL [a content of URL]
	 */
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

	/**
	 * [Retrieve a path of file which user just uploaded ]
	 * @return [string] $uploadedFilePath [retrieve a file path or null if a file uploads successfully or unsuccessfully]
	 */
	private function getFilePath() {
		$uploadedFilePath = "../uploads/" . basename($_FILES["fileInput"]["name"]);

		if ($this->uploadFile($uploadedFilePath) === true) {
			return $uploadedFilePath;
		} else {
			return null;
		}
	}

	/**
	 * [Assign "same" or "different" into property $arrayOfConclusion if contents of two URLs are same or different]
	 */
	private function getConclusions() {
		for ($i = 0; $i < $this->index; $i++) {
			if (!filter_var($this->arrayOfFirstURL[$i], FILTER_VALIDATE_URL) === false && !filter_var($this->arrayOfSecondURL[$i], FILTER_VALIDATE_URL) === false) {
				if ($this->compareURLs($this->arrayOfFirstURL[$i], $this->arrayOfSecondURL[$i])) {
					$this->arrayOfConclusion[$i] = "same";
				} else {
					$this->arrayOfConclusion[$i] = "different";
				}
			} else {
				$this->arrayOfConclusion[$i] = "Not validated URL";
			}
		}
	}

	/**
	 * [Move file which user just uploaded to a specific path]
	 * @param  [string]  $uploadedFilePath [the specific file path which you assigned]
	 * @return [boolean]                   [return true or false if file moves to specific path successfully or unsuccessfully]
	 */
	private function uploadFile($uploadedFilePath) {
		if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $uploadedFilePath) === true) {
			return true;
		} else {
			echo "Sorry, there was an error uploading your file.";
			return false;
		}
	}

	/**
	 * [Only compare two URLs]
	 * @param  [string] $firstURL  [first URL]
	 * @param  [string] $secondURL [second URL]
	 */
	public function compareTwoURLs($firstURL, $secondURL) {
		$this->index 				= 1;
		$this->arrayOfFirstURL[0]	= $firstURL;
		$this->arrayOfSecondURL[0]	= $secondURL;
		$this->getConclusions();
	}

	/**
	 * [Compare a list of URLs from HTML file]
	 */
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

	/**
	 * [Compare a list of URLs from CSV file]
	 */
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

	/**
	 * [Return the results after comparing contents]
	 * @return [array] [combine three arrays into one array]
	 */
	public function getResults() {
		return array('firstURL' => $this->arrayOfFirstURL, 'secondURL' => $this->arrayOfSecondURL, 'conclusion' => $this->arrayOfConclusion);
	}
}