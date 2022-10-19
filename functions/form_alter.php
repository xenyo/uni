<?php

use Drupal\Core\Render\Element;

/**
 * Implements hook_form_alter().
 */
function uni_features_form_alter(&$form, $form_state, $form_id) {
  switch ($form_id) {
    case 'layout_paragraphs_component_form':
      $form['#attached']['library'][] = 'uni_features/layout-paragraphs-component-form';
      foreach (Element::children($form) as $key) {
        if (isset($form[$key]['widget'][0]['select'])) {
          $form[$key]['widget'][0]['select']['#empty_option'] = t('- Auto -');
        }
      }
      break;

    case 'node_page_form':
    case 'node_page_edit_form':
      $form['#attached']['library'][] = 'uni_features/node-page-form';
      break;
  }
}
