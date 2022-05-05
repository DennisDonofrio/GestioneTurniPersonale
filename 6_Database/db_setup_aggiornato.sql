DROP DATABASE IF EXISTS gestione_personale;
CREATE DATABASE gestione_personale;
USE gestione_personale;

DROP TABLE IF EXISTS amministratore;
CREATE TABLE amministratore(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    email VARCHAR(50),
    hash_password VARCHAR(80),
    indirizzo VARCHAR(50)
);

DROP TABLE IF EXISTS datore;
CREATE TABLE datore(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    email VARCHAR(50),
    hash_password VARCHAR(80),
    indirizzo VARCHAR(50),
    archiviato TINYINT(1)
);

DROP TABLE IF EXISTS dipendente;
CREATE TABLE dipendente(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    email VARCHAR(50),
    hash_password VARCHAR(80),
    indirizzo VARCHAR(50),
	datore_id INT,
    archiviato TINYINT(1),
	FOREIGN KEY (datore_id) REFERENCES datore(id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS tipo;
CREATE TABLE tipo(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(25) UNIQUE,
    descrizione TEXT
);

DROP TABLE IF EXISTS orario;
CREATE TABLE orario(
    id INT PRIMARY KEY AUTO_INCREMENT,
    inizio TIME,
    fine TIME
);

DROP TABLE IF EXISTS giorno;
CREATE TABLE giorno(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(10)
);

DROP TABLE IF EXISTS negozio;
CREATE TABLE negozio(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    indirizzo VARCHAR(50),
    archiviato TINYINT(1),
	tipo_id INT,
    datore_id INT,
    FOREIGN KEY (tipo_id) REFERENCES tipo(id)
    ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (datore_id) REFERENCES datore(id)
    ON UPDATE CASCADE ON DELETE SET NULL
);

DROP TABLE IF EXISTS orario_turno;
CREATE TABLE orario_turno(
    inizio TIME,
    fine TIME,
	negozio_id INT,
	giorno_id INT,
	FOREIGN KEY (giorno_id) REFERENCES giorno(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (negozio_id) REFERENCES negozio(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (inizio, fine, negozio_id, giorno_id)
);

DROP TABLE IF EXISTS usa;
CREATE TABLE usa(
    id INT PRIMARY KEY AUTO_INCREMENT,
    negozio_id INT,
    giorno_id INT,
    orario_id INT,
    in_uso TINYINT(1),
    FOREIGN KEY (negozio_id) REFERENCES negozio(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (giorno_id) REFERENCES giorno(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (orario_id) REFERENCES orario(id)
    ON UPDATE NO ACTION ON DELETE NO ACTION
);

DROP TABLE IF EXISTS turno_lavoro;
CREATE TABLE turno_lavoro(
    dipendente_id INT,
    negozio_id INT,
    orario_turno_inizio TIME,
    orario_turno_fine TIME,
    data DATE,
    FOREIGN KEY (dipendente_id) REFERENCES dipendente(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (negozio_id) REFERENCES negozio(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (orario_turno_inizio, orario_turno_fine) 
    REFERENCES orario_turno(inizio, fine)
    ON UPDATE NO ACTION ON DELETE NO ACTION,
    PRIMARY KEY (dipendente_id, negozio_id, orario_turno_inizio, orario_turno_fine, data)
);

DROP PROCEDURE IF EXISTS controlloDuplicati;
delimiter //
CREATE PROCEDURE controlloDuplicati()
BEGIN
	declare orarioId int;
	declare giornoId int;
    	declare negozioId int;
	declare inUso int;
	declare righe int;
	declare righeDaEliminare int;
	declare finito int default 0;
    	declare c cursor for select count(1), orario_id, giorno_id, negozio_id from usa group by orario_id, giorno_id, negozio_id;
	declare continue handler for sqlstate '02000' set finito = 1;
	open c;
	fetch c into righe, orarioId, giornoId, negozioId;
	while not finito do
		if righe > 1 then
		set righeDaEliminare = righe - 1;
		delete from usa where orario_id = orarioId and giorno_id = giornoId and negozio_id = negozioId and in_uso = 0;
		end if;
		fetch c into righe, orarioId, giornoId, negozioId;
	end while;
END;
//
delimiter ;
