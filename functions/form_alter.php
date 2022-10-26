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
        if (isset($form[$key]['widget'][0]['field']) && $form[$key]['widget'][0]['field']['#type'] === 'textfield') {
          $form[$key]['widget'][0]['field']['#size'] = 20;
        }
      }
      foreach (['', '_lg', '_md', '_sm'] as $suffix) {
        $form["margin_directions$suffix"]['#states'] = [
          'invisible' => [
            ":input[name='margin${suffix}[0][select]']" => [
              'value' => '',
            ],
          ],
        ];
        $form["padding_directions$suffix"]['#states'] = [
          'invisible' => [
            ":input[name='padding${suffix}[0][select]']" => [
              'value' => '',
            ],
          ],
        ];
        $form["gap_directions$suffix"]['#states'] = [
          'invisible' => [
            ":input[name='gap${suffix}[0][select]']" => [
              'value' => '',
            ],
          ],
        ];
      }
      $form['wrapper_max_width']['#states'] = [
        'disabled' => [
          ':input[name="layout_paragraphs[layout]"][value=basic]' => [
            'checked' => TRUE,
          ],
        ],
      ];
      break;

    case 'node_page_form':
    case 'node_page_edit_form':
      $form['#attached']['library'][] = 'uni_features/node-page-form';
      break;
  }
}
