<?php

declare(strict_types=1);

namespace DigitalZenWorks\DigitalZenTheme\UnitTests;

$root = dirname(__DIR__, 1);

require_once $root . '/vendor/autoload.php';

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @covers All
 */
final class UnitTests extends TestCase
{
	/**
	 * Sanity Check Test.
	 *
	 * @return void
	 */
	#[Test]
	public function SanityCheck()
	{
		$some_var = true;
		$this->assertTrue($some_var);
	}
}
