<?php

/**
 * Description of PictureUploaderTest
 *
 * @author adekunleadedayo
 */
class PictureUploaderTest extends TestCase {

    public function setUp() {
        @session_start();
        parent::setUp();
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testPictureIsStoredGivenValidPicture() {
        
    }

    public function testExceptionIsThrownWhenAnErrorOccurs() {
        
    }

}
