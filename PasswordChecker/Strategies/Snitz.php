<?php

namespace PasswordChecker\Strategies;

class Snitz extends AbstractStrategy
{
	public function name()
	{
		return 'Snitz';
	}

	public function getHash($password, $salt = null)
	{
		return bin2hex(hash('sha256', $password));
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 64;
	}
}