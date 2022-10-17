<?php

namespace Drupal\uni_features\Style;

use Drupal\Core\Entity\FieldableEntityInterface;

interface StyleInterface {

  public function style(FieldableEntityInterface $entity, string $self): array;

}
