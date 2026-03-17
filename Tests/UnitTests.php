<?php

/**
 * Unit Tests.
 *
 * @package   DigitalZenWorks\DigitalZenTheme
 * @author    James John McGuire <jamesjohnmcguire@gmail.com>
 * @copyright 2021 - 2026 James John McGuire <jamesjohnmcguire@gmail.com>
 * @link      https://github.com/jamesjohnmcguire/DigitalZenWorksTheme
 */

declare(strict_types=1);

namespace DigitalZenWorks\DigitalZenTheme\UnitTests;

$root = dirname(__DIR__, 1);

require_once $root . '/vendor/autoload.php';

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * UnitTests class.
 *
 * Contains all the unit tests.
 */
final class UnitTests extends TestCase
{
	/**
	 * Sanity Check Test.
	 *
	 * @return void
	 */
	#[Group('basic')]
	#[Test]
	public function SanityCheck()
	{
		$someVar = true;
		// @phpstan-ignore-next-line
		$this->assertTrue($someVar);
	}
}
