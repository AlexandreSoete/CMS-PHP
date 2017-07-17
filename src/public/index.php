<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';


$config = [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'cms',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
];


$app = new \Slim\App(['settings' => $config]);

require '../app/container.php';



$app->group('/admin', function () {
    $this->get('', \App\Controllers\AdminController::class . ':index')->setName('admin');
    $this->get('/pages', \App\Controllers\AdminController::class . ':pages')->setName('admin.page');
    $this->get('/pages/{slug}/', \App\Controllers\AdminController::class. ':showPage')->setName('admin.showpage');

    $this->post('/setPositionLabel', \App\Controllers\AdminController::class.':setPositionLabel');
    $this->post('/addPositionLabel', \App\Controllers\AdminController::class.':addPositionLabel');
    $this->post('/deletePositionLabel', \App\Controllers\AdminController::class.':deletePositionLabel');

    $this->post('/saveValueLabel', \App\Controllers\AdminController::class.':saveValueLabel');

});


$app->run();