<?php

require_once('bootstrap.php');

// Novo questionario
if (!isset($_SESSION['questoes'])) {
    $questoes = Questao::listIdAtivas();
    srand((float)microtime()*1000000);
    shuffle($questoes);
    $questoes = array_slice($questoes, 0, 20);
    $_SESSION['questoes'] = $questoes;
    $_SESSION['atual'] = 0;
    $_SESSION['respostas'] = [];
    //TODO: Salvar usuario_questionario
}

if ($_SESSION['atual'] >= count($_SESSION['questoes'])) {
    $total = count($_SESSION['questoes']);
    $acertos = count(array_filter($_SESSION['resultado']));
    unset($_SESSION['atual']);
    unset($_SESSION['questoes']);
    unset($_SESSION['resultado']);
    $data = [
        'acertos' => $acertos,
        'total' => $total,
    ];
    header('Content-type: application/json');
    echo json_encode($data);
    exit;
}

$id = $_SESSION['questoes'][$_SESSION['atual']];
$questao = Questao::getById($id);

$data = [
    'id' => $questao->getId(),
    'pergunta' => $questao->getPergunta(),
    'multimidia' => $questao->getMultimidia(),
    'respostas' => [],
    'respostasDadas' => $_SESSION['respostas'],
    'atual' => $_SESSION['atual'] + 1,
    'numTotal' => count($_SESSION['questoes'])
];

foreach ($questao->getRespostas() as $resposta) {
    $data['respostas'][] = [
        'id' => $resposta->getId(),
        'resposta' => $resposta->getResposta(),
    ];
}

//TODO: Salvar usuario_questao

header('Content-type: application/json');
echo json_encode($data);
