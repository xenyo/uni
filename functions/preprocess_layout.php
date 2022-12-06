<?php

use Drupal\Core\Template\Attribute;

function uni_preprocess_layout(&$variables) {
  if (!isset($variables['settings']['layout_paragraphs_section'])) {
    return;
  }

  $paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();

  // Add wrapper attributes
  $variables['wrapper_attributes'] = new Attribute([ 'class' => 'uni-wrapper' ]);
  if ($paragraph->hasField('uni_section_wrapper_classes')) {
    $terms = $paragraph->uni_section_wrapper_classes->referencedEntities();
    foreach ($terms as $term) {
      $variables['wrapper_attributes']->addClass($term->label());
    }
  }

  // Add layout attributes
  if ($paragraph->hasField('uni_section_layout_classes')) {
    $terms = $paragraph->uni_section_layout_classes->referencedEntities();
    foreach ($terms as $term) {
      $variables['attributes']['class'][] = $term->label();
    }
  }

  // Add region attributes
  foreach ($variables['region_attributes'] as $region => $attributes) {
    $attributes->addClass('region');
    $attributes->addClass('region--' . $region);
  }
  if ($paragraph->hasField('uni_section_region_classes')) {
    $terms = $paragraph->uni_section_region_classes->referencedEntities();
    foreach ($terms as $term) {
      foreach ($variables['region_attributes'] as $region => $attributes) {
        $attributes->addClass($term->label());
      }
    }
  }
}
