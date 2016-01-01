<?php

namespace Waavi\ReCaptcha\Test\IO;

use Waavi\ReCaptcha\IO\Response;
use Waavi\ReCaptcha\Test\TestCase;

class ResponseTest extends TestCase
{
    /**
     *  @test
     */
    public function it_parses_successful_responses()
    {
        $input = json_encode([
            'success' => true,
        ]);
        $response = new Response($input);
        $this->assertTrue($response->isSuccess());
        $this->assertEquals([], $response->getErrorCodes());
        $this->assertEquals([], $response->getErrorMessages());
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
        $response = new Response($input);
        $this->assertTrue($response->isSuccess());
        $this->assertEquals([], $response->getErrorCodes());
        $this->assertEquals([], $response->getErrorMessages());
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
        $response = new Response($input);
        $this->assertFalse($response->isSuccess());
        $this->assertEquals(['missing-input-secret', 'invalid-input-secret'], $response->getErrorCodes());
        $this->assertEquals([trans('recaptcha::recaptcha.error-codes.missing-input-secret'), trans('recaptcha::recaptcha.error-codes.invalid-input-secret')], $response->getErrorMessages());
    }

    /**
     *  @test
     */
    public function it_generates_default_error_message_on_missing_error_code()
    {
        $input = json_encode([
            'success' => false,
        ]);
        $response = new Response($input);
        $this->assertFalse($response->isSuccess());
        $this->assertEquals(['unknown'], $response->getErrorCodes());
        $this->assertEquals([trans('recaptcha::recaptcha.error-codes.unknown')], $response->getErrorMessages());
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
        $response = new Response($input);
        $this->assertFalse($response->isSuccess());
        $this->assertEquals(['unknown'], $response->getErrorCodes());
        $this->assertEquals([trans('recaptcha::recaptcha.error-codes.unknown')], $response->getErrorMessages());
    }

    /**
     *  @test
     */
    public function it_parses_empty_responses_as_unknown_error()
    {
        $input    = null;
        $response = new Response($input);
        $this->assertFalse($response->isSuccess());
        $this->assertEquals(['unknown'], $response->getErrorCodes());
        $this->assertEquals([trans('recaptcha::recaptcha.error-codes.unknown')], $response->getErrorMessages());
    }
}
