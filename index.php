<?php
	require 'vendor/autoload.php';
	$app = new \Slim\Slim();

	$app->get("/health",function() use ($app){
		echo "Good ! from Slim ";
	} );

	$app->run();
