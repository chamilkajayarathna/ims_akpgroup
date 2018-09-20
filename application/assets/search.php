<?php
require ('../../core/init.php');
$arr = array();
if (!empty($_POST['keywords'])) {
    $keywords = filter_input(INPUT_POST, 'keywords');
    
    //Table Infomation
    $table_Name = filter_input(INPUT_POST, 'table_Name');
    $fields = filter_input(INPUT_POST, 'fields');
    $join = filter_input(INPUT_POST, 'join');
    $where = filter_input(INPUT_POST, 'where');
    $orderBy = filter_input(INPUT_POST, 'orderBy');
    
    $stmt = $dbCRUD->selectAll($table_Name, $fields, $join, $where, $orderBy, NULL);
    $num = $stmt->rowCount();
    if ($num > 0) {
        while ($obj = $stmt->fetchObject()) {
            $arr[] = $obj;
        }
    }
}
echo json_encode($arr);