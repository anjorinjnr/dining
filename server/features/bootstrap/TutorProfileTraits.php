<?php

use Behat\Behat\Exception\PendingException,
	Behat\Gherkin\Node\PyStringNode;
use Neartutor\Models\Tutor;

trait TutorProfileTraits {

  public $tutor_id;

  /**
   * @Given /^I have created a tutor account with email "([^"]*)"$/
   */
  public function iHaveCreatedATutorAccountWithEmail($email) {
	$response = $this->client->get("user?email={$email}")->json();
	$this->tutor_id = $response['user']['id'];
	
  }

  /**
   * @When /^I make a POST to "([^"]*)" with profile data:$/
   */
  public function iMakeAPostToWithProfileData($uri, PyStringNode $data) {
	$uri = str_replace("{id}", $this->tutor_id,  $uri);
	$req_body = [
		'body' => $data->getRaw()
	];
	$this->request_data = json_decode($data->getRaw(), true);
	$this->response = $this->client->post($uri, $req_body);
	$this->response_data = $this->response->json();
  }

  /**
   * @When /^I make a GET request to "([^"]*)"$/
   */
  public function iMakeAGetRequestTo($uri) {
	$uri = str_replace("{id}", $this->tutor_id,  $uri);
	$this->response_data = $this->client->get($uri)->json();
  }

  /**
   * @Given /^I have created a tutor account with id "([^"]*)"$/
   */
  public function iHaveCreatedATutorAccountWithId($tutor_id) {
	$this->tutor_id = $tutor_id;
  }

  /**
   * @Given /^the correct "([^"]*)" should set on the "([^"]*)" object$/
   */
  public function theCorrectShouldSetOnTheObject($rate, $tutor) {
	$req_obj = json_decode($this->response_data['user'][$tutor], true);
	$res_obj = json_decode($this->request_data[$tutor], true);
	$this->tester->assertEquals($req_obj[$rate], $res_obj[$rate]);
  }

  /**
   * @Given /^the "([^"]*)" object should have the correct values for the these fields "([^"]*)"$/
   */
  public function theObjectShouldHaveTheCorrectValuesForTheTheseFields($obj, $attr_list) {
	$fields = explode(',', $attr_list);
	foreach ($fields as $field) {
	  $this->tester->assertEquals($this->request_data[$field], $this->response_data[$obj][$field]);
	}
  }

  /**
   * @Given /^the "([^"]*)" object should have the correct values for these fields "([^"]*)"$/
   */
  public function theObjectShouldHaveTheCorrectValuesForTheseFields($obj, $attr_list) {
	$fields = explode(',', $attr_list);
	foreach ($fields as $field) {
	  $this->tester->assertEquals($this->request_data[$field], $this->response_data[$obj][$field]);
	}
  }

  /**
   * @Given /^the child "([^"]*)" object should have the correct values for these fields "([^"]*)"$/
   */
  public function theChildObjectShouldHaveTheCorrectValuesForTheseFields($tutor, $attr_list) {
	$req_obj = $this->response_data['user'][$tutor];
	$res_obj = $this->request_data[$tutor];
	$fields = explode(',', $attr_list);
	foreach ($fields as $field) {
	  $field = trim($field);
	  $this->tester->assertEquals($res_obj[$field], $req_obj[$field]);
	}
  }

}
