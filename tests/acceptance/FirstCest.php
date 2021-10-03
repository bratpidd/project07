<?php
namespace App\Tests;
use App\Tests\AcceptanceTester;
class FirstCest
{
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
    }
}
