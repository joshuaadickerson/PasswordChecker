<?php

namespace PasswordChecker\Strategies;

interface PasswordStrategyInterface
{
	/**
	 * The name of the strategy
	 * @return string
	 */
	public function name();

	/**
	 * Set the options like the salt or the length
	 * @param array $options
	 * @return void
	 */
	public function setOptions(array $options);

	/**
	 * Check if the stored password can be one of these types.
	 * Usually just checks the length, but also might check for certain characters
	 * @param string $hash
	 * @return bool
	 */
	public function checkSystemHash($hash);

	/**
	 * Given the inputted string, get back a hashed password
	 * @param string $password
	 * @return mixed
	 */
	public function getHash($password);

	/**
	 * Check if all of the dependencies of doing match() have been met.
	 * @param string $password
	 * @param null|string $salt
	 * @return bool
	 */
	public function canMatch($password, $salt = null);

	/**
	 * Check if the password matches the hash
	 *
	 * @param string $password
	 * @param string $hash
	 * @param string|null $salt
	 * @return bool
	 */
	public function match($hash, $password, $salt = null);
}