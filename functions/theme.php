<?php

function uni_theme() {
  return [
    'layout__section' => [
      'template' => 'layout/layout--section/layout--section',
      'render element' => 'content',
      'base hook' => 'layout',
    ],
    'layout__section__basic' => [
      'template' => 'layout/layout--section--basic/layout--section--basic',
      'render element' => 'content',
      'base hook' => 'layout__section',
    ],
  ];
}
