<?php

require_once __DIR__ . '/../vendor/autoload.php';

$orm = 'doctrine';

switch ($orm) {
    case 'doctrine':
        require_once __DIR__ . '/src/Bootstrap/Doctrine.php';
        require_once __DIR__ . '/src/Models/DoctrineModel.php';

        $entity  = 'Rougin\Datatables\Example\Models\DoctrineModel';
        $builder = new Rougin\Datatables\DoctrineBuilder($entity, $entityManager, $_GET);

        break;
    case 'eloquent':
        require_once __DIR__ . '/src/Bootstrap/Eloquent.php';
        require_once __DIR__ . '/src/Models/EloquentModel.php';

        $model   = 'Rougin\Datatables\Example\Models\EloquentModel';
        $builder = new Rougin\Datatables\EloquentBuilder($model, $_GET);

        break;
}

header('Content-Type: application/json');

echo json_encode($builder->make());
