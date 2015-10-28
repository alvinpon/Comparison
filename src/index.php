<?php
require '../vendor/autoload.php';

$app = new \Slim\Slim();
$app->get('/', 'renderIndex');
$app->get('/test.php', 'renderTest');
$app->run();

function renderIndex() {
	echo "<!DOCTYPE html>";
	echo "<html>";
	echo "<head>";
	echo "<title>Index</title>";
	echo "</head>";
	echo "<body>";
	echo "Index";
	echo "</body>";
	echo "</html>";	
}

function renderTest() {
	echo "<!DOCTYPE html>";
	echo "<html>";
	echo "<head>";
	echo "<title>Test</title>";
	echo "</head>";
	echo "<body>";
	echo "Test";
	echo "</body>";
	echo "</html>";
}