<?php

namespace Drupal\uni_features\Option;

class SectionOptionHandler extends ResponsiveOptionHandler {

  protected function style(array &$dataset, string $style_class): void {
    $state = [];

    foreach ($dataset as $suffix => $data) {
      if (!isset($data['fields'])) {
        continue;
      }
      $fields = $data['fields'];
      $styles = [];

      // 1. Layout styles
      $layout_selector = ".layout--section.$style_class";

      if (isset($fields['display'])) {
        $value = $fields['display']->getString();

        if (in_array($value, ['block', 'none'])) {
          $styles[$layout_selector]['display'] = "$value!important";
        }
      }

      if (isset($fields['margin'])) {
        $value = $fields['margin']->getString();

        if (isset($fields['margin_directions'])) {
          foreach ($fields['margin_directions']->getValue() as $direction) {
            if (in_array($direction['value'], ['top', 'bottom', 'left', 'right'])) {
              $property = 'margin-' . $direction['value'];
              $styles[$layout_selector][$property] = "$value!important";
            }
          }
        } else {
          $styles[$layout_selector]['margin'] = "$value!important";
        }
      }

      if (isset($fields['padding'])) {
        $value = $fields['padding']->getString();

        if (isset($fields['padding_directions'])) {
          foreach ($fields['padding_directions']->getValue() as $direction) {
            if (in_array($direction['value'], ['top', 'bottom', 'left', 'right'])) {
              $property = 'padding-' . $direction['value'];
              $styles[$layout_selector][$property] = "$value!important";
            }
          }
        } else {
          $styles[$layout_selector]['padding'] = "$value!important";
        }
      }

      // 2. Wrapper styles
      $wrapper_selector = ".wrapper.$style_class";

      if (isset($fields['wrapper_max_width'])) {
        $property = '--wrapper-max-width';
        $value = $fields['wrapper_max_width']->getString();
        if (in_array($value, ['narrow', 'full'])) {
          $styles[$wrapper_selector][$property] = "var(--wrapper-max-width--$value)!important";
        }
        else if (is_numeric(substr($value, 0, 1))) {
          $styles[$wrapper_selector][$property] = "$value!important";
        }
      }

      // 3. Content styles
      $content_selector = ".region--main.$style_class";

      if (isset($fields['content_display'])) {
        $value = $fields['content_display']->getString();

        if (in_array($value, ['block', 'grid', 'flex'])) {
          $styles[$content_selector]['display'] = "$value!important";
        }
      }

      if (isset($fields['grid_auto_columns_min_width'])) {
        $value = $fields['grid_auto_columns_min_width']->getString();
        $styles[$content_selector]['grid-template-columns'] = "repeat(auto-fit, minmax(min($value, 100%), 1fr))!important";
      }

      if (isset($fields['grid_columns'])) {
        $value = $fields['grid_columns']->getString();

        if (is_numeric($value)) {
          $styles[$content_selector]['grid-template-columns'] = "repeat($value, 1fr)!important";
        }
        else {
          $styles[$content_selector]['grid-template-columns'] = "$value!important";
        }
      }

      if (isset($fields['flex_columns'])) {
        $value = $fields['flex_columns']->getString();

        if (is_numeric($value)) {
          $gap = 0;

          if (isset($fields['gap'])) {
            $gap = $fields['gap']->getString();
          }
          else if (isset($state['gap'])) {
            $gap = $state['gap'];
          }
  
          $styles[$content_selector . ' > *']['width'] = "calc(100% / $value - $gap * ($value - 1) / $value)!important";
        }
      }

      if (isset($fields['gap'])) {
        $value = $fields['gap']->getString();
        $styles[$content_selector]['gap'] = "$value!important";
        $state['gap'] = $value;
      }

      if (isset($fields['align_items'])) {
        $value = $fields['align_items']->getString();
        $styles[$content_selector]['align-items'] = "$value!important";
      }

      if (isset($fields['justify_content'])) {
        $value = $fields['justify_content']->getString();
        $styles[$content_selector]['justify-content'] = "$value!important";
      }

      $dataset[$suffix]['styles'] = $styles;
    }
  }

}
