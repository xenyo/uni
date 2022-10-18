<?php

namespace Drupal\uni_features\Styler;

class LayoutSectionStyler extends ResponsiveStyler {

  protected function getFields(): array {
    return [
      'display',
      'margin',
      'margin_directions',
      'padding',
      'padding_directions'
    ];
  }

  protected function getStyles(array $values, string $style_class): array {
    $style = [];

    if (isset($values['display'])) {
      $selector = ".region--main.$style_class";
      $property = 'display';
      $value = $values['display']->getString() . '!important';
      $style[$selector][$property] = $value;
    }

    if (isset($values['margin'])) {
      $selector = ".layout--section.$style_class";
      $property = 'margin';
      $value = $values['margin']->getString() . '!important';

      if (isset($values['margin_directions'])) {
        foreach ($values['margin_directions']->getValue() as $direction) {
          $property = 'margin-' . $direction['value'];
          $style[$selector][$property] = $value;
        }
      } else {
        $style[$selector][$property] = $value;
      }
    }

    if (isset($values['padding'])) {
      $selector = ".layout--section.$style_class";
      $property = 'padding';
      $value = $values['padding']->getString() . '!important';

      if (isset($values['padding_directions'])) {
        foreach ($values['padding_directions']->getValue() as $direction) {
          $property = 'padding-' . $direction['value'];
          $style[$selector][$property] = $value;
        }
      } else {
        $style[$selector][$property] = $value;
      }
    }

    return $style;
  }

}
