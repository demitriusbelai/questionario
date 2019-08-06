<?php

class UsuarioQuestaoResposta {

    private $usuarioQuestao;
    private $resposta;
    private $hora = null;
    private $_exists = false;

    public function getUsuarioQuestao() {
        return $this->usuarioQuestao;
    }

    public function setUsuarioQuestao($usuarioQuestao) {
        $this->usuarioQuestao = $usuarioQuestao;
    }

    public function getResposta() {
        return $this->resposta;
    }

    public function setResposta($resposta) {
        $this->resposta = $resposta;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function save() {
        if (!$this->_exists) {
            $stmt = Database::get()->prepare('INSERT INTO usuario_questao_resposta (id_usuario_questionario, id_questao, id_resposta, hora) VALUES (:id_usuario_questionario, :id_questao, :id_resposta, :hora)');
            $stmt->execute(array(
                'id_usuario_questionario' => $this->usuarioQuestao->getUsuarioQuestionario()->getId(),
                'id_questao' => $this->usuarioQuestao->getQuestao()->getId(),
                'id_resposta' => $this->resposta->getId(),
                'hora' => $this->hora,
            ));
            $this->_exists = true;
        }
    }

}
