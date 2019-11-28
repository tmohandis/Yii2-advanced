<?php namespace frontend\tests;

use frontend\models\ContactForm;
use yii\helpers\ArrayHelper;

class UnitTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $var1 = 100;
        $form = new ContactForm([
            'name' => 'John',
            'email' => 'test@example.com',
            'subject' => 'Greeting',
            'body' => 'Hello! I am John',
            'verifyCode' => true
        ]);
        $this->assertTrue(isset($var1));
        $this->assertEquals(100, $var1);
        $this->assertLessThan(200, $var1);
        $this->assertAttributeEquals(true, 'verifyCode', $form);
        $this->assertArrayHasKey('body', ArrayHelper::toArray($form));
        expect($form->verifyCode)->equals(true);
    }
}