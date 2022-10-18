<?php

namespace Drupal\uni_features\Styler;

use Drupal\breakpoint\BreakpointManager;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ResponsiveStyler implements StylerInterface, ContainerInjectionInterface {

  protected $breakpointManager;

  public function __construct(
    BreakpointManager $breakpointManager,
  ) {
    $this->breakpointManager = $breakpointManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('breakpoint.manager'),
    );
  }

  public function getStyleClass(FieldableEntityInterface $entity): string {
    return 'style--' . $entity->id();
  }

  public function getStyleTags(FieldableEntityInterface $entity): array {
    $fields = $this->getFields();
    $breakpoints = $this->breakpointManager->getBreakpointsByGroup('uni_features');
    $styles = [];

    foreach (array_keys($breakpoints) as $breakpoint_id) {
      $suffix = explode('.', $breakpoint_id)[1];
      $suffix = $suffix === 'all' ? '' : "_$suffix";
      $values = [];

      foreach ($fields as $field) {
        $field_name = $field . $suffix;
        if ($entity->hasField($field_name) && !$entity->get($field_name)->isEmpty()) {
          $values[$field] = $entity->get($field_name);
        }
      }

      $style = $this->getStyles($values, $this->getStyleClass($entity));
      if (!empty($style)) {
        $styles[$breakpoint_id] = $style;
      }
    }

    $results = [];

    foreach ($styles as $breakpoint_id => $style) {
      $css = '';
      foreach ($style as $selector => $properties) {
        $css .= $this->sanitizeSelector($selector) . '{';
        foreach ($properties as $property => $value) {
          $css .= $this->sanitizeProperty($property) . ':';
          $css .= $this->sanitizeValue($value) . ';';
        }
        $css .= '}';
      }
      $result = [
        '#type' => 'html_tag',
        '#tag' => 'style',
        '#value' => $css,
      ];
      $breakpoint = $breakpoints[$breakpoint_id];
      $media = $breakpoint->getMediaQuery();
      if (!empty($media)) {
        $result['#attributes']['media'] = $media;
      }
      $results[$breakpoint->getWeight()] = $result;
    }

    return $results;
  }

  abstract protected function getFields(): array;

  abstract protected function getStyles(array $values, string $style_class): array;

  protected function sanitizeSelector($selector) {
    return trim(preg_replace('/[\{\}]/', '', $selector));
  }

  protected function sanitizeProperty($property) {
    return trim(preg_replace('/[^a-zA-Z0-9-]/', '', $property));
  }

  protected function sanitizeValue($value) {
    return trim(preg_replace('/[;\{\}]/', '', $value));
  }

}
