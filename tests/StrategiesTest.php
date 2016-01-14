<?php

class StrategiesTest extends PHPUnit_Framework_TestCase
{
	protected $password = 'password';
	protected $salt = 'salt';
	protected $namespace = 'PasswordChecker\\Strategies\\';

	public function strategyProvider()
	{
		return [
			['APBoard2', '18e861ad976b2917cdccc801fa5013f6'],
			['BurningBoard3', '1e0e3172ee191f044c635b87312a2244a7c33b1b'],
		];
	}

	/**
	 * @dataProvider strategyProvider
	 *
	 * @param $class
	 * @param $hash
	 */
	public function testGetAllHashes($class, $hash)
	{
		$full_class = $this->namespace . $class;

		/** @var \PasswordChecker\Strategies\PasswordStrategyInterface $strategy */
		$strategy = new $full_class();

		$strategy->setOptions(array('salt' => $this->salt));

		$this->assertEquals($strategy->getHash($this->password), $hash);
	}
}