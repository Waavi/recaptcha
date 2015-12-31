<?php

namespace Waavi\ReCaptcha\Test;

use Waavi\ReCaptcha\GoogleResponse;

class GoogleResponseTest extends TestCase
{
    /**
     *  @test
     */
    public function it_parses_successful_responses()
    {
        $input = json_encode([
            'success' => true,
        ]);
        $response = new GoogleResponse($input);
        $this->assertTrue($response->isSuccess());
        $this->assertEquals([], $response->getErrorCodes());
        $this->assertEquals([], $response->getErrorMessage());
    }

    /**
     *  @test
     */
    public function it_ignores_error_codes_on_success()
    {
        $input = json_encode([
            'success'     => true,
            'error-codes' => ['missing-input-secret', 'invalid-input-secret'],
        ]);
        $response = new GoogleResponse($input);
        $this->assertTrue($response->isSuccess());
        $this->assertEquals([], $response->getErrorCodes());
        $this->assertEquals([], $response->getErrorMessage());
    }

    /**
     *  @test
     */
    public function it_parses_error_codes_on_error()
    {
        $input = json_encode([
            'success'     => false,
            'error-codes' => ['missing-input-secret', 'invalid-input-secret'],
        ]);
        $response = new GoogleResponse($input);
        $this->assertFalse($response->isSuccess());
        $this->assertEquals(['missing-input-secret', 'invalid-input-secret'], $response->getErrorCodes());
        $this->assertEquals(['The secret parameter is missing.', 'The secret parameter is invalid or malformed.'], $response->getErrorMessage());
    }

    /**
     *  @test
     */
    public function it_generates_default_error_message_on_missing_error_code()
    {
        $input = json_encode([
            'success' => false,
        ]);
        $response = new GoogleResponse($input);
        $this->assertFalse($response->isSuccess());
        $this->assertEquals(['unknown'], $response->getErrorCodes());
        $this->assertEquals(['Unknown Google ReCaptcha error.'], $response->getErrorMessage());
    }

    /**
     *  @test
     */
    public function it_generates_default_error_message_on_unknown_error_code()
    {
        $input = json_encode([
            'success'     => false,
            'error-codes' => ['non-error-code'],
        ]);
        $response = new GoogleResponse($input);
        $this->assertFalse($response->isSuccess());
        $this->assertEquals(['unknown'], $response->getErrorCodes());
        $this->assertEquals(['Unknown Google ReCaptcha error.'], $response->getErrorMessage());
    }
}
