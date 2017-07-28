<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class TestTest extends TestCase
{
    public function testExecute()
    {
        $this->assertEquals(
            true,
            true
        );
    }
}