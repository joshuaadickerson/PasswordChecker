<?php

namespace PasswordChecker\Strategies;

class APBoard2 extends AbstractStrategy
{
	public function name()
	{
		return 'AP Board 2';
	}

	public function getHash($password, $salt = null)
	{
		return md5(crypt($password, 'CRYPT_MD5'));
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 40;
	}
}