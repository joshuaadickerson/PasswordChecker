<?php

namespace PasswordChecker\Strategies;

class ChainedStrategy implements PasswordStrategyInterface
{
	/** @var PasswordStrategyInterface[] */
	protected $strategies = [];
	/** @var array  */
	protected $options = [];

	public function __construct(array $strategies)
	{
		$this->setStrategies($strategies);
	}

	public function name()
	{
		return 'Chained';
	}

	/**
	 * @param PasswordStrategyInterface[] $strategies
	 * @return $this
	 */
	protected function setStrategies(array $strategies)
	{
		$this->strategies = [];

		foreach ($strategies as $strategy)
		{
			$this->addStrategy($strategy);
		}

		return $this;
	}

	/**
	 * @param PasswordStrategyInterface $strategy
	 * @return $this
	 */
	protected function addStrategy(PasswordStrategyInterface $strategy)
	{
		$this->strategies[$strategy->name()] = $strategy;
		return $this;
	}

	public function setOptions(array $options)
	{
		$this->options = $options;

		foreach ($this->strategies as $strategy)
		{
			$strategy->setOptions($options);
		}

		return $this;
	}

	public function canMatch($password, $salt = null)
	{
		if (!empty($this->strategies))
		{
			return false;
		}

		foreach ($this->strategies as $strategy)
		{
			if ($strategy->canMatch($password, $salt))
			{
				return true;
			}
		}

		return false;
	}

	public function getHash($password)
	{
		return 'The chained strategy is only for checking matches and should not be used to get password hashes';
	}

	public function match($hash, $password, $salt = null)
	{
		foreach ($this->strategies as $strategy)
		{
			if ($strategy->canMatch($password, $salt) && $strategy->match($hash, $password, $salt))
			{
				return true;
			}
		}

		return false;
	}

	public function checkSystemHash($hash)
	{
		foreach ($this->strategies as $strategy)
		{
			// It only has to match one
			if ($strategy->checkSystemHash($hash))
			{
				return true;
			}
		}

		return false;
	}
}