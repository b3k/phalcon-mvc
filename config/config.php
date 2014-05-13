<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setDefaultDatasource('default');
$serviceContainer->setProfilerClass('\Runtime\Runtime\Util\Profiler');
$serviceContainer->setProfilerConfiguration(array (
  'slowTreshold' => '0.2',
  'details' =>
  array (
    'time' =>
    array (
      'name' => 'Time',
      'precision' => '3',
      'pad' => '8',
    ),
    'mem' =>
    array (
      'name' => 'Memory',
      'precision' => '3',
      'pad' => '8',
    ),
  ),
  'innerGlue' => ': ',
  'outerGlue' => ' | ',
));

return $serviceContainer;