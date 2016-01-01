<?php

namespace Waavi\ReCaptcha\IO;

class Response
{
    /**
     *  Allowed error codes
     *
     *  @var array
     */
    protected $allowedErrorCodes = ['missing-input-secret', 'invalid-input-secret', 'missing-input-response', 'invalid-input-response'];

    /**
     *  Whether the response had a success status
     *
     *  @var boolean
     */
    protected $success;

    /**
     *  Error codes
     *
     *  @var array
     */
    protected $errorCodes;

    /**
     *  Error messages
     *
     *  @var array
     */
    protected $errorMessages;

    /**
     *  Create a new Google Response
     *
     *  @param  array  $json    Json encoded array with google's service response
     *  @return void
     */
    public function __construct($json)
    {
        $response            = json_decode($json, true);
        $this->success       = (boolean) array_get($response, 'success', false);
        $this->errorCodes    = [];
        $this->errorMessages = [];
        if (!$this->success) {
            $errorCodes = array_get($response, 'error-codes', []);
            $errorCodes = array_intersect($errorCodes, $this->allowedErrorCodes);
            if (count($errorCodes) > 0) {
                $this->errorCodes    = $errorCodes;
                $this->errorMessages = [];
                foreach ($this->errorCodes as $code) {
                    $this->errorMessages[] = trans('recaptcha::recaptcha.error-codes.' . $code);
                }
            } else {
                $this->errorCodes[]    = 'unknown';
                $this->errorMessages[] = trans('recaptcha::recaptcha.error-codes.unknown');
            }
        }
    }

    /**
     *  Check if the response is successful
     *
     *  @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     *  Return the error code/s
     *
     *  @return string|array
     */
    public function getErrorCodes()
    {
        return $this->errorCodes;
    }

    /**
     *  Return the error message
     *
     *  @return string
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}
