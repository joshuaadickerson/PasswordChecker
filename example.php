<?php

use PasswordChecker\Strategies;

/**
 * Say I have a forum. Over the years, I've tried several different PHP forum softwares but today I am on ElkArte.
 * I went from YaBB SE to phpBB to SMF and finally wound up here. I have users that have never changed their passwords
 * and never logged out. Even though I should and for whatever reason, I don't want to burden them with changing their
 * password.
 *
 * In another scenario, I just converted from SMF. My users were logged in 10 minutes ago and forcing every
 * user to change their password will cause my forum to grind to a halt as many users don't remember what email
 * address they used or don't have access to it anymore. No more posts means no more revenue means no more forum. Boss
 * isn't having that.
 *
 * What do I do? That's what this library is for.
 */

$current_password = 'foobar';
$hash = '';

var_dump( scenario1($current_password, $hash) );

var_dump( scenario2($current_password, $hash) );

function scenario1($password, $hash)
{
	// I switched between 4 forum software: YaBB SE, phpBB, SMF, and ElkArte.
	// ElkArte should check its own passwords on its own, so we aren't going to check them here.
	// This should only run after ElkArte fails to authenticate the user.

	// Build the chain
	$strategies = [
		new Strategies\SMF1(),
		new Strategies\PhpBB3(),
		new Strategies\YaBBSE(),
	];

	// Get a chain strategy
	$checker = new Strategies\ChainedStrategy($strategies);
	return $checker->match($hash, $password);
}

function scenario2($password, $hash)
{
	// This time we only have one forum that we were using
	// No need to build a chain.
	$strategy = new Strategies\SMF1();
	return $strategy->match($hash, $password);
}