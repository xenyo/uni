<?php

function uni_preprocess(&$variables, $hook, $info) {
  $variables['base_path'] = base_path();
  $variables['path'] = base_path() . $info['path'];
  $variables['theme_path'] = base_path() . $info['theme path'];
}
