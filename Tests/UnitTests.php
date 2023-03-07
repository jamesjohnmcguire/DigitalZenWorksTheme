<?php
declare(strict_types=1);

namespace DigitalZenWorks\DigitalZenTheme\UnitTests;

use PHPUnit\Framework\TestCase;

/**
 * @covers All
 */
final class UnitTests extends TestCase
{
	public function testSanityCheck()
	{
		$some_var = true;
		$this->assertTrue($some_var);
	}

	/**
	 * Call protected/private method of a class.
	 *
	 * @param object &$object    Instantiated object that we will run method on.
	 * @param string $methodName Method name to call
	 * @param array  $parameters Array of parameters to pass into method.
	 *
	 * @return mixed Method return.
	 */
	private static function invokeMethod(&$object, $methodName,
		array $parameters = array())
	{
		$reflection = new \ReflectionClass(get_class($object));
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method->invokeArgs($object, $parameters);
	}
}
