<?php

/**
 * Implements hook_field_group_build_pre_render_alter().
 */
function uni_features_field_group_form_process(array &$element, &$group, &$complete_form) {
  switch ($group->group_name) {
    case 'group_wrapper':
      $element['#states'] = [
        'invisible' => [
          ':input[name="layout_paragraphs[layout]"][value=basic]' => [
            'checked' => TRUE,
          ],
        ],
      ];
      break;
  }
}
