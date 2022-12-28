<?php

use Drupal\Core\Template\Attribute;

function uni_preprocess_layout(&$variables) {
  if (!isset($variables['settings']['layout_paragraphs_section'])) {
    return;
  }

  $paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();

  // Add wrapper attributes
  $variables['wrapper_attributes'] = new Attribute([ 'class' => 'uni-wrapper' ]);
  if ($paragraph->hasField('uni_section_horizontal')) {
    $class = $paragraph->get('uni_section_horizontal');
    $variables['wrapper_attributes']->addClass($class->getString());
  }

}
