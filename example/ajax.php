<?php

use Rougin\Datatables\DoctrineBuilder;
use Rougin\Datatables\EloquentBuilder;
use Rougin\Datatables\Test\User\DoctrineModel;
use Rougin\Datatables\Test\User\EloquentModel;

require_once __DIR__ . '/../vendor/autoload.php';

// Choose "doctrine" or "eloquent"
$orm = 'doctrine';

switch ($orm) {
    case 'doctrine':
        require_once __DIR__ . '/src/Bootstrap/Doctrine.php';
        require_once __DIR__ . '/src/Models/DoctrineModel.php';

        $entity  = DoctrineModel::class;
        $builder = new DoctrineBuilder($entity, $entityManager, $_GET);

        break;
    case 'eloquent':
        require_once __DIR__ . '/src/Bootstrap/Eloquent.php';
        require_once __DIR__ . '/src/Models/EloquentModel.php';

        $model   = EloquentModel::class;
        $builder = new EloquentBuilder($model, $_GET);

        break;
}

header('Content-Type: application/json');

echo json_encode($builder->make());