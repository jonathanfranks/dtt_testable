<?php

use weitzman\DrupalTestTraits\ExistingSiteBase;

/**
 * A test class for basic features of the site.
 */
class FeatureTest extends ExistingSiteBase {

  public function testAnonHomePage() {
    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->linkExists('Home');
    $this->assertSession()->linkExists('Log in');
  }

}
