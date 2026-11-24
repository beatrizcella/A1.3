<?php

header("Content-Type: application/json; charset=utf-8");

$servico = trim($_POST['servico'] ?? '');
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$uf = strtoupper(trim($_POST['uf'] ?? ''));
$data_desejada = trim($_POST['data_desejada'] ?? '');
$observacoes = trim($_POST['observacoes'] ?? '');

$servicos = ['Cozinha Salgada', 'Confeitaria e Doces', 'Aulas com Chefs'];

if (!in_array($servico, $servicos) || $nome == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || $telefone == '' || $endereco == '' || $cidade == '' || strlen($uf) != 2 || $data_desejada == '') {

    echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha os campos corretamente.']);
    exit;
}

include "banco.php";

$sql = "insert into orcamento (servico, nome, email, telefone, endereco, cidade, uf, data_desejada, observacoes)
        values (:servico, :nome, :email, :telefone, :endereco, :cidade, :uf, :data_desejada, :observacoes)";

$qry = $conexao->prepare($sql);

$qry->bindParam(':servico', $servico);
$qry->bindParam(':nome', $nome);
$qry->bindParam(':email', $email);
$qry->bindParam(':telefone', $telefone);
$qry->bindParam(':endereco', $endereco);
$qry->bindParam(':cidade', $cidade);
$qry->bindParam(':uf', $uf);
$qry->bindParam(':data_desejada', $data_desejada);
$qry->bindParam(':observacoes', $observacoes);

$qry->execute();

echo json_encode(['sucesso' => true, 'mensagem' => 'Orçamento registrado com sucesso! Entraremos em contato em breve.']);