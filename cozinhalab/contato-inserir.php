<?php

header("Content-Type: application/json; charset=utf-8");

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if ($nome == '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mensagem == '') {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha os campos corretamente.']);
    exit;
}

include "banco.php";

$sql = "insert into contato (nome, email, mensagem) values (:nome, :email, :mensagem)";

$qry = $conexao->prepare($sql);

$qry->bindParam(':nome', $nome);
$qry->bindParam(':email', $email);
$qry->bindParam(':mensagem', $mensagem);

$qry->execute();

echo json_encode(['sucesso' => true, 'mensagem' => 'Mensagem enviada com sucesso! Obrigado pelo contato.']);