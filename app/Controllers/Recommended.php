<?php

namespace Tasteez\Controllers;


class Recommended extends Controller
{
  function __invoke($request, $response) {
    $recommended = new \Tasteez\Models\Meal($this->container->db);
    $recommended = $recommended->findAll();
    return $this->container->view->render($response, 'recommended.twig', ["recommended" => $recommended]);
  }

}
