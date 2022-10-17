<?php

use Drupal\uni_features\Style\SectionStyle;

$paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();
$self = 'paragraph--' . $paragraph->id();

// Add self class
$variables['attributes']['class'] = $self;

// Add styles
$variables['styles'] = \Drupal::classResolver(SectionStyle::class)->style($paragraph, $self);
