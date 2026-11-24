<?php

header("Content-Type: application/json; charset=utf-8");
include "banco.php";

$sql = "select * from blog_post order by data_publicacao desc, id desc";

$qry = $conexao->prepare($sql);
$qry->execute();

$registros = $qry->fetchAll(PDO::FETCH_OBJ);

echo json_encode($registros);