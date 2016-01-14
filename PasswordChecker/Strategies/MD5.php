<?php

namespace PasswordChecker\Strategies;

class MD5 extends AbstractStrategy
{
	public function name()
	{
		return 'MD5';
	}

	public function getHash($password, $salt = null)
	{
		return md5($password);
	}

	public function canMatch($password, $salt = null)
	{
		return true;
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 32;
	}
}