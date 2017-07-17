<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/07/2017
 * Time: 00:14
 */
namespace App\Controllers;

use App\Models\ContentPage;
use App\Models\Labels;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AdminController
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


    public function index(RequestInterface $request, ResponseInterface $response){
        $this->container->view->render($response, 'admin/index.twig');
    }

    public function pages(RequestInterface $request, ResponseInterface $response){
        $pages = $this->container->db->table('pages')->get();

        $this->container->view->render($response, 'admin/pages.twig', array('pages' => $pages));
    }

    public function showPage(RequestInterface $request, ResponseInterface $response, $arg){

        $this->container->db;

        $pages = $this->container->db->table('pages')->where('slug_page', 'like', $arg['slug'])->get();
        $labels =   Labels::where('id_page', 'like', $pages[0]->id_pages)->orderBy('position_label', 'ASC')->get();



        $this->container->view->render($response, 'admin/showpages.twig', array('pages' => $pages[0], 'labels' => $labels));
    }

    public function setPositionLabel(RequestInterface $request, ResponseInterface $response, $arg){
        $data = $request->getParams();
        $data = json_decode($data['data']);

        $this->container->db;
        $label = null;
        foreach ($data as $k => $v){
            \App\Models\Labels::where('id_label', $k)->update(array('position_label' => (int)$v));
        }
    }

    public function addPositionLabel(RequestInterface $request, ResponseInterface $response){
        $data = $request->getParams();

        $lastPosition = $this->container->db->table('labels')->select('position_label')->orderBy('position_label', 'desc')->first();

        $label = new Labels();
        $label->id_page = $data['id_page'];
        $label->position_label = $lastPosition->position_label + 1;
        $label->titre_label = $data['name'];
        $label->type_label = "text";


        $label->save();

        $elements = array(
            'position_label' => $label->position_label,
            'id_label' => $label->id,
            'titre_label' => $label->titre_label
        );

        echo json_encode($elements, JSON_FORCE_OBJECT);
    }

    public function deletePositionLabel(RequestInterface $request, ResponseInterface $response){
        $data = $request->getParams();

        $this->container->db;
        \App\Models\Labels::where('id_label', $data['id_label'])->delete();
        \App\Models\ContentPage::where('id_label', $data['id_label'])->delete();
    }

    public function saveValueLabel(RequestInterface $request, ResponseInterface $response){
        $data = $request->getParams();
        $data = json_decode($data['data']);

        $this->container->db;

        foreach ($data as $k => $v){

            ContentPage::where('id_label', $k)->delete();

            $contentPage = new ContentPage();

            $contentPage->id_label = $k;
            $contentPage->content = $v;

            $contentPage->save();
        }



    }

}