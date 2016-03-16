# Google Recaptcha for Laravel 5

[![Latest Version on Packagist](https://img.shields.io/packagist/v/waavi/recaptcha.svg?style=flat-square)](https://packagist.org/packages/waavi/recaptcha)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/Waavi/recaptcha/master.svg?style=flat-square)](https://travis-ci.org/Waavi/recaptcha)
[![Total Downloads](https://img.shields.io/packagist/dt/waavi/recaptcha.svg?style=flat-square)](https://packagist.org/packages/waavi/recaptcha)

## Introduction

This is a reCAPTCHA Validator package for Laravel 5.1.

WAAVI is a web development studio based in Madrid, Spain. You can learn more about us at [waavi.com](http://waavi.com)

## Laravel compatibility

 Laravel  | translation
:---------|:----------
 5.1.x    | 1.0.x
 5.2.x    | 1.0.4 and higher

## Installation and Setup

Require through composer

    composer require waavi/recaptcha 1.0.x

Or manually edit your composer.json file:

    "require": {
        "waavi/recaptcha": "1.0.x"
    }

In config/app.php, add the following entry to the end of the providers array:

    Waavi\ReCaptcha\ReCaptchaServiceProvider::class,

And the following alias:

    'ReCaptcha' => Waavi\ReCaptcha\Facades\ReCaptcha::class,

Publish the configuration file, the form view and the language entries:

    php artisan vendor:publish --provider="Waavi\ReCaptcha\ReCaptchaServiceProvider"

Enter your secret and site keys provided by Google in either your environment file (recommended) or the config file:

    RECAPTCHA_SITE_KEY=site_key
    RECAPTCHA_SECRET_KEY=secret_key

A simple error message in english is provided when validation of a recaptcha fails. If you wish to customize it, add to your validation.php lang file the following entry:

    ```php
    'recaptcha' =>  'Your error message here',
    ```

## Usage

### Rendering the ReCaptcha form in your views

You may render the ReCaptcha widget in your blade forms by calling:

    {!! ReCaptcha::render() !!}

Or by including the provided view (if you choose to do this, the sitekey must be present as a parameter):

    @include('recaptcha::recaptcha', ['siteKey' => config('recaptcha.keys.site')])

You may also choose to customize the widget through the available options described in the [official docs](https://developers.google.com/recaptcha/docs/display)

    {!! ReCaptcha::render(['theme' => 'dark']) !!}

    or

    @include('recaptcha::recaptcha', ['siteKey' => config('recaptcha.keys.site'), 'options' => ['theme' => 'dark']])

### Validating the ReCaptcha

There are two available options to validate the ReCaptcha. You may do so manually through the provided Facade:

    ```php
    $value = \Input::get('g-recaptcha-response');
    $gResponse = \ReCaptcha::parseInput($value);

    if ($gResponse->isSuccess()) {
        return true;
    }
    else {
        $errors = $gResponse->getErrorMessages();   // Returns an array of error messages in the form of errorCode => errorMessage
        var_dump($errors);
    }
    ```

Or in a much more convinient way, through the provided Validator extension, adding to your rules array:

    ```php
    $rules = [
        /** Your rules ... **/
        'g-recaptcha-response' => 'recaptcha',
    ];
    ```