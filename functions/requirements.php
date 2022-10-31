<?php

/**
 * Implements hook_requirements().
 */
function uni_requirements(string $phase) {
  if ($phase === 'install' || $phase === 'update') {
    return [];
  }

  $requirements = [];

  $moduleExtensionList = Drupal::service('extension.list.module');
  $moduleHandler = Drupal::service('module_handler');

  $info = $moduleExtensionList->getExtensionInfo('uni');

  if (isset($info['dependencies'])) {
    foreach ($info['dependencies'] as $dependency) {
      $module = explode(':', $dependency)[1];
      if (!$moduleHandler->moduleExists($module)) {
        $requirements["uni.$module"] = [
          'title' => t('Uni Features dependency'),
          'value' => t('Not installed'),
          'description' => t(':module is required by Uni Features but it is not installed. It is recommended to install :module.', [
            ':module' => $moduleExtensionList->getName($module),
          ]),
          'severity' => REQUIREMENT_ERROR,
        ];
      }
    }
  }

  if (isset($info['conflict'])) {
    foreach ($info['conflict'] as $dependency) {
      $module = explode(':', $dependency)[1];
      if ($moduleHandler->moduleExists($module)) {
        $requirements["uni.$module"] = [
          'title' => t('Uni Features conflict'),
          'value' => t('Installed'),
          'description' => t(':module conflicts with Uni Features but it is installed. It is recommended to uninstall :module.', [
            ':module' => $moduleExtensionList->getName($module),
          ]),
          'severity' => REQUIREMENT_WARNING,
        ];
      }
    }
  }

  return $requirements;
}
