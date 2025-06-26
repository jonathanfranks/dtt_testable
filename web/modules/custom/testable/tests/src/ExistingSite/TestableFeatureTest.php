<?php

use weitzman\DrupalTestTraits\ExistingSiteBase;

/**
 * A test class for basic features of the site.
 */
class TestableFeatureTest extends ExistingSiteBase {

  /**
   * Tests that the anonymous home page loads correctly.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testAnonHomePage() {
    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->linkExists('Home');
    $this->assertSession()->linkExists('Log in');
  }

}
