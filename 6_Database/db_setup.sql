drop database if exists gestione_personale;
create database gestione_personale;
use gestione_personale;

drop table if exists datore;
create table datore(
	id int primary key auto_increment,
    nome varchar(50),
    cognome varchar(50),
    email varchar(50),
    hash_password varchar(80),
    indirizzo varchar(50),
    archiviato tinyint(1)
);

drop table if exists tipo;
create table tipo(
	id int primary key auto_increment,
    nome varchar(25),
    descrizione text
);

drop table if exists amministratore;
create table amministratore(
	id int primary key auto_increment,
    nome varchar(50),
    cognome varchar(50),
    email varchar(50),
    hash_password varchar(80),
    indirizzo varchar(50)
);

drop table if exists dipendente;
create table dipendente(
	id int primary key auto_increment,
    nome varchar(50),
    cognome varchar(50),
    email varchar(50),
    hash_password varchar(80),
    indirizzo varchar(50),
    archiviato tinyint(1)
);

drop table if exists negozio;
create table negozio(
	id int primary key auto_increment,
    nome varchar(50),
    indirizzo varchar(50),
    archiviato tinyint(1),
	tipo_id int,
    datore_id int,
    foreign key (tipo_id) references tipo(id) 
    on update cascade on delete set null,
    foreign key (datore_id) references datore(id) 
    on update cascade on delete set null
);

drop table if exists orario;
create table orario(
	negozio_id int,
    inizio time,
    fine time,
	foreign key (negozio_id) references negozio(id),
    primary key (negozio_id, inizio, fine)
);

drop table if exists turno;
create table turno(
	id int primary key auto_increment,
    data_inizio timestamp,
    data_fine timestamp,
    negozio_id int,
    dipendente_id int,
    foreign key (negozio_id) references negozio(id),
    foreign key (dipendente_id) references dipendente(id) 
);