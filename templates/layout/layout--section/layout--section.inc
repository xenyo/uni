<?php

use Drupal\Core\Template\Attribute;
use Drupal\uni_features\Styler\SectionStyler;

$paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();
$styler = Drupal::classResolver(SectionStyler::class);
$style_class = $styler->getStyleClass($paragraph);

// Add layout classes
$variables['attributes']['class'][] = 'layout';
$variables['attributes']['class'][] = 'layout--section';
$variables['attributes']['class'][] = $style_class;

// Add wrapper classes
$variables['wrapper_attributes'] = new Attribute();
$variables['wrapper_attributes']->addClass('wrapper');
$variables['wrapper_attributes']->addClass($style_class);

// Add main region classes
$variables['region_attributes']['main']->addClass('region');
$variables['region_attributes']['main']->addClass('region--main');
$variables['region_attributes']['main']->addClass($style_class);

// Add style tags
$variables['styles'] = $styler->getStyleTags($paragraph);
