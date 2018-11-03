<?php
require ('../../../core/init.php');
$table_Name = 'site s';
$fiels = '*';
//$fields = '*';
$join = NULL;
$where = '';
$order = 's.INSERT_DATETIME DESC';

$stmt = $dbCRUD->selectAll($table_Name, $fiels, $join, $where, $order, "");
$row = $stmt->fetchAll();

echo json_encode($row);
?>

