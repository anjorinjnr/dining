<?php

use Behat\Behat\Context\ClosuredContextInterface,
	Behat\Behat\Context\TranslatedContextInterface,
	Behat\Behat\Context\BehatContext,
	Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
	Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;


require 'TutorProfileTraits.php';
//require_once 'PHPUnit/Autoload.php';
//require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext {

  use TutorProfileTraits;
  
  /**
   * @var  \GuzzleHttp\Client
   */
  protected $client;

  /**
   * @var   \GuzzleHttp\Message\ResponseInterface
   */
  protected $response;
  protected $access_token;
  protected $tester;
  protected $request_data;
  protected $response_data;
 // protected $response;

  /**
    /**
   * Initializes context.
   * Every scenario gets its own context object.
   *
   * @param array $parameters context parameters (set them up through behat.yml)
   */
  public function __construct(array $parameters) {
	// Initialize your context here
	$this->client = new Client([
		'base_url' => 'http://neartutor-service.local/v1/',
		'defaults' => [
			'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json']
		]]);
	$this->tester = new TestCase();
  }

  /**
   * @Given /^I have a valid access-token to call the api$/
   */
  public function iHaveAValidToCallTheApi() {
	//throw new PendingException();
  }

  /**
   * @When /^I make a POST to "([^"]*)" with:$/
   */
  public function iMakeAPostToWith($path, PyStringNode $data) {
	$req_body = [
		'body' => $data->getRaw()
	];
	$this->request_data = json_decode($data->getRaw(), true);
	$this->response = $this->client->post($path, $req_body);
	$this->response_data = $this->response->json();
  }

  /**
   * @Then /^the response should have a "([^"]*)" field set to "([^"]*)"$/
   */
  public function theResponseShouldHaveAFieldSetTo($field, $value) {
	//$response_data = $this->response->json();
	$this->tester->assertEquals($value, $this->response_data[$field]);
  }

  /**
   * @Given /^the response should contain a "([^"]*)" object$/
   */
  public function theResponseShouldContainAObject($field) {
	//$response_data = $this->response->json();
	$this->tester->assertArrayHasKey($field, $this->response_data);
  }

  /**
   * @Given /^the "([^"]*)" object should have a valid "([^"]*)"$/
   */
  public function theObjectShouldHaveAValid($obj, $id) {
	//$response_data = $this->response->json();
	$user = json_decode($this->response_data[$obj], true);
	$this->tester->assertArrayHasKey($id, $user);
	$this->tester->assertInternalType("int", $user[$id]);
  }
  
  

}
