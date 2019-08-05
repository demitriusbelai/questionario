<?php

require_once('bootstrap.php');

if (!isset($_POST['id'])) {
    http_response_code(400);
    exit;
}

if (!isset($_SESSION['questoes']) || !isset($_SESSION['atual'])) {
    http_response_code(409);
    exit;
}

if (!isset($_SESSION['respostas'])) {
    http_response_code(500);
    exit;
}

$id_resposta = intval($_POST['id']);

$id_questao = $_SESSION['questoes'][$_SESSION['atual']];
$questao = Questao::getById($id_questao);

$resposta = null;

foreach ($questao->getRespostas() as $r) {
    if ($r->getId() == $id_resposta) {
        $resposta = $r;
        break;
    }
}

if ($resposta == null) {
    http_response_code(409);
    exit;
}

$correta = $resposta->getQuestao()->getIdRespostaCorreta();

if ($correta == null) {
    http_response_code(500);
    exit;
}

//TODO: Salvar usuario_questao_resposta

$_SESSION['respostas'][] = $id_resposta;

$data = [
    'respostas' => $_SESSION['respostas'],
    'acertou' => $resposta->isCorreta(),
];

if (count($_SESSION['respostas']) > 2 || $data['acertou']) {
    $data['correta'] = $correta;
    $_SESSION['atual']++;
    $_SESSION['respostas'] = [];
    $_SESSION['resultado'][] = $data['acertou'];
}

header('Content-type: application/json');
echo json_encode($data);
