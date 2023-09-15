<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMaps(array (
  'default' => 
  array (
    0 => '\\Traveler\\Infrastructure\\Models\\City\\Map\\CityTableMap',
    1 => '\\Traveler\\Infrastructure\\Models\\Sight\\Map\\SightTableMap',
    2 => '\\Traveler\\Infrastructure\\Models\\Traveler\\Map\\TravelerTableMap',
    3 => '\\Traveler\\Infrastructure\\Models\\TravelersCitiesRel\\Map\\TravelersCitiesRelTableMap',
  ),
));
