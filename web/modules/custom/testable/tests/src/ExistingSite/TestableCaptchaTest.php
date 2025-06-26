<?php

use Drupal\Tests\testable\Traits\CaptchaTrait;
use weitzman\DrupalTestTraits\ExistingSiteBase;

/**
 * A test class for basic features of the site.
 */
class TestableCaptchaTest extends ExistingSiteBase {

  use CaptchaTrait;

  /**
   * Tests that the login form does not have a captcha.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testLoginNoCaptcha() {
    $this->drupalGet('/user/login');
    $this->assertSession()->elementNotExists('css', 'fieldset.captcha');
    $this->assertCaptchaNotExists();
  }

  /**
   * Tests that the reset password form does not have a captcha.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testResetPasswordHasCaptcha() {
    $this->drupalGet('/user/password');
    $this->assertCaptchaExists();
  }

  /**
   * Tests that the register form does not have a captcha.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testRegisterHasCaptcha() {
    $this->drupalGet('/user/register');
    $this->assertCaptchaExists();
  }

}
