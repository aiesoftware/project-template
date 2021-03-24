<?php declare(strict_types=1);

namespace App\SomeDomain\Service;

use App\SomeDomain\Repository\SomeRepositoryInterface;

class SomeService
{
    public function __construct(private SomeRepositoryInterface $repository)
    {}
}
