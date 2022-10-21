<?php

use Drupal\Core\Template\Attribute;
use Drupal\uni_features\Option\SectionOptionHandler;

// Invoke section option handler
$paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();
Drupal::classResolver(SectionOptionHandler::class)->preprocess($variables, $paragraph);

// Add layout classes
$layout = $variables['layout'];
$variables['attributes']['class'][] = 'layout';
$variables['attributes']['class'][] = 'layout--section';
$variables['attributes']['class'][] = 'layout--section--' . $layout->id();
$variables['attributes']['class'][] = $variables['style_class'];

// Add wrapper classes
$variables['wrapper_attributes'] = new Attribute();
$variables['wrapper_attributes']->addClass('wrapper');
$variables['wrapper_attributes']->addClass($variables['style_class']);

// Add main region classes
$variables['region_attributes']['main']->addClass('region');
$variables['region_attributes']['main']->addClass('region--main');
$variables['region_attributes']['main']->addClass($variables['style_class']);
