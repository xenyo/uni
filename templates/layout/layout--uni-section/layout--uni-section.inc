<?php

use Drupal\Core\Template\Attribute;

// Get paragraph entity
$paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();
$variables['paragraph'] = $paragraph;

// Add layout classes
$layout = $variables['layout'];
$variables['attributes']['class'][] = 'layout';
$variables['attributes']['class'][] = 'layout--uni-section';
$variables['attributes']['class'][] = 'layout--uni-section--' . $layout->id();

// Add wrapper classes
$variables['wrapper_attributes'] = new Attribute();
$variables['wrapper_attributes']->addClass('wrapper');
if ($paragraph->hasField('wrapper_width')) {
  $field = $paragraph->get('wrapper_width');
  if (!$field->isEmpty()) {
    $variables['wrapper_attributes']->addClass('wrapper--' . $field->getString());
  }
}

// Add main region classes
foreach ($variables['region_attributes'] as $region => $attributes) {
  $variables['region_attributes'][$region]->addClass('region');
  $variables['region_attributes'][$region]->addClass("region--$region");
}
