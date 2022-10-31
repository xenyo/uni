<?php

namespace Drupal\uni\Favicon;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;

interface FaviconHandlerInterface extends ContainerInjectionInterface {

  public function pageAttachments(array &$attachments, string $module_name): void;

}
