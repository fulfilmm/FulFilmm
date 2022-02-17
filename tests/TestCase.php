<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function test_basic_test()
    {
        $this->assertTrue(true);
    }
}
