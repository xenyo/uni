<?php

namespace Drupal\uni_features\Style;

class SectionStyle extends Style {

  protected function getFields(): array {
    return [
      'display',
    ];
  }

  protected function getStyle(array $values, string $self): array {
    $style = [];

    if (isset($values['display'])) {
      $style[".$self .region--main"]['display'] = $values['display'] . '!important';
    }

    return $style;
  }

}
