<?php

namespace Waavi\ReCaptcha\Test;

use Mockery;
use Waavi\ReCaptcha\IO\Broker;
use Waavi\ReCaptcha\IO\Response;
use Waavi\ReCaptcha\ReCaptcha;

class ReCaptchaTest extends TestCase
{
    /**
     *  @test
     */
    public function it_parses_input()
    {
        $broker   = Mockery::mock(Broker::class);
        $response = Mockery::mock(Response::class);
        $broker->shouldReceive('getResponse')->with('input')->andReturn($response);
        $recaptcha = new ReCaptcha($broker, 'site-key');
        $response  = $recaptcha->parseInput('input');
    }

    /**
     *  @test
     */
    public function it_renders_the_form()
    {
        $this->app['recaptcha'];
        $broker    = Mockery::mock(Broker::class);
        $recaptcha = new ReCaptcha($broker, 'site-key');
        $rendered  = $recaptcha->render();
        $expected  = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha" data-sitekey="site-key"></div>
';
        $this->assertEquals($expected, $rendered);
    }

    /**
     *  @test
     */
    public function it_renders_the_form_with_options()
    {
        $this->app['recaptcha'];
        $broker    = Mockery::mock(Broker::class);
        $recaptcha = new ReCaptcha($broker, 'site-key');
        $rendered  = $recaptcha->render(['theme' => 'dark', 'size' => 'compact']);
        $expected  = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha" data-sitekey="site-key" data-theme="dark" data-size="compact"></div>
';
        $this->assertEquals($expected, $rendered);
    }

    /**
     *  @test
     */
    public function the_alias_works()
    {
        $rendered = \ReCaptcha::render();
        $expected = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha" data-sitekey=""></div>
';
        $this->assertEquals($expected, $rendered);
    }
}
