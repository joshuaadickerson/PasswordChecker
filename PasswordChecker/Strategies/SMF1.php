<?php

namespace PasswordChecker\Strategies;

// SMF 1 had the same function as YaBB SE
// Remember: the salt is the member_name
class SMF1 extends YaBBSE
{
	public function name()
	{
		return 'SMF 1.0';
	}
}