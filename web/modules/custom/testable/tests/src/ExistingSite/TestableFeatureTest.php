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

  /**
   * Test that the content_editor role exists and has correct permissions.
   */
  public function testContentEditRoleExists() {
    $role = \Drupal::entityTypeManager()->getStorage('user_role')->load('content_editor');
    $this->assertNotNull($role, 'The content_editor role should exist.');
    $this->assertTrue($role->hasPermission('create article content'), 'The content_editor role should have permission to create article content.');
    $this->assertTrue($role->hasPermission('edit any article content'), 'The content_editor role should have permission to edit any article content.');
  }

  /**
   * Tests creating an article.
   *
   * @group test-21
   */
  public function testCreateArticle() {
    $contentEditor = $this->createUser([], 'dtt_content_edit@mailinator.com', FALSE, [
      'mail' => 'dtt_content_edit@mailinator.com',
      'field_first_name' => 'Content',
      'field_last_name' => 'Editor',
      'pass' => 'pass1234!',
    ]);
    $contentEditor->addRole('content_editor');
    $contentEditor->save();

    $this->drupalLogin($contentEditor);
    $this->drupalget('/node/add/article');
    $this->assertSession()->fieldNotExists('Title');
    $this->assertSession()->fieldExists('Enter a new title');
  }


  /**
   * Tests updating an article.
   *
   * @group test-21
   */
  public function testUpdateArticle() {
    $contentEditor = $this->createUser([], 'dtt_content_edit@mailinator.com', FALSE, [
      'mail' => 'dtt_content_edit@mailinator.com',
      'field_first_name' => 'Content',
      'field_last_name' => 'Editor',
      'pass' => 'pass1234!',
    ]);
    $contentEditor->addRole('content_editor');
    $contentEditor->save();

    $article = $this->createNode([
      'type' => 'article',
      'title' => 'Test Article',
      'uid' => $contentEditor->id(),
      'body' => [
        'value' => 'This is the body of the test article.',
        'format' => 'basic_html',
      ],
    ]);

    $this->drupalLogin($contentEditor);
    $this->drupalget('/node/' . $article->id() . '/edit');
    $this->assertSession()->fieldNotExists('Title');
    $this->assertSession()->fieldExists("Update this article's title");
  }

}
