<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Otto\Challenge();
$content = null;

$requestParam = (isset($_GET['fetch']) ? $_GET['fetch'] : 'records');
$id = (isset($_GET['id']) ? $_GET['id'] : '');

echo json_encode($app->fetchRecordsAsParam([$requestParam, $id]));
?>