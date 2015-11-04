<?php

function comparingURLs($URL1, $URL2) {
	$sourceCodeOfURL1 = "";
	$sourceCodeOfURL2 = "";

	getSourceCode($URL1, $sourceCodeOfURL1);
	getSourceCode($URL2, $sourceCodeOfURL2);
	
	if (strcmp($sourceCodeOfURL1, $sourceCodeOfURL2) !== 0) {
		echo "$URL1 and $URL2 are different.";
	}
}

function getSourceCode($URL, &$sourceCodeOfURL) {
	$curl = curl_init($URL);
	curl_setopt($curl, CURLOPT_FAILONERROR,		true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION,	true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,	true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,	false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,	false);
	$sourceCodeOfURL = curl_exec($curl);
	curl_close($curl);
}

function uploadFile($uploadedFilePath) {
	if (move_uploaded_file($_FILES["file_input"]["tmp_name"], $uploadedFilePath) === true) {
		return true;
	} else {
		echo "Sorry, there was an error uploading your file.";
		return false;
	}
}

function getFilePath() {
	$uploadedFilePath = "../uploads/" . basename($_FILES["file_input"]["name"]);

	if (uploadFile($uploadedFilePath) === true) {
		return $uploadedFilePath;
	} else {
		return null;
	}
}