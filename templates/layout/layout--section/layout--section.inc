<?php

// Add region classes
foreach ($variables['region_attributes'] as $region => $attributes) {
  $attributes->addClass('region', 'region--' . $region);
}
