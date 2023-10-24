<?php

use Robo\Tasks;

/**
 * Use the fully-qualified AllowDynamicProperties, otherwise the #[AllowDynamicProperties] attribute on "MyClass" WILL NOT WORK.
 */

use \AllowDynamicProperties;

#[AllowDynamicProperties]
class RoboFile extends Tasks {

  /**
   * @aliases hi
   */
  public function helloWorld(string $year) {
    $this->yell("Hello world in $year!");
  }

}
