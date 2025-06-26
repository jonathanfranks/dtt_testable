<?php

use Drupal\Tests\testable\Traits\CaptchaTrait;
use weitzman\DrupalTestTraits\ExistingSiteBase;

/**
 * A test class for basic features of the site.
 */
class TestableCaptchaTest extends ExistingSiteBase {

  use CaptchaTrait;

  /**
   * {@inheritDoc}
   */
  public function tearDown(): void {
    $this->enableAllRecaptchas();
    parent::tearDown();
  }

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


  /**
   * Tests the reset password function.
   */
  public function testForgotPasswordExistingAccount() {
    $this->disableRecaptcha('user_pass');
    $user = $this->createUser([], 'user@mailinator.com', FALSE, [
      'mail' => 'user@mailinator.com',
      'field_first_name' => 'Existing',
      'field_last_name' => 'User',
      'pass' => 'pass1234!',
    ]);

    $this->drupalGet('/user/password');
    $this->getCurrentPage()->fillField('Username or email address', $user->getEmail());
    $this->getCurrentPage()->pressButton('Submit');
    $this->assertSession()->pageTextContains('If user@mailinator.com is a valid account, an email will be sent with instructions to reset your password.');
  }

}
