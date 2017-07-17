<?php


/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30/06/2017
 * Time: 20:26
 */
namespace App;


class Test
{
    public $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function index($request, $response, $args){
        $this->container->view->render($response, 'admin/profil.twig',[
            'name' => "Alex"
        ]);
    }
}