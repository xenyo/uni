<?php

use Drupal\uni_features\Styler\LayoutSectionStyler;

$paragraph = $variables['settings']['layout_paragraphs_section']->getEntity();
$styler = Drupal::classResolver(LayoutSectionStyler::class);
$variables['styles'] = $styler->getStyleTags($paragraph);
$variables['style_class'] = $styler->getStyleClass($paragraph);
