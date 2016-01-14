<?php

namespace PasswordChecker\Strategies;

class Xenforo extends AbstractStrategy
{
	public function name()
	{
		return 'Xenforo';
	}

	public function getHash($password, $salt = null)
	{
		return sha1(sha1($password) . $salt);
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