<?php

namespace PasswordChecker\Strategies;

class PHPFusion7 extends AbstractStrategy
{
	public function name()
	{
		return 'PHP-Fusion7';
	}

	public function getHash($password, $salt = null)
	{
		return hash_hmac('sha256', $password, $salt);
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