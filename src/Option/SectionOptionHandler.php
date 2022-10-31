<?php

namespace Drupal\uni\Option;

class SectionOptionHandler extends ResponsiveOptionHandler {

  protected function style(array &$dataset, string $style_class): void {
    $state = [];

    foreach ($dataset as $suffix => $data) {
      if (!isset($data['fields'])) {
        continue;
      }

      $state = array_merge($state, $data['fields']);
      $dataset[$suffix]['styles'] = $this->computeStyles($data, $style_class, $state);
    }
  }

  protected function computeStyles($data, $style_class, $state) {
    $fields = $data['fields'];
    $styles = [];

    /**
     * Selectors
     */
    $layout_selector = ".layout--section.$style_class";
    $wrapper_selector = ".wrapper.$style_class";
    $content_selector = ".region--main.$style_class";
    $child_selector = ".region--main.$style_class > .paragraph";

    /**
     * Layout display
     */
    if (isset($fields['display'])) {
      $display = $fields['display']->getString();

      if (in_array($display, ['block', 'none'])) {
        $styles[$layout_selector]['display'] = "$display!important";
      }
    }

    /**
     * Layout margin
     */
    if (isset($fields['margin'])) {
      $margin = trim($fields['margin']->getString());

      if (strpos($margin, ' ') !== FALSE) {
        $styles[$layout_selector]['margin'] = "$margin!important";
      }
      else if (isset($fields['margin_directions'])) {
        foreach ($fields['margin_directions']->getValue() as $direction) {
          if (in_array($direction['value'], ['top', 'bottom', 'left', 'right'])) {
            $property = 'margin-' . $direction['value'];
            $styles[$layout_selector][$property] = "$margin!important";
          }
        }
      }
      else {
        $styles[$layout_selector]['margin'] = "$margin!important";
      }
    }

    /**
     * Layout padding
     */
    if (isset($fields['padding'])) {
      $padding = trim($fields['padding']->getString());

      if (strpos($padding, ' ') !== FALSE) {
        $styles[$layout_selector]['padding'] = "$padding!important";
      }
      if (isset($fields['padding_directions'])) {
        foreach ($fields['padding_directions']->getValue() as $direction) {
          if (in_array($direction['value'], ['top', 'bottom', 'left', 'right'])) {
            $property = 'padding-' . $direction['value'];
            $styles[$layout_selector][$property] = "$padding!important";
          }
        }
      } else {
        $styles[$layout_selector]['padding'] = "$padding!important";
      }
    }

    /**
     * Wrapper max width
     */
    if (isset($fields['wrapper_max_width'])) {
      $property = '--wrapper-max-width';
      $max_width = $fields['wrapper_max_width']->getString();
      if (in_array($max_width, ['narrow', 'full'])) {
        $styles[$wrapper_selector][$property] = "var(--wrapper-max-width--$max_width)!important";
      }
      else if (is_numeric(substr($max_width, 0, 1))) {
        $styles[$wrapper_selector][$property] = "$max_width!important";
      }
    }

    /**
     * Wrapper padding
     */
    if (isset($fields['wrapper_padding'])) {
      $padding = $fields['wrapper_padding']->getString();
      $suffix = str_replace('_', '-', $data['suffix']);
      $property = "--wrapper-padding$suffix";
      $styles[$wrapper_selector][$property] = "0 $padding!important";
    }

    /**
     * Content display
     */
    if (isset($fields['content_display'])) {
      $display = $fields['content_display']->getString();

      if (in_array($display, ['block', 'grid', 'flex'])) {
        $styles[$content_selector]['display'] = "$display!important";
      }
    }

    /**
     * Columns
     */
    if (isset($fields['columns'])) {
      $columns = $fields['columns']->getString();
      $display = isset($state['content_display']) ? $state['content_display']->getString() : 'grid';

      if ($display === 'grid') {
        if (is_numeric($columns)) {
          $styles[$content_selector]['grid-template-columns'] = "repeat($columns, 1fr)!important";
        }
        else {
          $styles[$content_selector]['grid-template-columns'] = "$columns!important";
        }
        if (!isset($state['content_display'])) {
          $styles[$content_selector]['display'] = 'grid!important';
        }
      }
      else if ($display === 'flex') {
        $gap = "var(--$style_class--column-gap, 0)";
        $styles[$child_selector]['flex-basis'] = "calc(100% / $columns - $gap * ($columns - 1) / $columns)!important";
        $styles[$child_selector]['box-sizing'] = 'border-box!important';
      }
    }

    /**
     * Gap
     */
    if (isset($fields['gap'])) {
      $gap = trim($fields['gap']->getString());

      $var_gap = "--$style_class--gap";
      $var_row_gap = "--$style_class--row-gap";
      $var_column_gap = "--$style_class--column-gap";

      if (strpos($gap, ' ') !== FALSE) {
        $styles[$content_selector][$var_gap] = "$gap!important";
        $styles[$content_selector]['gap'] = "var($var_gap)!important";

        $gaps = explode(' ', $gap);
        $styles[$content_selector][$var_row_gap] = $gaps[0] . '!important';
        $styles[$content_selector][$var_column_gap] = $gaps[1] . '!important';
      }
      else if (isset($fields['gap_directions'])) {
        foreach ($fields['gap_directions']->getValue() as $direction) {
          if (in_array($direction['value'], ['row', 'column'])) {
            $property = $direction['value'] . '-gap';
            $var = "--$style_class--" . $direction['value'] . '-gap';
            $styles[$content_selector][$var] = "$gap!important";
            $styles[$content_selector][$property] = "var($var)!important";
          }
        }
      }
      else {
        $styles[$content_selector][$var_gap] = "$gap!important";
        $styles[$content_selector][$var_row_gap] = "$gap!important";
        $styles[$content_selector][$var_column_gap] = "$gap!important";
        $styles[$content_selector]['gap'] = "var($var_gap)!important";
      }
    }

    
    /**
     * Justify content
     */
    if (isset($fields['justify_content'])) {
      $justify_content = $fields['justify_content']->getString();
      $styles[$content_selector]['justify-content'] = "$justify_content!important";
    }

    /**
     * Align items
     */
    if (isset($fields['align_items'])) {
      $align_items = $fields['align_items']->getString();
      $styles[$content_selector]['align-items'] = "$align_items!important";
    }

    /**
     * Auto columns min width
     */
    if (isset($fields['auto_columns_min_width'], $state['content_display'])) {
      $display = $state['content_display']->getString();
      if ($display === 'grid') {
        $min_width = $fields['auto_columns_min_width']->getString();
        $styles[$content_selector]['grid-template-columns'] = "repeat(auto-fit, minmax(min($min_width, 100%), 1fr))!important";
      }
    }

    return $styles;
  }

}
