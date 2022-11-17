<?php

namespace Drupal\uni;

/**
 * Provides an interface for favicon handlers.
 *
 * @package Drupal\uni
 */
interface FaviconHandlerInterface {

  /**
   * Implements hook_page_attachments().
   */
  public function pageAttachments(array &$attachments, string $module): void;

}
