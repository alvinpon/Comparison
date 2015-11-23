<?php

require '../vendor/autoload.php';

$app = new \Slim\Slim();

$app->get('/', function () use ($app) {
	$app->render('comparing.php');
});

$app->post('/compare', function () use ($app) {
	$comparingURLs = new \src\ComparingURLs();

	if ($app->request->post("optionsRadios") == "option1") {
		if (strlen($app->request->post("URL1")) !== 0 && strlen($app->request->post("URL2")) !== 0) {
			$comparingURLs->compareTwoURLs($app->request->post("URL1"), $app->request->post("URL2"));
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