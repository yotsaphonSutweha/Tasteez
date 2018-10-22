<?php

namespace Tasteez\Controllers;


class PrivacyPolicy extends Controller
{

  // public function index($request, $response) {
  //   return $this->container->view->render($response, 'home.twig', ["foo" => "bar"]);
  // }

  function __invoke($request, $response) {
    return $this->container->view->render($response, 'privacy-policy.twig');
  }

}
