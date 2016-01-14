<?php

namespace PasswordChecker\Strategies;

class vBulletin3 extends AbstractStrategy
{
	public function name()
	{
		return 'vBulletin 3';
	}

	public function getHash($password, $salt = null)
	{
		return md5(md5($password) . stripslashes($salt));
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