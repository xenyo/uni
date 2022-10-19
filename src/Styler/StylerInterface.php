<?php

namespace Drupal\uni_features\Styler;

use Drupal\Core\Entity\FieldableEntityInterface;

interface StylerInterface {

  public function getStyleClass(FieldableEntityInterface $entity): string;

  public function getStyleTags(FieldableEntityInterface $entity): array;

}