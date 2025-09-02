<?php

namespace Drupal\verify\Entity;

/**
 * Trait that contains debugging functions.
 *
 * When you want to pause a test, for instance, use this trait and
 * pauseForUserInput() to halt execution of the test without pausing the site.
 *
 * @package Drupal\verify\Entity
 */
trait DebugTrait {

  /**
   * Pauses the test until user presses a key. Useful when debugging a scenario.
   */
  protected function pauseForUserInput() {
    fwrite(STDOUT, "\033[s \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue, or 'q' to quit...\033[0m");
    do {
      $line = trim(fgets(STDIN, 1024));
      // Note: this assumes ASCII encoding.  Should probably be revamped to
      // handle other character sets.
      $charCode = ord($line);
      switch ($charCode) {
        // CR.
        case 0:
          // Y.
        case 121:
          // Y.
        case 89:
          break 2;

        // Case 78: //N
        // case 110: //n.
        // q.
        case 113:
          // Q.
        case 81:
          throw new \Exception("Exiting test intentionally.");

        default:
          fwrite(STDOUT, sprintf("\nInvalid entry '%s'.  Please enter 'y', 'q', or the enter key.\n", $line));
          break;
      }
    } while (TRUE);
    fwrite(STDOUT, "\033[u");
  }

}
