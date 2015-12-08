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
			$comparingURLs->setTwoURLs($app->request->post("URL1"), $app->request->post("URL2"));
		}
	} else {
		if (strlen(basename($_FILES["fileInput"]["name"])) !== 0) {
			$filePath = "../uploads/" . basename($_FILES["fileInput"]["name"]);
			if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $filePath)) {
				if (strcmp(basename($_FILES["fileInput"]["type"]), "vnd.ms-excel") === 0) {
					$comparingURLs->setListOfURLsFromCSV($filePath);
				} else {
					$comparingURLs->setListOfURLsFromHTML($filePath);
				}
			}
		}
	}
	$app->render('conclusions.php', $comparingURLs->getConclusions());

	unset($comparingURLs);
});

$app->run();