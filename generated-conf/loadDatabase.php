<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMaps(array (
  'default' => 
  array (
    0 => '\\App\\Services\\PostService\\Persistence\\Propel\\Map\\CommentTableMap',
    1 => '\\App\\Services\\PostService\\Persistence\\Propel\\Map\\PostTableMap',
    2 => '\\App\\Services\\PostService\\Persistence\\Propel\\Map\\PostTagTableMap',
    3 => '\\App\\Services\\PostService\\Persistence\\Propel\\Map\\TagTableMap',
  ),
));
