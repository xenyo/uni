<?php

namespace Drupal\uni;

use Drupal\Core\Extension\ModuleExtensionList;

/**
 * Implements the favicon handler interface.
 *
 * @package Drupal\uni
 */
class FaviconHandler implements FaviconHandlerInterface {

  /**
   * The module extension list.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $moduleExtensionList;

  /**
   * Creates a new favicon handler object.
   *
   * @param \Drupal\Core\Extension\ModuleExtensionList $moduleExtensionList
   */
  public function __construct(
    ModuleExtensionList $moduleExtensionList,
  ) {
    $this->moduleExtensionList = $moduleExtensionList;
  }

  /**
   * {@inheritdoc}
   */
  public function pageAttachments(array &$attachments, string $module): void {
    $base_path = \Drupal::request()->getBasePath();
    $module_path = $this->moduleExtensionList->getPath($module);

    $attachments['#attached']['html_head'][] = [
      [
        '#tag' => 'link',
        '#attributes' => [
          'rel' => 'icon',
          'href' => "$base_path/$module_path/favicon.ico",
          'type' => 'image/vnd.microsoft.icon',
        ],
      ],
      "$module.icon",
    ];
  }

}
