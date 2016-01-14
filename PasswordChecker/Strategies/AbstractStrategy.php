<?php

namespace PasswordChecker\Strategies;

abstract class AbstractStrategy implements PasswordStrategyInterface
{
	protected $options = [];

	abstract public function name();

	abstract public function getHash($password, $salt = null);

	public function setOptions(array $options)
	{
		$this->options = $options;
	}

	public function canMatch($password, $salt = null)
	{
		return true;
	}

	public function match($hash, $password, $salt = null)
	{
		return $this->getHash($password, $salt) === $hash;
	}

	public function checkSystemHash($hash)
	{
		return true;
	}
}