<?php

namespace PasswordChecker\Strategies;

class PhpBB3 extends AbstractStrategy
{
	protected $range = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	public function name()
	{
		return 'phpBB3';
	}

	public function getHash($password, $salt = null)
	{
		return crypt(md5($password), md5($password));
	}

	public function checkSystemHash($hash)
	{
		return strlen($hash) === 32;
	}

	/**
	 * Custom encryption for phpBB3 based passwords.
	 *
	 * @param string $passwd
	 * @param string $passwd_hash
	 * @return string
	 */
	function phpBB3_password_check($passwd, $passwd_hash)
	{
		// Too long or too short?
		if (strlen($passwd_hash) != 34)
			return '';

		// Range of characters allowed.
		//$range = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		// Tests
		$strpos = strpos($this->range, $passwd_hash[3]);
		$count = 1 << $strpos;
		$salt = substr($passwd_hash, 4, 8);

		$hash = md5($salt . $passwd, true);
		for (; $count != 0; --$count)
			$hash = md5($hash . $passwd, true);

		$output = substr($passwd_hash, 0, 12);
		$i = 0;
		while ($i < 16)
		{
			$value = ord($hash[$i++]);
			$output .= $this->range[$value & 0x3f];

			if ($i < 16)
				$value |= ord($hash[$i]) << 8;

			$output .= $this->range[($value >> 6) & 0x3f];

			if ($i++ >= 16)
				break;

			if ($i < 16)
				$value |= ord($hash[$i]) << 16;

			$output .= $this->range[($value >> 12) & 0x3f];

			if ($i++ >= 16)
				break;

			$output .= $this->range[($value >> 18) & 0x3f];
		}

		// Return now.
		return $output;
	}
}