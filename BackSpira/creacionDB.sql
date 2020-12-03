create database spira;

use spira;

create table `typeUser`(
	`id` int(11) AUTO_INCREMENT NOT NULL,
    `description` varchar(50) NOT NULL,
    primary key (`id`)
);

insert into typeUser(description)
values ('teacher'),
('student');

create table `user`(
	`id` int(11) AUTO_INCREMENT NOT NULL,
    `name` varchar(150) NOT NULL,
    `mail` varchar(50) NOT NULL,
    `password` varchar(150) NOT NULL,
    `tel` varchar(50) NOT NULL,
    `id_type` int(2) NOT NULL,
    primary key (`id`),
    FOREIGN KEY (`id_type`) REFERENCES typeUser(id)
);

create table `class`(
	`id` int(11) AUTO_INCREMENT NOT NULL,
    `name` varchar(150) NOT NULL,
    primary key (`id`)
);

create table `classByUser`(
	`id` int(11) AUTO_INCREMENT NOT NULL,
    `id_user` int(11) NOT NULL,
    `id_class` int(11) NOT NULL,
    primary key (`id`),
    FOREIGN KEY (`id_user`) REFERENCES user(id),
    FOREIGN KEY (`id_class`) REFERENCES class(id)
);

alter table `class`
add column `intensity` int(5);

