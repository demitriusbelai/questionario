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
    $usuarioQuestionario = new UsuarioQuestionario();
    $usuarioQuestionario->setUsuario('anonymous');
    $usuarioQuestionario->setHoraInicio(date('Y-m-d H:i:s'));
    $usuarioQuestionario->save();
    $_SESSION['usuarioQuestionario'] = $usuarioQuestionario;
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
    $usuarioQuestionario = $_SESSION['usuarioQuestionario'];
    $usuarioQuestionario->setHoraTermino(date('Y-m-d H:i:s'));
    $usuarioQuestionario->save();
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

$usuarioQuestionario = $_SESSION['usuarioQuestionario'];
$usuarioQuestao = new UsuarioQuestao();
$usuarioQuestao->setUsuarioQuestionario($usuarioQuestionario);
$usuarioQuestao->setQuestao($questao);
$usuarioQuestao->setHoraInicio(date('Y-m-d H:i:s'));
$usuarioQuestao->save();
$_SESSION['usuarioQuestao'] = $usuarioQuestao;

header('Content-type: application/json');
echo json_encode($data);
