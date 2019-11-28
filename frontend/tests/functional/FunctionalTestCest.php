<?php namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use Codeception\Example;

class FunctionalTestCest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, Example $data)
    {
        $I->amOnPage($data['url']);
        $I->see($data['text'], ['css' => '.active']);
    }

    protected function pageProvider()
    {
        return [
            ['url' => '/', 'text' => 'Home'],
            ['url' => 'site/about', 'text' => 'About'],
            ['url' => 'site/contact', 'text' => 'Contact'],
        ];
    }
}
