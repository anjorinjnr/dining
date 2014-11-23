<?php

namespace Neartutor\Controllers;

use \Response;

class BaseController extends \Controller {

  public function __construct() {
	/*$this->afterFilter(function($request, $response) {
	  //var_dump($response);
	  $response->headers->set('Access-Control-Allow-Origin', '*');
	  return $response;
	});*/
  }

  public function json($data) {
	return Response::json($data);
  }

  public function errorResponse() {
	return $this->json(array("status" => "error", "errors" => array("An error occured")));
  }

  public function successResponse() {
	return $this->json(array("status" => "success", "message" => "Operation Successful"));
  }

}
