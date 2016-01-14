<?php

namespace PasswordChecker\Strategies;

class Wordpress extends AbstractStrategy
{
	protected $phpass;

	public function __construct()
	{
		/*
		 * @see https://github.com/WordPress/WordPress/blob/c52af7470b0d882eba4aeffbc882ea704ca52cc3/wp-includes/pluggable.php#L2120
		 * wp_check_password() in /wp-includes/pluggable.php
		 */
		$this->phpass = new \PasswordHash(8, true);
	}

	public function name()
	{
		return 'Wordpress';
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