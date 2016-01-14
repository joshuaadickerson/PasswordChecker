<?php

namespace PasswordChecker\Strategies;

class BurningBoard3 extends AbstractStrategy
{
	public function name()
	{
		return 'Xenforo';
	}

	public function getHash($password, $salt = null)
	{
		return sha1($salt . sha1($salt . sha1($password)));
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