<?php

/**
 * Implements hook_toolbar_alter().
 */
function uni_toolbar_alter(&$items) {
  unset($items['coffee']);
  unset($items['devel']);
  unset($items['user']);
}
