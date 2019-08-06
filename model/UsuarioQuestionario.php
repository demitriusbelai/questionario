<?php

class UsuarioQuestionario {

    private $id = null;
    private $usuario;
    private $horaInicio = null;
    private $horaTermino = null;

    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
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
        if ($this->id == null) {
            $stmt = Database::get()->prepare('INSERT INTO usuario_questionario (usuario, hora_inicio, hora_termino) VALUES (:usuario, :hora_inicio, :hora_termino)');
            $stmt->execute(array('usuario' => $this->usuario, 'hora_inicio' => $this->horaInicio, 'hora_termino' => $this->horaTermino));
            $this->id = Database::get()->lastInsertId();
        } else {
            $stmt = Database::get()->prepare('UPDATE usuario_questionario SET usuario = :usuario, hora_inicio = :hora_inicio, hora_termino = :hora_termino WHERE id = :id');
            $stmt->execute(array('id' => $this->id, 'usuario' => $this->usuario, 'hora_inicio' => $this->horaInicio, 'hora_termino' => $this->horaTermino));
        }
    }

}
