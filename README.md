# Password Checker
The password checker is simple library designed to allow you to attempt to check a password against a hash from
an *older* hash. The intention is to add as many strategies of as many types of software out there so we can
continuously upgrade our password hashing methods.

## Strategies
Every software and every version of that software - that changes the hashing method - should have its own strategy to 
easily identify it.

## Usage
Say you converted your forum from YaBB SE to Xenforo to ElkArte within a short period. You don't want to reset all of
your users' passwords. Instead, you install this library (probably via plugin).

``` php
$strategies = [
	new Strategies\YaBBSE,
	new Strategies\Xenforo
];

$checker = new PasswordChecker($strategies);
$check = $checker->check('password', 'salt');
```

At this point you'd use $check to determine if the supplied password matches the saved hash.

### Alternative
If you don't want to chain the methods and know what you're doing, you can use the strategies on their own.

``` php
$strategy = new Strategies\Xenforo;
$strategy->match('password'