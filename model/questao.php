<?php

class Questao {

    private $id = null;
    private $pergunta;
    private $multimidia;
    private $idRespostaCorreta;
    private $respostas;

    public function getId() {
        return $this->id;
    }

    public function getPergunta() {
        return $this->pergunta;
    }

    public function getMultimidia() {
        return $this->multimidia;
    }

    public function getIdRespostaCorreta() {
        return $this->idRespostaCorreta;
    }

    public function getRespostas() {
        return $this->respostas;
    }

    public static function getById($id) {
        $stmt = Database::get()->prepare('SELECT * FROM questao WHERE id = :id');
        $stmt->execute(array('id' => $id));
        if (!($row = $stmt->fetch())) {
            return null;
        }
        $questao = new Questao();
        $questao->id = intval($row['id']);
        $questao->pergunta = $row['pergunta'];
        $questao->multimidia = $row['multimidia'];
        $questao->idRespostaCorreta = intval($row['id_resposta_correta']);
        $questao->respostas = Resposta::findByQuestao($questao);
        return $questao;
    }

    public static function listIdAtivas() {
        $stmt = Database::get()->prepare('SELECT id FROM questao WHERE ativa');
        $stmt->execute();
        $list = array();
        while ($row = $stmt->fetch()) {
            array_push($list, intval($row['id']));
        }
        return $list;
    }

}
