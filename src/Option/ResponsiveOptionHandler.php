<?php

namespace Drupal\uni_features\Option;

use Drupal\breakpoint\BreakpointManager;
use Drupal\Core\Entity\FieldableEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ResponsiveOptionHandler implements OptionHandlerInterface {

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

  public function preprocess(array &$variables, FieldableEntityInterface $entity): void {
    $style_class = 'style--' . $entity->id();
    $styles = $this->build($entity, $style_class);

    $variables['style_class'] = $style_class;
    $variables['styles'] = $styles;
  }

  abstract protected function getStyles(array $values, string $style_class): array;

  protected function build(FieldableEntityInterface $entity, string $style_class): array {
    // 1. Initialize dataset
    $breakpoints = $this->breakpointManager->getBreakpointsByGroup('uni_features');
    $dataset = [];
    foreach ($breakpoints as $breakpoint_name => $breakpoint) {
      $suffix = explode('.', $breakpoint_name)[1];
      $dataset[$suffix] = [
        'breakpoint_name' => $breakpoint_name,
        'breakpoint' => $breakpoint
      ];
    }

    // 2. Add fields
    $fields = $entity->getFields();
    $pattern = '/(.*)_(' . implode('|', array_keys($dataset)) . ')$/';
    foreach ($fields as $field_name => $field) {
      if ($field->isEmpty()) {
        continue;
      }
      if (preg_match($pattern, $field_name, $matches)) {
        $dataset[$matches[2]]['fields'][$matches[1]] = $field;
      } else {
        $dataset['all']['fields'][$field_name] = $field;
      }
    }

    // 3. Add styles
    foreach ($dataset as $suffix => $data) {
      if (!isset($data['fields'])) {
        continue;
      }
      $dataset[$suffix]['styles'] = $this->getStyles($data['fields'], $style_class);
    }

    // 4. Build style tags
    $results = [];
    foreach ($dataset as $data) {
      if (!isset($data['styles'])) {
        continue;
      }
      $css = '';
      foreach ($data['styles'] as $selector => $properties) {
        $css .= $this->sanitizeSelector($selector) . '{';
        foreach ($properties as $property => $value) {
          $css .= $this->sanitizeProperty($property) . ':';
          $css .= $this->sanitizeValue($value) . ';';
        }
        $css .= '}';
      }
      if (empty($css)) {
        continue;
      }
      $result = [
        '#type' => 'html_tag',
        '#tag' => 'style',
        '#value' => $css,
      ];
      $media = $data['breakpoint']->getMediaQuery();
      if (!empty($media)) {
        $result['#attributes']['media'] = $media;
      }
      $results[$data['breakpoint']->getWeight()] = $result;
    }

    return $results;
  }

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