<?php

namespace Drupal\uni\Favicon;

interface FaviconHandlerInterface {

  public function pageAttachments(array &$attachments, string $module_name): void;

}
