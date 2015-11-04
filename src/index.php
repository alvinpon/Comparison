<?php
// slim framework
require '../vendor/autoload.php';

require "./functions.php";

$app = new \Slim\Slim();
$app->get('/', 'renderIndex');
$app->get('/comparing.html', 'renderComparingHTML');
$app->post('/comparing.php', 'compare');
$app->run();

function renderIndex() {
	renderComparingHTML();
}

function renderComparingHTML() {
	echo "<!DOCTYPE html>";
	echo "<html>";
	echo "<head>";
		echo "<title>Comparing Source Code Of Different Two Pages</title>";
		echo "<meta charset=\"utf-8\">";
		echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
		echo "<link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\">";
	echo "</head>";
	echo "<body>";
		echo "<div class=\"container\">";
			echo "<h1>Comparing</h1>";
			echo "<form role=\"form\" action=\"comparing.php\" method=\"post\" enctype=\"multipart/form-data\">";

			echo "<div class=\"form-group\">";
				echo "<div class=\"radio\">";
					echo "<label>";
						echo "<input type=\"radio\" name=\"optionsRadios\" id=\"optionsRadios1\" value=\"option1\" checked>";
						echo "<strong>";
							echo "Enter URLs";
						echo "</strong>";
					echo "</label>";
				echo "</div>";
				echo "<div class=\"row\">";
					echo "<div class=\"col-lg-6\">";
						echo "<div class=\"input-group\">";
							echo "<div class=\"input-group-addon\">URL1</div>";
							echo "<input type=\"url\" class=\"form-control\" name=\"URL1\" id=\"URL1\" placeholder=\"Enter URL1\">";
						echo "</div>";
					echo "</div>";
					echo "<div class=\"col-lg-6\">";
						echo "<div class=\"input-group\">";
							echo "<div class=\"input-group-addon\">URL2</div>";
							echo "<input type=\"url\" class=\"form-control\" name=\"URL2\" id=\"URL2\" placeholder=\"Enter URL2\">";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

			echo "<div class=\"form_group\">";
				echo "<div class=\"radio\">";
					echo "<label>";
						echo "<input type=\"radio\" name=\"optionsRadios\" id=\"optionsRadios2\" value=\"option2\">";
						echo "<strong>";
							echo "Upload File (csv or html file.)";
						echo "</strong>";
					echo "</label>";

					echo "<input type=\"file\" name=\"file_input\" id=\"file_input\" accept=\".csv, .html\">";
				echo "</div>";
			echo "</div>";

			echo "<div class=\"form_group\">";
				echo "<button type=\"submit\" class=\"btn btn-default\" name=\"submit\">Submit</button>";
			echo "</div>";

			echo "</form>";
		echo "</div>";
	echo "</body>";
	echo "</html>";
}

function compare() {
	if ($_POST["optionsRadios"] == "option1") {
		if (strlen($_POST["URL1"]) !== 0 && strlen($_POST["URL2"]) !== 0) {
			comparingURLs($_POST["URL1"], $_POST["URL2"]);
		}
	} else {
		if (strlen(basename($_FILES["file_input"]["name"])) !== 0) {
			if (basename($_FILES["file_input"]["type"]) === "html") {
				$index			= 0;
				$arrayOfURLs	= array();
				$filePathOfHTML	= getFilePath();
				$fileHandle		= fopen($filePathOfHTML, "r");

				if ($fileHandle) {
					while (($line = fgets($fileHandle)) !== false) {
						if (stripos($line, "href=")) {
							$line = substr($line, strpos($line, "\"") + 1, strrpos($line, "\"") - strpos($line, "\"") - 1);
							$arrayOfURLs[$index] = $line;
							$index++;
						}
					}

					for ($i = 0; $i < count($arrayOfURLs); $i = $i + 2) { 
						comparingURLs($arrayOfURLs[$i], $arrayOfURLs[$i + 1]);
					}
					fclose($fileHandle);
				} else {
					echo "Can't find the file.";
				}
				unlink($filePathOfHTML);
			}
		}  else {
			$filePathOfCSV	= getFilePath(); 
			$contentOfCVS	= file_get_contents($filePathOfCSV);
			$arrayOfURLs	= str_getcsv($contentOfCVS, ",");

			for ($i = 0; $i < count($arrayOfURLs); $i = $i + 2) { 
				comparingURLs($arrayOfURLs[$i], $arrayOfURLs[$i + 1], $count);
			}
		}
	}
}