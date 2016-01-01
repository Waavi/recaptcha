<?php

namespace Waavi\ReCaptcha;

class Validator
{
    /**
     *  ReCaptcha instance
     *
     *  @var Waavi\ReCaptcha\ReCaptcha
     */
    protected $recaptcha;

    /**
     *  Construct a validator instance
     *
     *  @param  Waavi\ReCaptcha\ReCaptcha $recaptcha
     *  @return void
     */
    public function __construct(ReCaptcha $recaptcha)
    {
        $this->recaptcha = $recaptcha;
    }

    /**
     *  Check if the given value satisfies the recaptcha rule.
     *
     *  @param  string  $attribute  Attribute name
     *  @param  string  $value
     *  @param  array   $parameters Rule parameters
     *  @param  Validator $validator instance
     *  @return boolean
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        return is_null($value) || empty($value) ? false : $this->recaptcha->parseInput($value)->isSuccess();
    }
}
