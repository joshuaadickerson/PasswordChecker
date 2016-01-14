<?php

namespace PasswordChecker\Strategies;

class MyPHP extends AbstractStrategy
{
	public function name()
	{
		return 'MyPHP';
	}

	public function getHash($password, $salt = null)
	{
		return crypt(md5($password), md5($password));
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 32;
	}
}