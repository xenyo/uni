<?php

namespace Drupal\uni_features\Option;

use Drupal\Core\Entity\FieldableEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AttributeOptionHandler implements OptionHandlerInterface {

  public static function create(ContainerInterface $container) {
    return new static();
  }

  public function preprocess(array &$variables, FieldableEntityInterface $entity): void {
    if ($entity->hasField('attribute_id')) {
      $value = $entity->get('attribute_id')->getString();
      if (!empty($value)) {
        $variables['attributes']['id'] = $value;
      }
    }

    if ($entity->hasField('attribute_class')) {
      $value = $entity->get('attribute_class')->getString();
      if (!empty($value)) {
        $variables['attributes']['class'][] = $value;
      }
    }
  }

}
