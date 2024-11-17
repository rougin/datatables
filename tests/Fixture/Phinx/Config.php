<?php

$paths = array();

$path = '%%PHINX_CONFIG_DIR%%/Scripts';
$paths['migrations'] = $path;

$path = '%%PHINX_CONFIG_DIR%%/Seeders';
$paths['seeds'] = $path;

$envs = array();
$envs['default_migration_table'] = 'phinxlog';
$envs['default_environment'] = 'development';

$devt = array('suffix' => 's3db');
$devt['adapter'] = 'sqlite';
$devt['name'] = __DIR__ . '/../Storage/dtbl';
$envs['development'] = $devt;

$config = array('paths' => $paths);
$config['environments'] = $envs;
$config['version_order'] = 'creation';

return $config;
