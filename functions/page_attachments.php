<?php

/**
 * Implements hook_page_attachments().
 */
function uni_features_page_attachments(&$attachments) {
  $attachments['#attached']['library'][] = 'uni_features/field-group';
  $attachments['#attached']['library'][] = 'uni_features/fontawesome';
  $attachments['#attached']['library'][] = 'uni_features/jquery-ui';
  $attachments['#attached']['library'][] = 'uni_features/wrapper';
}
