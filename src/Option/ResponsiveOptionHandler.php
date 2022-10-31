<?php

namespace Drupal\uni\Option;

use Drupal\breakpoint\BreakpointManager;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Render\Markup;
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

  abstract protected function style(array &$dataset, string $style_class): void;

  protected function build(FieldableEntityInterface $entity, string $style_class): array {
    // 1. Initialize dataset
    $breakpoints = $this->breakpointManager->getBreakpointsByGroup('uni');
    $dataset = [];
    foreach ($breakpoints as $breakpoint_id => $breakpoint) {
      $breakpoint_name = explode('.', $breakpoint_id)[1];
      $dataset[$breakpoint_name] = [
        'breakpoint' => $breakpoint,
        'breakpoint_id' => $breakpoint_id,
        'suffix' => $breakpoint->getMediaQuery() === '' ? '' : "_$breakpoint_name",
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
    $this->style($dataset, $style_class);

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
        '#value' => Markup::create($css),
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
    return strip_tags(trim(preg_replace('/[\{\}]/', '', $selector)));
  }

  protected function sanitizeProperty($property) {
    return strip_tags(trim(preg_replace('/[^a-zA-Z0-9-]/', '', $property)));
  }

  protected function sanitizeValue($value) {
    return strip_tags(trim(preg_replace('/[;\{\}]/', '', $value)));
  }

}
