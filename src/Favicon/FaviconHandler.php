<?php

namespace Drupal\uni\Favicon;

use Drupal\Core\Extension\ModuleExtensionList;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FaviconHandler implements FaviconHandlerInterface {

  protected $moduleExtensionList;

  public function __construct(
    ModuleExtensionList $moduleExtensionList,
  ) {
    $this->moduleExtensionList = $moduleExtensionList;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extension.list.module'),
    );
  }

  public function pageAttachments(array &$attachments, string $module_name): void {
    $base_path = \Drupal::request()->getBasePath();
    $module_path = $this->moduleExtensionList->getPath($module_name);

    $attachments['#attached']['html_head'][] = [
      [
        '#tag' => 'link',
        '#attributes' => [
          'rel' => 'icon',
          'href' => "$base_path/$module_path/favicon.ico",
          'type' => 'image/vnd.microsoft.icon',
        ],
      ],
      "$module_name.icon",
    ];  
  }

}
