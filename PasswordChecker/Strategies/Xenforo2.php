<?php

namespace PasswordChecker\Strategies;

class Xenforo2 extends AbstractStrategy
{
	public function name()
	{
		return 'Xenforo';
	}

	public function getHash($password, $salt = null)
	{
		return hash('sha256', (hash('sha256', ($password . $salt))));
	}

	public function canMatch($password, $salt = null)
	{
		return $salt !== null;
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 64;
	}
}