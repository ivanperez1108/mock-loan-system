<?php
require '../vendor/autoload.php';

$f3 = \Base::instance();

$f3->config('../config.ini');
$f3->set('AUTOLOAD','../src/');

$db = DB::connectDB($f3);
$f3->set('DB', $db);
DB::prepareDatabase($f3);

$f3->route('GET /',
    function ($f3) {
        echo "This is a mock API, don't come here!";
    }
);

$f3->route('POST /create-loan', 'RouteHandler->createLoan');
$f3->route('GET /get-loan', 'RouteHandler->getLoan');
$f3->route('POST /update-loan', 'RouteHandler->updateLoan');

$f3->run();