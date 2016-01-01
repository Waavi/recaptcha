<?php

namespace Waavi\ReCaptcha\Test;

use Mockery;
use Waavi\ReCaptcha\IO\Response;
use Waavi\ReCaptcha\ReCaptcha;
use Waavi\ReCaptcha\Validator;

class ValidatorTest extends TestCase
{
    /**
     *  @test
     */
    public function it_passes_on_correct_input()
    {
        $recaptcha = Mockery::mock(ReCaptcha::class);
        $response  = Mockery::mock(Response::class);
        $validator = new Validator($recaptcha);
        $recaptcha->shouldReceive('parseInput')->with('input')->andReturn($response);
        $response->shouldReceive('isSuccess')->andReturn(true);
        $success = $validator->validate('g-recaptcha-response', 'input', [], null);
        $this->assertTrue($success);
    }

    /**
     *  @test
     */
    public function it_fails_on_invalid_input()
    {
        $recaptcha = Mockery::mock(ReCaptcha::class);
        $response  = Mockery::mock(Response::class);
        $validator = new Validator($recaptcha);
        $recaptcha->shouldReceive('parseInput')->with('input')->andReturn($response);
        $response->shouldReceive('isSuccess')->andReturn(false);
        $success = $validator->validate('g-recaptcha-response', 'input', [], null);
        $this->assertFalse($success);
    }

    /**
     *  @test
     */
    public function it_fails_on_empty_input()
    {
        $input     = ['g-recaptcha-response' => ''];
        $rules     = ['g-recaptcha-response' => 'recaptcha'];
        $validator = $this->app['validator']->make($input, $rules);
        $this->assertFalse($validator->passes());
        $errorMsg = $validator->errors()->all()[0];
        $this->assertEquals('ReCaptcha error', $errorMsg);
    }
}
