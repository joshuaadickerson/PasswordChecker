<?php

namespace PasswordChecker\Strategies;

class WordpressOld extends MD5
{
	public function name()
	{
		return 'Old Wordpress';
	}
}