<?php

use Drupal\Core\Template\Attribute;

// Get paragraph entity
$paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();
$variables['paragraph'] = $paragraph;

// Add layout classes
$layout = $variables['layout'];
$variables['attributes']['class'][] = 'layout';
$variables['attributes']['class'][] = 'layout--section';
$variables['attributes']['class'][] = 'layout--section--' . $layout->id();

// Add wrapper classes
$variables['wrapper_attributes'] = new Attribute();
$variables['wrapper_attributes']->addClass('wrapper');

// Add main region classes
foreach ($variables['region_attributes'] as $region => $attributes) {
  $variables['region_attributes'][$region]->addClass('region');
  $variables['region_attributes'][$region]->addClass("region--$region");
}
