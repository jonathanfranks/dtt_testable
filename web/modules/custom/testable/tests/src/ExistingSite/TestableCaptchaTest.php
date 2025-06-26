<?php

use weitzman\DrupalTestTraits\ExistingSiteBase;

/**
 * A test class for basic features of the site.
 */
class TestableCaptchaTest extends ExistingSiteBase {

  /**
   * Tests that the login form does not have a captcha.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testLoginNoCaptcha() {
    $this->drupalGet('/user/login');
    $this->assertSession()->elementNotExists('css', 'fieldset.captcha');
  }

  /**
   * Tests that the reset password form does not have a captcha.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testResetPasswordHasCaptcha() {
    $this->drupalGet('/user/password');
    $this->assertSession()->elementExists('css', 'fieldset.captcha');
  }

  /**
   * Tests that the register form does not have a captcha.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testRegisterHasCaptcha() {
    $this->drupalGet('/user/register');
    $this->assertSession()->elementExists('css', 'fieldset.captcha');
  }

}
