/*+++++++++++++++CREAR LAS BASES DE DATOS++++++++++++++++++++++++++++*/
create database vigila_tu_yayo_bd
default character set utf8
collate utf8_unicode_ci;

/*++++++++++++++++CREAR AL USUARIO ADMINISTRADOR DE LA BD++++++++++++++++++++++++*/
create user uapi@'localhost'
identified by 'capi';

grant all           --Se le da acceso
on vigila_tu_yayo_bd.* to        --A esta base de datos
uapi@localhost;    --A este usuaio

flush privileges;

use vigila_tu_yayo_bd;

/*+++++++++++++++++CREAR TABLAS+++++++++++++++++++++++*/
create table if not exists usuarios (
    id bigint not null auto_increment primary key,
    nick varchar(20) not null unique,
    password varchar(250) not null,
    rol ENUM('RES', 'FAM', 'ACO') not null,
    correo varchar(40) not null unique,
    fecha_alta timestamp default current_timestamp on update current_timestamp not null
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists familiar (
    id bigint not null auto_increment primary key,
    id_usuario bigint not null unique,
    nombre varchar(40) not null,
    apellidos varchar(250) not null,
    dni varchar(9) not null unique,
    direccion varchar(50),
    cp varchar(5),
    telefono varchar(9),
    foreign key (id_usuario) references usuarios (id) on delete cascade
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists residencia (
    id bigint not null auto_increment primary key,
    id_usuario bigint not null unique,
    nombre varchar(50) not null,
    direccion varchar(50) not null,
    cp varchar(5),
    telefono varchar(9),
    foreign key (id_usuario) references usuarios (id) on delete cascade
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists acompaniante (
    id bigint not null auto_increment primary key,
    id_usuario bigint not null unique,
    nombre varchar(50) not null,
    apellidos varchar(50),
    dni varchar(9) not null unique,
    direccion varchar(50) not null,
    cp varchar(5),
    telefono varchar(9),
    foreign key (id_usuario) references usuarios (id) on delete cascade
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists centro_medico (
    id bigint not null auto_increment primary key,
    nombre varchar(50) not null,
    direccion varchar(50) not null,
    telefono varchar(9)
)engine=innodb default character set = utf8 collate utf8_unicode_ci;



/*+++++++++++++++++TABLAS CON FK+++++++++++++++++++++++*/



create table if not exists residencia_fam (
    id bigint not null auto_increment primary key,
    id_familiar bigint not null,
    id_residencia bigint not null,
    fecha_alta timestamp default current_timestamp on update current_timestamp not null,
    foreign key (id_familiar) references familiar (id) on delete cascade,
    foreign key (id_residencia) references residencia (id) on delete cascade,
    unique (id_familiar, id_residencia)
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists residente (
    id bigint not null auto_increment primary key,
    id_residencia bigint not null,
    id_centro_medico bigint,
    nombre varchar(40) not null,
    apellidos varchar(250) not null,
    dni varchar(9) not null unique,
    fecha_alta timestamp default current_timestamp on update current_timestamp not null,
    foreign key (id_residencia) references residencia (id) on delete cascade,
    foreign key (id_centro_medico) references centro_medico (id) on delete set null,
    unique (dni)
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists cita (
    id bigint not null auto_increment primary key,
    id_residente bigint not null,
    fecha timestamp,
    motivo varchar(100),
    tipo ENUM ('PREVIA','URGENCIA') default 'PREVIA' not null,
    fam_disponible Boolean default 0 not null,
    descripcion text,
    foreign key (id_residente) references residente (id) on delete cascade
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists residente_fam (
    id bigint not null auto_increment primary key,
    id_familiar bigint not null,
    id_residente bigint not null,
    foreign key (id_familiar) references familiar (id) on delete cascade,
    foreign key (id_residente) references residente (id) on delete cascade,
    unique (id_familiar, id_residente)
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists viaje (
    id bigint not null auto_increment primary key,
    id_cita bigint unique not null,
    id_acompaniante bigint not null,
    h_salida varchar(5),
    h_llegada varchar(5),
    estado ENUM ('PENDIENTE', 'INICIADO', 'TERMINADO') not null,
    foreign key (id_cita) references cita (id) on delete set null,
    foreign key (id_acompaniante) references acompaniante (id) on delete set null,
    unique(id_cita, id_acompaniante)
)engine=innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists residencia_aco (
    id bigint not null auto_increment primary key,
    id_residencia bigint not null,
    id_acompaniante bigint not null,
    fecha_alta timestamp default current_timestamp on update current_timestamp not null,
    foreign key (id_residencia) references residencia (id) on delete cascade,
    foreign key (id_acompañante) references acompaniante (id) on delete cascade,
    unique(id_residencia, id_acompaniante)
)engine=innodb default character set = utf8 collate utf8_unicode_ci;




/*+++++++++++++++++INSERTS+++++++++++++++++++++++*/

INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u1', 'u1', 'RES', 'u1@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u2', 'u2', 'RES', 'u2@r.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u3', 'u3', 'RES', 'u3@r.com');

INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u4', 'u4', 'FAM', 'u4@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u5', 'u5', 'FAM', 'u5@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u6', 'u6', 'FAM', 'u6@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u7', 'u7', 'FAM', 'u7@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u8', 'u8', 'FAM', 'u8@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u9', 'u9', 'FAM', 'u9@u.com');

INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u10', 'u10', 'ACO', 'u10@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u11', 'u11', 'ACO', 'u11@u.com');
INSERT INTO `usuarios`(`nick`, `password`, `rol`, `correo`) VALUES ('u12', 'u12', 'ACO', 'u12@u.com');


insert into residencia (id_usuario, nombre, direccion, cp, telefono) values ('1','residencia1', ' calle1', '00001', '000000001');
insert into residencia (id_usuario, nombre, direccion, cp, telefono) values ('2','residencia2', ' calle2', '00002', '000000002');
insert into residencia (id_usuario, nombre, direccion, cp, telefono) values ('3','residencia3', ' calle3', '00003', '000000003');


insert into familiar (id_usuario, nombre, apellidos, dni, direccion, cp, telefono) values ('4', 'nombreF1', 'apellidosF2', '52345678f', 'calleF1', '00005', '0123456789');
insert into familiar (id_usuario, nombre, apellidos, dni, direccion, cp, telefono) values ('5', 'nombreF1', 'apellidosF2', '62345678f', 'calleF1', '00005', '0123456788');
insert into familiar (id_usuario, nombre, apellidos, dni, direccion, cp, telefono) values ('6', 'nombreF1', 'apellidosF2', '72345678f', 'calleF1', '00005', '0123456787');
insert into familiar (id_usuario, nombre, apellidos, dni, direccion, cp, telefono) values ('7', 'nombreF1', 'apellidosF2', '82345678f', 'calleF1', '00005', '0123456786');
insert into familiar (id_usuario, nombre, apellidos, dni, direccion, cp, telefono) values ('8', 'nombreF1', 'apellidosF2', '92345678f', 'calleF1', '00005', '0123456785');
insert into familiar (id_usuario, nombre, apellidos, dni, direccion, cp, telefono) values ('9', 'nombreF1', 'apellidosF2', '10345678f', 'calleF1', '00005', '0123456784');


insert into residencia_fam (id_familiar, id_residencia) values (4, 1);
insert into residencia_fam (id_familiar, id_residencia) values (5, 2);
insert into residencia_fam (id_familiar, id_residencia) values (6, 3);
insert into residencia_fam (id_familiar, id_residencia) values (1, 1);
insert into residencia_fam (id_familiar, id_residencia) values (2, 2);
insert into residencia_fam (id_familiar, id_residencia) values (3, 3);
insert into residencia_fam (id_familiar, id_residencia) values (4, 3);
insert into residencia_fam (id_familiar, id_residencia) values (5, 1);


insert into centro_medico (nombre, direccion, telefono) values ('Hospital La Inmaculada', ' C/ Alejandro Otero, 8, Granada', '958187700');
insert into centro_medico (nombre, direccion, telefono) values ('Hospital Universitario San Cecilio', ' Calle Dr. Oloriz, 16, Granada', '958023000');
insert into centro_medico (nombre, direccion, telefono) values ('Centro Salud Las Flores', 'Calle Profesor García Gómez, 8, Granada', '958544330');
insert into centro_medico (nombre, direccion, telefono) values ('Gran Capitán Centro de Salud', 'Calle Gran Capitán, 10, Granada', '958022600');
insert into centro_medico (nombre, direccion, telefono) values ('Centro de Salud Zaidín Centro Este', 'Av. de América, 14, Granada', '958897728');


insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('1', '5', 'Francisco', 'García', '02136584V');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('2', '4', 'Alejandro', 'López Gómez', '54216783G');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('3', '3', 'Bartolomé', 'Asensio Martín', '78245913D');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('1', '2', 'Jose Luis', 'Perales', '86214537F');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('2', '1', 'Tomás', 'Turbante', '94573861G');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('3', '5', 'Rubén', 'Pelo Fijado', '78126549F');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('1', '4', 'Jorge', 'Puigdemon', '84265971D');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('2', '3', 'Guadalupe', 'Molina', '248651379J');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('3', '2', 'María', 'Galletas', '95175364G');
insert into residente (id_residencia, id_centro_medico, nombre, apellidos, dni) values ('1', '1', 'Carmen', 'Exojo', '75395148O');



-- ver constraints de una tabla, para sacar nombre
select COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME
from information_schema.KEY_COLUMN_USAGE
where TABLE_NAME = 'table to be checked';

-- para cambiar una contraint primero hay que eliminarla
ALTER TABLE `UserDetails` DROP FOREIGN KEY `FK_User_id`;

-- luego hay que volverla a crear
ALTER TABLE `UserDetails` ADD CONSTRAINT `FK_User_id` 
FOREIGN KEY (`User_id`) REFERENCES `Users` (`User_id`) ON DELETE CASCADE;