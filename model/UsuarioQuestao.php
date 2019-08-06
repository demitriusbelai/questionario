<?php

class UsuarioQuestao {

    private $usuarioQuestionario;
    private $questao;
    private $horaInicio = null;
    private $horaTermino = null;
    private $_exists = false;

    public function getUsuarioQuestionario() {
        return $this->usuarioQuestionario;
    }

    public function setUsuarioQuestionario($usuarioQuestionario) {
        $this->usuarioQuestionario = $usuarioQuestionario;
    }

    public function getQuestao() {
        return $this->questao;
    }

    public function setQuestao($questao) {
        $this->questao = $questao;
    }

    public function getHoraInicio() {
        return $this->horaInicio;
    }

    public function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    public function getHoraTermino() {
        return $this->horaTermino;
    }

    public function setHoraTermino($horaTermino) {
        $this->horaTermino = $horaTermino;
    }

    public function save() {
        if (!$this->_exists) {
            $stmt = Database::get()->prepare('INSERT INTO usuario_questao (id_usuario_questionario, id_questao, hora_inicio, hora_termino) VALUES (:id_usuario_questionario, :id_questao, :hora_inicio, :hora_termino)');
        } else {
            $stmt = Database::get()->prepare('UPDATE usuario_questao SET hora_inicio = :hora_inicio, hora_termino = :hora_termino WHERE id_usuario_questionario = :id_usuario_questionario AND id_questao = :id_questao');
        }
        $stmt->execute(array(
            'id_usuario_questionario' => $this->usuarioQuestionario->getId(),
            'id_questao' => $this->questao->getId(),
            'hora_inicio' => $this->horaInicio,
            'hora_termino' => $this->horaTermino,
        ));
        $this->_exists = true;
    }

}
