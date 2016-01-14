<?php

namespace PasswordChecker\Strategies;

class YaBBSE extends AbstractStrategy
{
	public function name()
	{
		return 'YaBB SE';
	}

	public function getHash($password, $salt = null)
	{
		// The salt here is the user's member_name
		return $this->md5_hmac($password, $salt);
	}

	public function canMatch($password, $salt = null)
	{
		return $salt !== null;
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 32;
	}

	/**
	 * MD5 Encryption used for older passwords. (SMF 1.0.x/YaBB SE 1.5.x hashing)
	 *
	 * @param string $data
	 * @param string $key
	 * @return string the HMAC MD5 of data with key
	 */
	protected function md5_hmac($data, $key)
	{
		$key = str_pad(strlen($key) <= 64 ? $key : pack('H*', md5($key)), 64, chr(0x00));
		return md5(($key ^ str_repeat(chr(0x5c), 64)) . pack('H*', md5(($key ^ str_repeat(chr(0x36), 64)) . $data)));
	}
}