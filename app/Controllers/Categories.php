<?php

namespace Tasteez\Controllers;


class Categories extends Controller
{
  function __invoke($request, $response) {
    $meal = new \Tasteez\Models\Meal($this->container->db);
    $categories = $meal->findAll();
    return $this->container->view->render($response, 'categories.twig', ["categories" => $categories]);
  }

}
