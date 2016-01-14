<?php

namespace PasswordChecker\Strategies;

class PunBB14 extends AbstractStrategy
{
	public function name()
	{
		return 'PunBB 1.4';
	}

	public function getHash($password, $salt = null)
	{
		return sha1($salt . sha1($password));
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