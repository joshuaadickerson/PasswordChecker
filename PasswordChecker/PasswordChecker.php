<?php

namespace PasswordChecker;

use PasswordChecker\Strategies\PasswordStrategyInterface;

/**
 * Class PasswordChecker
 * Check passwords
 * @package Elkarte\Elkarte\Security
 */
class PasswordChecker
{
	/** @var PasswordStrategyInterface[] */
	protected $strategies = [];
	/** @var string */
	protected $strategy_dir = 'Strategies';
	/** @var array  */
	protected $last_check = [];
	/** @var  PasswordStrategyInterface */
	protected $current_strategy;
	/** @var array  */
	protected $options = [];

	/**
	 * @param PasswordStrategyInterface[] $strategies
	 * @return $this
	 */
	public function setStrategies(array $strategies)
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
	public function addStrategy(PasswordStrategyInterface $strategy)
	{
		$this->strategies[$strategy->name()] = $strategy;
		return $this;
	}

	/**
	 * @param string $dir
	 * @param array $allowed_strategies = []
	 * @throws \RuntimeException when $dir is not a directory
	 */
	public function addStrategiesFromDir($dir = 'Strategies', $namespace = '\\PasswordChecker\\Strategies\\', array $allowed_strategies = [])
	{
		$this->strategy_dir = $dir[0] !== '/' ? __DIR__ . '/' . $dir : $dir;

		foreach ($this->getStrategyFiles() as $file)
		{
			$class = $namespace . pathinfo($file->getFilename(), PATHINFO_FILENAME);

			try
			{
				$strategy = new $class;

				if ($allowed_strategies !== [] && !in_array($class, $allowed_strategies))
				{
					continue;
				}

				if (!$strategy instanceof PasswordStrategyInterface)
				{
					// @todo select a better exception here
					throw new \RuntimeException('Strategy must implement PasswordStrategyInterface: ' . $class);
				}

				$this->addStrategy($strategy);
			}
				// What kind of exception?
			catch (\Exception $e)
			{
				// log that it can't find the class
			}
		}
	}

	/**
	 * @return \SplFileInfo[]
	 */
	protected function getStrategyFiles()
	{
		if (!is_dir($this->strategy_dir))
		{
			throw new \RuntimeException('Unknown strategy directory: ' . $this->strategy_dir);
		}

		$files = array();
		$skip_files = ['AbstractStrategy.php', 'PasswordStrategyInterface.php'];

		$iter = new \FilesystemIterator($this->strategy_dir, \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);
		foreach ($iter as $path => $file)
		{
			$filename = $file->getFilename();

			// Skip dirs, 'AbstractStrategy.php', 'PasswordStrategyInterface.php', anything that starts with '.'
			if (in_array($filename, $skip_files) || $filename[0] === '.')
			{
				continue;
			}

			// @todo use yield
			$files[] = $file;
		}

		return $files;
	}
	/**
	 * @param string $password
	 * @param string $hash
	 * @return bool
	 * @throws PasswordException
	 * @throws \RuntimeException
	 */
	public function check($hash, $password, $salt = null)
	{
		$password = (string) $password;
		$pass_len = strlen($password);

		if ($pass_len === 0)
		{
			throw new PasswordException('Password must not be 0 length');
		}

		$hash = (string) $hash;
		$hash_len = strlen($hash);

		if ($hash_len === 0)
		{
			throw new PasswordException('Hash must not be 0 length');
		}

		if (empty($this->strategies))
		{
			throw new \RuntimeException('No password strategies loaded');
		}

		$this->options['password_length'] = $pass_len;
		$this->options['hash_length'] = $hash_len;

		return $this->checkStategies($hash, $password, $salt);
	}

	/**
	 * @param array $options
	 * @return $this
	 */
	public function setOptions(array $options)
	{
		$this->options = $options;
		return $this;
	}

	/**
	 * @param string $password
	 * @param string $hash
	 * @return bool
	 */
	protected function checkStategies($hash, $password, $salt = null)
	{
		foreach ($this->strategies as $strategy)
		{
			$strategy->setOptions($this->options);

			if ($strategy->checkSystemHash($hash) && $strategy->match($hash, $password, $salt))
			{
				$this->current_strategy = $strategy;
				return true;
			}
		}

		return false;
	}

	public function getCurrentStrategy()
	{
		return $this->current_strategy;
	}
}