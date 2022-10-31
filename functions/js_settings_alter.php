<?php

/**
 * Implements hook_js_settings_alter().
 */
function uni_js_settings_alter(&$settings) {
  $settings['toolbar']['breakpoints'] = [
    'toolbar.narrow' => 'all',
    'toolbar.standard' => 'all',
    'toolbar.wide' => 'all',
  ];
}
