<?php

require '../vendor/autoload.php';
require 'functions.php';

$app = new \Slim\Slim();

$app->get('/', function () use ($app) {
	$app->render('comparing.php');
});

$app->post('/compare', function () use ($app) {
	$comparingURLs = new ComparingURLs();

	if ($_POST["optionsRadios"] == "option1") {
		if (strlen($_POST["URL1"]) !== 0 && strlen($_POST["URL2"]) !== 0) {
			$comparingURLs->compareTwoURLs();
		}
	} else {
		if (strlen(basename($_FILES["fileInput"]["name"])) !== 0) {
			if (basename($_FILES["fileInput"]["type"]) === "html") {
				$comparingURLs->compareListOfURLsFromHTML();
			} else {
				$comparingURLs->compareListOfURLsFromCSV();
			}
		}
	}
	$app->render('result.php', $comparingURLs->getResults());
	unset($comparingURLs);
});

$app->run();