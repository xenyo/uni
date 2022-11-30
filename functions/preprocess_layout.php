<?php

use Drupal\Core\Template\Attribute;

function uni_preprocess_layout(&$variables) {
  if (!isset($variables['settings']['layout_paragraphs_section'])) {
    return;
  }

  $paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();

  // Add layout attributes
  $variables['attributes']['class'] = $variables['suggestions'];

  // Add wrapper attributes
  $variables['wrapper_attributes'] = new Attribute();
  $variables['wrapper_attributes']->addClass('uni-wrapper');
  if ($paragraph->hasField('uni_section_width')) {
    $width = $paragraph->get('uni_section_width')->getString();
    if ($width !== 'standard') {
      $variables['wrapper_attributes']->addClass('uni-wrapper--' . $width);
    }
  }

  // Add region attributes
  foreach ($variables['region_attributes'] as $region => $attributes) {
    $attributes->addClass('region');
    $attributes->addClass('region--' . $region);
  }
}
