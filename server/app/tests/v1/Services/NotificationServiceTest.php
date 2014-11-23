<?php

use Way\Tests\Factory;
use Neartutor\Services\NotificationService;

/**
 * Description of NotificationServiceTest
 *
 * @author adekunleadedayo
 */
class NotificationServiceTest extends TestCase {

    private $validData = array(
        "email" => "adedayokunle@gmail.com",
        "name" => "Adekunle Adedayo",
        "subject" => "Activation Email",
        "template" => "emails.activation"
    );

    public function setUp() {

        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testThatServiceFailsWhenTemplateDoesNotExist() {
        $service = new NotificationService();
        $emailSent = $service->sendEmail($this->validData['email'], $this->validData['name'], $this->validData['subject'], "randomrubbish");

        $this->assertEquals($emailSent, false);
        $this->assertEquals($service->errors(), "Specified template cannot be found");
    }

    public function testThatServiceFailsWhenEmailIsInvalid() {
        $service = new NotificationService();
        $emailSent = $service->sendEmail('invalid email', $this->validData['name'], $this->validData['subject'], $this->validData['template']);

        $this->assertEquals($emailSent, false);
        $this->assertEquals($service->errors(), "Invalid email supplied");
    }

    public function testThatServiceFailsWhenSubjectIsEmpty() {
        $service = new NotificationService();
        $emailSent = $service->sendEmail($this->validData['email'], $this->validData['name'], '', $this->validData['template']);

        $this->assertEquals($emailSent, false);
        $this->assertEquals($service->errors(), "Message subject is required");
    }

    public function testThatServiceFailsWhenNameIsEmpty() {
        $service = new NotificationService();
        $emailSent = $service->sendEmail($this->validData['email'], '', $this->validData['subject'], $this->validData['template']);

        $this->assertEquals($emailSent, false);
        $this->assertEquals($service->errors(), "Sender name is required");
    }

   /* public function testThatMailPretendsWhenInDevelopment() {
        $service = new NotificationService();
        $emailSent = $service->sendEmail($this->validData['email'], $this->validData['name'], $this->validData['subject'], $this->validData['template']);

        Mail::shouldReceive('pretend')->once();
        $this->assertTrue($emailSent, true);
    } */

    public function testThatMailSendsWhenDataIsValid() {
         $service = new NotificationService();
        $emailSent = $service->sendEmail($this->validData['email'], $this->validData['name'], $this->validData['subject'], $this->validData['template']);

        //Mail::shouldReceive('queue')->once();
        $this->assertEquals($emailSent, true);
    }

}
