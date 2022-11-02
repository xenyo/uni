<?php

/**
 * Implements hook_page_attachments().
 */
function uni_page_attachments(&$attachments) {
  $attachments['#attached']['library'][] = 'uni/uni-wrapper';
}
