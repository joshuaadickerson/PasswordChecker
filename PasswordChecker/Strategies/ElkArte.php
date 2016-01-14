<?php

namespace PasswordChecker\Strategies;

class ElkArte extends AbstractStrategy
{
	public function name()
	{
		return 'ElkArte';
	}

	public function getHash($password, $salt = null)
	{
		return hash('sha256', $password . $salt);
	}

	public function canMatch($password, $salt = null)
	{
		return $salt !== null;
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 40;
	}
}