create schema redeSocial default charset utf8;

use redeSocial;

create table usuarios (
	id int not null primary key,
    nome varchar(100) not null,
    sobrenome varchar(100) not null,
    sexo varchar(10) not null,
    idade int not null,
    email varchar(100) not null,
    usuario varchar(40) not null,
    senha varchar(5000) not null 
);

create table amigos(
	id_pessoa int not null,
    id_amigo int not null,
    primary key(id_pessoa, id_amigo)
);

drop table amigos;

select * from usuarios;