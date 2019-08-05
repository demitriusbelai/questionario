<?php

class Resposta {

    private $id = null;
    private $questao;
    private $resposta;
    private $ordem;

    public function getId() {
        return $this->id;
    }

    public function getQuestao() {
        return $this->questao;
    }

    public function getResposta() {
        return $this->resposta;
    }

    public function getOrdem() {
        return $this->ordem;
    }

    public function isCorreta() {
        return $this->id === $this->questao->getIdRespostaCorreta();
    }

    public static function findByQuestao($questao) {
        $stmt = Database::get()->prepare('SELECT * FROM resposta WHERE id_questao = :id');
        $stmt->execute(array('id' => $questao->getId()));
        $list = array();
        while ($row = $stmt->fetch()) {
            $resposta = Resposta::new($row);
            $resposta->questao = $questao;
            $list[] = $resposta;
        }
        return $list;
    }

    public static function getById($id) {
        $stmt = Database::get()->prepare('SELECT * FROM resposta WHERE id = :id');
        $stmt->execute(array('id' => $id));
        $list = array();
        if (!($row = $stmt->fetch())) {
            return null;
        }
        $resposta = Resposta::new($row);
        $resposta->questao = Questao::getById($row['id_questao']);
        return $resposta;
    }

    private static function new($row) {
        $resposta = new Resposta();
        $resposta->id = intval($row['id']);
        $resposta->resposta = $row['resposta'];
        $resposta->ordem = intval($row['ordem']);
        return $resposta;
    }

}
