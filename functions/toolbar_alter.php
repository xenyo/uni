<?php

function uni_features_toolbar_alter(&$items) {
  unset($items['coffee']);
  unset($items['devel']);
  unset($items['user']);
}