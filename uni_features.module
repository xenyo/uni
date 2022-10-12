<?php

/**
 * Implements hook_layout_alter().
 */
function uni_features_layout_alter(&$definitions) {
  // Remove layout definitions provided by layout_discovery.
  $definitions = array_filter($definitions, function ($definition) {
    return $definition->getProvider() !== 'layout_discovery';
  });
}
