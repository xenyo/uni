<?php

use Drupal\Component\Utility\Html;
use Drupal\Core\Template\AttributeHelper;

function uni_preprocess(&$variables, $hook, $info) {
  $variables['base_path'] = base_path();
  $variables['path'] = base_path() . $info['path'];
  $variables['theme_path'] = base_path() . $info['theme path'];

  if (substr($hook, 0, 8) === 'pattern_') {
    $id = Html::cleanCssIdentifier(substr($hook, 8));
    $variables['attributes'] = AttributeHelper::mergeCollections(
      $variables['attributes'] ?? [],
      [ 'class' => $id ],
    );

    if (isset($variables['variant'])) {
      $variant = Html::cleanCssIdentifier($variables['variant']);
      if (!empty($variant)) {
        $variables['attributes'] = AttributeHelper::mergeCollections(
          $variables['attributes'] ?? [],
          [ 'class' => "$id--$variant" ],
        );
      }
    }
  }
}
