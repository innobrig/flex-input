# flex-input
Flexible input handler for request inputs (POST, GET, PUT, DELETE, REQUEST, FILES, COOKIE) using filter_var(). It's safe to use with recursive array (ie: will filter each item in sub-arrays).

##Install
Via composer
> { "require": { "innobrig/flex-input": "^1.0.6" } }

For some reasons packagist refuses to pick up the release and thus will clone the git archive. In this case use
> composer update --prefer-dist


### Example Use
> <?php
>
>use InnoBrig\FlexInput\Input;
>

Retrieving the entire GET array:

> $value = Input::fromGet ();

Retrieving a specific item from GET:

> $value = Input::fromGet ('key');

Retrieving a specific item from GET while specifying a default value to be returned if the requested item is not found:

> $value = Input::fromGet ('key', $defaultValue);

Retrieving a specific item from POST while specifying default, filter and args

> $value = Input::fromPost ('key', $defaultValue, FILTER_SANITIZE_STRING, array(FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH));


Internally the PHP function filter_var() is used; consult the PHP docs for the various options which are supported.

Note: per default, values retrieved from input have trim() applied to them.
