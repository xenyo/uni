<?php

namespace Drupal\uni\Option;

use Drupal\Core\Entity\FieldableEntityInterface;

interface OptionHandlerInterface {

  public function preprocess(array &$variables, FieldableEntityInterface $entity): void;

}
