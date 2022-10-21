<?php

use Drupal\uni_features\Option\AttributeOptionHandler;

// Invoke attribute option handler
$paragraph = $variables['paragraph'];
Drupal::classResolver(AttributeOptionHandler::class)->preprocess($variables, $paragraph);
