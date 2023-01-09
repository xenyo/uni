<?php

use Drupal\Core\Template\Attribute;
use Drupal\Core\Template\AttributeHelper;

function uni_preprocess_layout(&$variables) {
  $variables['attributes'] = AttributeHelper::mergeCollections(
    $variables['attributes'] ?? [],
    [ 'class' => $variables['suggestions'] ],
  );

  if (isset($variables['settings']['layout_paragraphs_section'])) {
    $paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();

    // Add wrapper attributes
    $variables['wrapper_attributes'] = new Attribute([ 'class' => 'uni-wrapper' ]);
    if ($paragraph->hasField('uni_section_horizontal')) {
      $class = $paragraph->get('uni_section_horizontal');
      $variables['wrapper_attributes']->addClass($class->getString());
    }

    // Add region attributes
    foreach ($variables['region_attributes'] as $region => $attributes) {
      $attributes->addClass('region');
      $attributes->addClass('region--' . $region);
    }
  }
}
