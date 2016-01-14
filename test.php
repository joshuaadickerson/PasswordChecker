<?php

// Get the test hashes

error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

$checker = new \PasswordChecker\PasswordChecker();
$checker->addStrategiesFromDir();

$password = 'password';
$salt = 'salt';

//var_dump($checker->check($password, 'fake hash does not pass'));

//var_dump($checker);

$checker = new PasswordChecker\Strategies\APBoard2();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\BurningBoard3();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\ElkArte();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\Invision2();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\MyPHP();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\PhpBB3();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\PHPFusion7();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\PunBB14();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\Snitz();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\Xenforo();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));

$checker = new PasswordChecker\Strategies\Xenforo2();
$checker->setOptions(array('salt' => $salt));
var_dump(get_class($checker) . '::			' . $checker->getHash($password));
