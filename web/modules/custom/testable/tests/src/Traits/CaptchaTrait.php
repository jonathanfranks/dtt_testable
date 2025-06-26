<?php

namespace Drupal\Tests\testable\Traits;

/**
 * Trait to enable/disable Captcha challenges.
 */
trait CaptchaTrait {

  /**
   * List of disabled captchas.
   *
   * @var array
   */
  protected $disabledCaptchas = [];

  /**
   * Disable recaptcha somewhere.
   */
  protected function disableRecaptcha(string $captcha_id) {
    $config = \Drupal::getContainer()
      ->get('config.factory')
      ->getEditable('captcha.captcha_point.' . $captcha_id);
    $config->set('status', FALSE);
    $config->save();

    $this->disabledCaptchas[$captcha_id] = $captcha_id;
  }

  /**
   * Re-enable recaptcha on the Venture sign up form.
   */
  protected function enableRecaptcha(string $captcha_id) {
    $config = \Drupal::getContainer()
      ->get('config.factory')
      ->getEditable('captcha.captcha_point.' . $captcha_id);
    $config->set('status', TRUE);
    $config->save();
  }

  /**
   * Re-enable recaptcha on the Venture sign up form.
   */
  protected function enableAllRecaptchas() {
    foreach ($this->disabledCaptchas as $disabledCaptcha) {
      $config = \Drupal::getContainer()
        ->get('config.factory')
        ->getEditable('captcha.captcha_point.' . $disabledCaptcha);
      $config->set('status', TRUE);
      $config->save();
    }
  }

  /**
   * Check that Captcha exists.
   */
  public function assertCaptchaExists() {
    $this->assertSession()->elementExists('css', 'input[name="captcha_token"]');
  }

  /**
   * Check that Captcha does not exist.
   */
  public function assertCaptchaNotExists() {
    $this->assertSession()->elementNotExists('css', 'input[name="captcha_token"]');
  }

}
