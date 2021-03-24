<?php declare(strict_types=1);

namespace Tests\Acceptance\SomeDomain\features\bootstrap;

use App\SomeDomain\Service\SomeService;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class FeatureContext implements Context
{
    public function __construct(private SomeService $service)
    {}

    /**
     * @Given /^some method to set up the test$/
     */
    public function someMethodToSetUpTheTest()
    {
        return true;
    }
}
