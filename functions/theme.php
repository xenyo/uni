<?php

function uni_theme() {
  return [
    'layout__uni_section' => [
      'template' => 'layout/layout--uni-section/layout--uni-section',
      'render element' => 'content',
      'base hook' => 'layout',
    ],
  ];
}
