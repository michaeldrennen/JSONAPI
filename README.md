# JSONAPI
![GitHub](https://img.shields.io/github/license/michaeldrennen/jsonapi) [![Build Status](https://travis-ci.org/michaeldrennen/JSONAPI.svg?branch=master)](https://travis-ci.org/michaeldrennen/JSONAPI) ![Codecov](https://img.shields.io/codecov/c/github/michaeldrennen/jsonapi) ![GitHub issues](https://img.shields.io/github/issues/michaeldrennen/jsonapi) ![Packagist](https://img.shields.io/packagist/dt/michaeldrennen/jsonapi) [![Beerpay](https://beerpay.io/michaeldrennen/JSONAPI/badge.svg)](https://beerpay.io/michaeldrennen/JSONAPI) 

This is a PHP library for those wanting to build an API and return structured data to the requesting client.
```php
// This $user is the object we want to return to the client requesting the User data.
$user  = new User( 74, "Mike", TRUE );

// Create the response object, set the $user as the data you want to return, and 
// specify the Transformer you want to use to munge the User data. 
$array = \MichaelDrennen\JSONAPI\Response::create()
                                         ->setData( $user )
                                         ->transformWith( new UserTransformer() )
                                         ->toArray();

```