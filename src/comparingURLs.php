<?php
namespace src;

class ComparingURLs {
	private $index;
	private $arrayOfFirstURL;
	private $arrayOfSecondURL;
	private $arrayOfConclusion;

	/**
	 * [Initialize all properties]
	 */
	public function __construct() {
		$this->index				= 0;
		$this->arrayOfFirstURL		= array();
		$this->arrayOfSecondURL		= array();
		$this->arrayOfConclusion	= array();
	}

	/**
	 * [Uninitialize all properties]
	 */
	public function __destruct() {
		unset($this->index);
		unset($this->arrayOfFirstURL);
		unset($this->arrayOfSecondURL);
		unset($this->arrayOfConclusion);
	}

	/**
	 * [Get contents of two URLs and compare the contents whether they are same or different]
	 * @param  [string]  			$firstURL  [first URL]
	 * @param  [string]  			$secondURL [second URL]
	 * @return [boolean or string]             [return true or false if two URLs are the same or different or return "Invalid URL" if one of each URL is invalid URL]
	 */
	public function compareURLs($firstURL, $secondURL) {
		if (!filter_var($firstURL, FILTER_VALIDATE_URL) === false && !filter_var($secondURL, FILTER_VALIDATE_URL) === false) {
			$contentOfFirstURL	= "";
			$contentOfSecondURL	= "";

			$this->getContentOfURL($firstURL,	$contentOfFirstURL);
			$this->getContentOfURL($secondURL,	$contentOfSecondURL);

			if (strcmp($contentOfFirstURL, $contentOfSecondURL) === 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return "Invalid URL";
		}
	}

	/**
	 * [Assign "Same", "Different" or "Invalid URL" into $arrayOfConclusion if contents of two URLs are same or different or one of each URL is invalid URL
	 *  return the conclusions after comparing contents]
	 * @return [array] [combine three arrays into one array]
	 */
	public function getConclusions() {
		for ($i = 0; $i < $this->index; $i++) {
			if (!filter_var($this->arrayOfFirstURL[$i], FILTER_VALIDATE_URL) === false && !filter_var($this->arrayOfSecondURL[$i], FILTER_VALIDATE_URL) === false) {
				if ($this->compareURLs($this->arrayOfFirstURL[$i], $this->arrayOfSecondURL[$i])) {
					$this->arrayOfConclusion[$i] = "Same";
				} else {
					$this->arrayOfConclusion[$i] = "Different";
				}
			} else {
				$this->arrayOfConclusion[$i] = "Invalid URL";
			}
		}
		return array("arrayOfFirstURL" => $this->arrayOfFirstURL, "arrayOfSecondURL" => $this->arrayOfSecondURL, "arrayOfConclusion" => $this->arrayOfConclusion);
	}

	/**
	 * [Get content of URL and assign into $contentOfURL]
	 * @param   [string]   $URL           [a URL of webpage]
	 * @param 	[string &] $contentOfURL  [a content of URL]
	 * @return  [boolean]                 [return true or false if $URL is valid URL and $contentOfURL is string type or not]
	 */
	public function getContentOfURL($URL, &$contentOfURL) {
		if (!filter_var($URL, FILTER_VALIDATE_URL) === false && is_string($contentOfURL) === true) {
			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR,		true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION,	true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,	true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,	false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,	false);
			$contentOfURL = curl_exec($curl);
			curl_close($curl);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * [Set a list of URLs from CSV file]
	 * @param  [string]  $filePathOfCSV [a file path where you can find HTML file]
	 * @return [boolean]                [return true or false if $filePathOfCSV is a string type, this file exists and file extension is csv or not]
	 */
	public function setListOfURLsFromCSV($filePathOfCSV) {
		if (is_string($filePathOfCSV) && file_exists($filePathOfCSV) && strcmp(pathinfo($filePathOfCSV, PATHINFO_EXTENSION), "csv") === 0) {
			$arrayOfURL = str_getcsv(file_get_contents($filePathOfCSV), ",");
			for ($i = 0; $i < count($arrayOfURL); $i++) {
				if (($i % 2) === 0) {
					$this->arrayOfFirstURL[$this->index]	= $arrayOfURL[$i];
				} else {
					$this->arrayOfSecondURL[$this->index]	= $arrayOfURL[$i];
					$this->index++;
				}
			}
			unset($arrayOfURL);
			unlink($filePathOfCSV);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * [Set a list of URLs from HTML file]
	 * @param  [string]  $filePathOfHTML [a file path where you can find HTML file]
	 * @return [boolean]                 [return true or false if $filePathOfHTML is a string type, this file exists and file extension is html or not]
	 */
	public function setListOfURLsFromHTML($filePathOfHTML) {
		$flag = true;

		if (is_string($filePathOfHTML) && file_exists($filePathOfHTML) && strcmp(pathinfo($filePathOfHTML, PATHINFO_EXTENSION), "html") === 0) {
			$fileHandle = fopen($filePathOfHTML, "r");
			while (($line = fgets($fileHandle)) !== false) {
				if (stripos($line, "href=")) {
					$line = substr($line, strpos($line, "\"") + 1, strrpos($line, "\"") - strpos($line, "\"") - 1);
					if ($flag) {
						$this->arrayOfFirstURL[$this->index]	= $line;
					} else {
						$this->arrayOfSecondURL[$this->index]	= $line;
						$this->index++;
					}
					$flag = !$flag;
				}
			}
			fclose($fileHandle);
			unlink($filePathOfHTML);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * [Set two URLs]
	 * @param  [string] $firstURL  [first URL]
	 * @param  [string] $secondURL [second URL]
	 * @return [boolean]           [return true or false if $firstURL and $secondURL are valid URL or not]
	 */
	public function setTwoURLs($firstURL, $secondURL) {
		if (!filter_var($firstURL, FILTER_VALIDATE_URL) === false && !filter_var($secondURL, FILTER_VALIDATE_URL) === false) {
			$this->index 				= 1;
			$this->arrayOfFirstURL[0]	= $firstURL;
			$this->arrayOfSecondURL[0]	= $secondURL;
			return true;
		} else {
			return false;
		}
	}
}