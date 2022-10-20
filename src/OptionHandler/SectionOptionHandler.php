<?php

namespace Drupal\uni_features\OptionHandler;

class SectionOptionHandler extends ResponsiveOptionHandler {

  protected function getStyles(array $values, string $style_class): array {
    $style = [];

    // 1. Layout styles
    $layout_selector = ".layout--section.$style_class";

    if (isset($values['display'])) {
      $value = $values['display']->getString();

      if (in_array($value, ['block', 'none'])) {
        $style[$layout_selector]['display'] = "$value!important";
      }
    }

    if (isset($values['margin'])) {
      $value = $values['margin']->getString();

      if (isset($values['margin_directions'])) {
        foreach ($values['margin_directions']->getValue() as $direction) {
          if (in_array($direction['value'], ['top', 'bottom', 'left', 'right'])) {
            $property = 'margin-' . $direction['value'];
            $style[$layout_selector][$property] = "$value!important";
          }
        }
      } else {
        $style[$layout_selector]['margin'] = "$value!important";
      }
    }

    if (isset($values['padding'])) {
      $value = $values['padding']->getString();

      if (isset($values['padding_directions'])) {
        foreach ($values['padding_directions']->getValue() as $direction) {
          if (in_array($direction['value'], ['top', 'bottom', 'left', 'right'])) {
            $property = 'padding-' . $direction['value'];
            $style[$layout_selector][$property] = "$value!important";
          }
        }
      } else {
        $style[$layout_selector]['padding'] = "$value!important";
      }
    }

    // 2. Wrapper styles
    $wrapper_selector = ".wrapper.$style_class";

    if (isset($values['wrapper_max_width'])) {
      $property = '--wrapper-max-width';
      $value = $values['wrapper_max_width']->getString();
      if (in_array($value, ['narrow', 'full'])) {
        $style[$wrapper_selector][$property] = "var(--wrapper-max-width--$value)!important";
      }
      else if (is_numeric(substr($value, 0, 1))) {
        $style[$wrapper_selector][$property] = "$value!important";
      }
    }

    // 3. Content styles
    $content_selector = ".region--main.$style_class";

    if (isset($values['content_display'])) {
      $value = $values['content_display']->getString();

      if (in_array($value, ['block', 'grid', 'flex'])) {
        $style[$content_selector]['display'] = "$value!important";
      }
    }

    if (isset($values['grid_auto_columns_min_width'])) {
      $value = $values['grid_auto_columns_min_width']->getString();
      $style[$content_selector]['grid-template-columns'] = "repeat(auto-fit, minmax(min($value, 100%), 1fr))!important";
    }

    if (isset($values['grid_columns'])) {
      $value = $values['grid_columns']->getString();

      if (is_numeric($value)) {
        $style[$content_selector]['grid-template-columns'] = "repeat($value, 1fr)!important";
      }
      else {
        $style[$content_selector]['grid-template-columns'] = "$value!important";
      }
    }

    if (isset($values['gap'])) {
      $value = $values['gap']->getString();
      $style[$content_selector]['gap'] = "$value!important";
    }

    if (isset($values['align_items'])) {
      $value = $values['align_items']->getString();
      $style[$content_selector]['align-items'] = "$value!important";
    }

    if (isset($values['justify_content'])) {
      $value = $values['justify_content']->getString();
      $style[$content_selector]['justify-content'] = "$value!important";
    }

    return $style;
  }

}
