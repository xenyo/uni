<?php

function uni_page_attachments(&$attachments) {
  if (Drupal::service('router.admin_context')->isAdminRoute()) {
    $attachments['#attached']['library'][] = 'select2_all/select2';
    $attachments['#attached']['library'][] = 'uni/admin';
    $attachments['#attached']['library'][] = 'uni/fontawesome';
    $attachments['#attached']['library'][] = 'uni/really';
  }
}
