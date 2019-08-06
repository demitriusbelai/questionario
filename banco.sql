CREATE TABLE questao (
    id INTEGER NOT NULL AUTO_INCREMENT,
    pergunta TEXT NOT NULL,
    multimidia TEXT NOT NULL,
    id_resposta_correta INTEGER,
    ativa BOOLEAN NOT NULL DEFAULT false,
    PRIMARY KEY (id)
);

CREATE TABLE resposta (
    id INTEGER NOT NULL AUTO_INCREMENT,
    id_questao INTEGER NOT NULL,
    resposta TEXT NOT NULL,
    ordem INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_questao) REFERENCES questao(id)
);

ALTER TABLE questao ADD FOREIGN KEY (id_resposta_correta) REFERENCES resposta(id);

CREATE TABLE usuario_questionario (
    id INTEGER NOT NULL AUTO_INCREMENT,
    usuario TEXT NOT NULL,
    hora_inicio DATETIME NOT NULL,
    hora_termino DATETIME,
    PRIMARY KEY (id)
);

CREATE TABLE usuario_questao (
    id_usuario_questionario INTEGER NOT NULL,
    id_questao INTEGER NOT NULL,
    hora_inicio DATETIME NOT NULL,
    hora_termino DATETIME,
    PRIMARY KEY (id_usuario_questionario, id_questao),
    FOREIGN KEY (id_usuario_questionario) REFERENCES usuario_questionario(id),
    FOREIGN KEY (id_questao) REFERENCES questao(id)
);

CREATE TABLE usuario_questao_resposta (
    id_usuario_questionario INTEGER NOT NULL,
    id_questao INTEGER NOT NULL,
    id_resposta INTEGER NOT NULL,
    hora DATETIME NOT NULL,
    PRIMARY KEY (id_usuario_questionario, id_questao, id_resposta),
    FOREIGN KEY (id_usuario_questionario) REFERENCES usuario_questionario(id),
    FOREIGN KEY (id_questao) REFERENCES questao(id),
    FOREIGN KEY (id_resposta) REFERENCES resposta(id)
);
