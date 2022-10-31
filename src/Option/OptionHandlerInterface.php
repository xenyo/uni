<?php

namespace Drupal\uni\Option;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\FieldableEntityInterface;

interface OptionHandlerInterface extends ContainerInjectionInterface {

  public function preprocess(array &$variables, FieldableEntityInterface $entity): void;

}
