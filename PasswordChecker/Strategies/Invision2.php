<?php

namespace PasswordChecker\Strategies;

class Invision2 extends AbstractStrategy
{
	public function name()
	{
		return 'Invision2';
	}

	public function getHash($password, $salt = null)
	{
		return md5(md5($salt) . md5($password));
	}

	public function canMatch($password, $salt = null)
	{
		return $salt !== null;
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 32;
	}
}