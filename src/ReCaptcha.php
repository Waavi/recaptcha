<?php

namespace Waavi\ReCaptcha;

use Waavi\ReCaptcha\IO\Broker;

class ReCaptcha
{
    /**
     *  Create a new ReCaptcha instance
     *
     *  @param  Broker $broker
     *  @param  string $siteKey
     *  @return void
     */
    public function __construct(Broker $broker, $siteKey)
    {
        $this->broker  = $broker;
        $this->siteKey = $siteKey;
    }

    /**
     *  Parse the input of the value of a form including the recaptcha code.
     *
     *  @param  string $input
     *  @return IO\Response
     */
    public function parseInput($input)
    {
        return $this->broker->getResponse($input);
    }

    /**
     *  Render the ReCaptcha box
     *
     *  @param  array   $options
     *  @return string
     */
    public function render($options = [])
    {
        return view('recaptcha::recaptcha', ['siteKey' => $this->siteKey, 'options' => $options])->render();
    }
}
