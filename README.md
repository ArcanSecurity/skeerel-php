# Skeerel PHP

[![Latest Stable Version](https://poser.pugx.org/arcansecurity/skeerel-php/v/stable.svg)](https://packagist.org/packages/arcansecurity/skeerel-php)
[![License](https://poser.pugx.org/arcansecurity/skeerel-php/license.svg)](https://packagist.org/packages/arcansecurity/skeerel-php)

A PHP library for the Skeerel API [https://docs.skeerel.com](https://docs.skeerel.com)

# Requirements

Minimum PHP version: 5.3.3

# Install

## Via composer

`composer require arcansecurity/skeerel-php 2.0.0`

Or in your `composer.json` file:

```
{
  "require": {
    "arcansecurity/skeerel-php": "2.0.0"
  }
}
```

## Manually

If you do not wish to use Composer, you can download the 
[latest release](https://github.com/ArcanSecurity/skeerel-php/releases). 
Then, to use the bindings, include the `init.php` file.

`require_once('/path/to/skeerel-php/init.php');`

# Usage

### Generate a state token

When you display the login page to your user, you have to set a 
session token in order to avoid some [XSRF attacks](https://auth0.com/docs/protocols/oauth2/oauth-state).
The following line will do the job for you

```php
\Skeerel\Skeerel::generateSessionStateParameter();

// Eventually, you can set the name of the session
\Skeerel\Skeerel::generateSessionStateParameter("my_custom_session_name);
```

### Get user details

When a user logs in with Skeerel, the browser will redirect him 
automatically to your `data-redirect-url`. To retrieve his profile 
(user id, mail and addresses), you just have to call the 
following lines

```php
// Verify that the state parameter is the same
if (\Skeerel\Skeerel::verifySessionStateParameter($_GET['state'])) {
    $skeerel = new \Skeerel\Skeerel('YOUR_WEBSITE_ID', 'YOUR_WEBSITE_SECRET', 'YOUR_RSA_PRIVATE_KEY');
    $user = $skeerel->getUser($_GET['token']);
}
```

For more information about getting user information, you can look
at the classes under the `Skeerel/User` directory.

*N.B: since addresses are end-to-end encrypted, we cannot verify them.
While we do our best to verify them in this library, we cannot certify
their veracity. You still have to protect these values against SQL 
injection, XSS, ...*

# Sample App

If you'd like to see an example of this library in action, 
check out the Skeerel PHP sample application 
[here](https://github.com/ArcanSecurity/skeerel-sample-php).
 
# Resources
Check out the [API docs](http://docs.skeerel.com).  
Access your [developer dashboard](https://account.skeerel.com).