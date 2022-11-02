<?php

namespace Drupal\uni\Option;

use Drupal\Core\Entity\FieldableEntityInterface;

class AttributeOptionHandler implements OptionHandlerInterface {

  public function preprocess(array &$variables, FieldableEntityInterface $entity): void {
    if ($entity->hasField('uni_attr_id')) {
      $attr_id = $entity->get('uni_attr_id')->getString();
      if (!empty($attr_id)) {
        $variables['attributes']['id'] = $attr_id;
      }
    }

    if ($entity->hasField('uni_attr_class')) {
      $attr_class = $entity->get('uni_attr_class')->getString();
      if (!empty($attr_class)) {
        $variables['attributes']['class'][] = $attr_class;
      }
    }
  }

}
