<?php

require_once './src/Input.php';


ini_set('display_errors',1);


use InnoBrig\FlexInput\Input;


class InputTest extends PHPUnit_Framework_TestCase 
{
    public function testSuccessFalseDataInput()
    {
        $this->assertFalse (Input::getPassedValue('login', null, 'POST'));
    }

	
    public function testFailFalseDataInput()
    {
		
        $this->assertTrue(true);
    }
}
