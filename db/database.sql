///BASE DE DATOS, USUARIOS Y PERMISOS
create database sseguridad;
use sseguridad;
create user `mikel`@`%`identified by 'mikel';
GRANT SELECT, INSERT, UPDATE,DELETE ON `sseguridad`.* TO `mikel`@`%`;

///TABLAS Y DATOS///


CREATE TABLE roles (
                          id_rol int(3) NOT NULL primary key AUTO_INCREMENT,
                          nombre varchar(25) NOT NULL unique ,
                          permisos varchar(50)
);
INSERT INTO roles (id_rol,nombre, permisos) VALUES
                                            (1,'Admin', 'Rol con permisos totales en el sistema'),
                                            (2,'Normal', 'Rol con permisos limitados en el sistema'),
                                            (3,'Deshabilitado', 'Rol que no tiene acceso al sistema');

CREATE TABLE placas(
     id_placa int(4) primary key AUTO_INCREMENT,
     nombre varchar(20) NOT NULL unique,
     descripcion varchar(50),
     est int(1) not null
);
ALTER TABLE placas
    ADD COLUMN ufecha datetime;

INSERT INTO placas (id_placa,nombre,descripcion,est) VALUES
                                         (1,'ESP-32-S3','Placa ESP32-S3',1),
                                         (2,'ESP-32-CAM','Plca ESP-32-CAM',1);

CREATE TABLE sensores(
                         id_sensor int(4) primary key AUTO_INCREMENT,
                         nombre varchar(20) NOT NULL unique,
                         descripcion varchar(50),
                         id_placa int(4) not null ,
                         est int(1) not null,
                         FOREIGN KEY (id_placa) REFERENCES placas(id_placa)
);

INSERT INTO sensores (id_sensor,nombre,id_placa,est) VALUES
                                            (1,'PIR',1,1),
                                            (2,'Ultrasonico',1,1),
                                            (3,'Microfono',1,1),
                                            (4,'Camara ESP-32-CAM',2,1);


CREATE TABLE estados(
                        id_estado int(3) primary key AUTO_INCREMENT,
                        nombre varchar(25) not null
);
INSERT INTO estados (id_estado,nombre) VALUES
                                                     (1,'Desactivado'),
                                                        (2,'Alerta'),
                                                     (3,'Peligro');
CREATE TABLE eventos(
                        id_evento int(8) primary key AUTO_INCREMENT,
                        fecha datetime,
                        id_sensor int(4) not null,
                        id_estado int(3),
                        FOREIGN KEY (id_sensor) REFERENCES sensores(id_sensor),
                        FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);
CREATE TABLE fotos(
                      id_foto int(8) primary key AUTO_INCREMENT,
                      fecha datetime,
                      url varchar(512),
                      id_evento int(8) unique,
                      FOREIGN KEY (id_evento) REFERENCES eventos(id_evento) on delete cascade
);


CREATE TABLE usuarios (
                          id_usuario int(4) NOT NULL primary key AUTO_INCREMENT,
                          usuario varchar(20) NOT NULL unique,
                          password varchar(500) NOT NULL,
                          nombre varchar(25) NOT NULL,
                          correo varchar(50) NOT NULL unique,
                          apellido1 varchar(25) not null ,
                          apellido2 varchar(25) DEFAULT NULL,
                          id_rol int(3) NOT NULL,
                          codigos int(5) NOT NULL,
                          FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);
drop table placas;
INSERT INTO usuarios (usuario, password, nombre, apellido1, apellido2, id_rol, codigos, correo) VALUES ('mik', 'asd', 'asd','asd', 'asd', 3, 10000, 'sadas@dad');
select * from usuarios;
DELETE FROM  usuarios WHERE id_usuario = 1;
SELECT COUNT(*) AS numRegistro,usuario,password,id_rol from usuarios;

SELECT count(*) as number from usuarios WHERE usuario='mikel' and correo='aaasda@sadas.com' and codigos=37173;
SELECT nombre,correo,apellido1,apellido2,codigos from usuarios WHERE id_usuario=2;
UPDATE usuarios SET codigos = 20000 WHERE codigos = ?;

SELECT roles.nombre AS nombre_rol,usuarios.id_usuario,usuarios.usuario,usuarios.nombre, usuarios.apellido1, usuarios.correo
FROM usuarios
         JOIN roles ON usuarios.id_rol = roles.id_rol
order by nombre_rol;

SELECT roles.nombre AS nombre_rol,usuarios.id_usuario,usuarios.usuario,usuarios.nombre, usuarios.apellido1, usuarios.correo
FROM usuarios
         JOIN roles ON usuarios.id_rol = roles.id_rol
order by nombre_rol;

select id_sensor,nombre from sensores;
select id_e from eventos;

SELECT e.fecha,s.nombre,es.nombre,f.id_foto
FROM eventos e
join estados es using (id_estado)
join fotos f using (id_evento)
join sensores s  using (id_sensor);
select * from eventos;
JOIN roles ON usuarios.id_rol = roles.id_rol
join
order by nombre_rol;
SELECT e.id_evento, e.fecha, s.nombre AS nombre_sensor, es.nombre AS nombre_estado, f.id_foto as foto
FROM eventos e
         JOIN estados es USING (id_estado)
         LEFT JOIN fotos f USING (id_evento)
         JOIN sensores s USING (id_sensor)
        ORDER BY 1;

select * from eventos;
INSERT INTO eventos (fecha, id_sensor, id_estado) VALUES ('2023-05-12 10:31:00', 2, 1);
SELECT id_sensor, nombre FROM sensores order by 1;

SELECT COUNT(*) AS cantidad,nombre
from eventos e
join estados es  USING (id_estado)
group by 2;

select * from placas;
SELECT est FROM sensores

INSERT INTO fotos (fecha, url, id_evento)
VALUES ('2023-05-21 11:00:00', 'http://ejemplo.com/foto1.jpg', 119;
INSERT INTO fotos (fecha, url, id_evento)
VALUES ('2023-03-21 11:00:00', 'http://ejemplo.com/foto1.jpg', 11);

drop table fotos;

SELECT f.fecha, f.url, s.nombre AS nombre_sensor, es.nombre AS nombre_estado,p.nombre as nombre_placa
FROM eventos e
         JOIN estados es USING (id_estado)
         LEFT JOIN fotos f USING (id_evento)
         JOIN sensores s USING (id_sensor)
         JOIN placas p USING (id_placa);

SELECT f.fecha, f.url, s.nombre AS nombre_sensor, es.nombre AS nombre_estado,p.nombre as nombre_placa
FROM eventos e
         JOIN estados es USING (id_estado)
         LEFT JOIN fotos f USING (id_evento)
         JOIN sensores s USING (id_sensor)
         JOIN placas p USING (id_placa);

SELECT s.nombre,count(*)
FROM eventos e
left join sensores s USING (id_sensor)
group by 1;

SELECT s.nombre, COUNT(e.id_sensor) AS cantidad
FROM sensores s
LEFT JOIN eventos e using(id_sensor)
GROUP BY s.nombre

SELECT s.nombre, COUNT(e.id_sensor) AS cantidad
FROM sensores s
         LEFT JOIN eventos e USING (id_sensor)
WHERE e.fecha >= SYSDATE() - INTERVAL 7 DAY
GROUP BY s.nombre;

SELECT DATE(e.fecha) AS fecha, COUNT(*) AS cantidad_eventos
FROM eventos e
WHERE e.fecha >= CURDATE() - INTERVAL 6 DAY
GROUP BY DATE(e.fecha) asc ;

SELECT s.nombre, COUNT(e.id_sensor) AS cantidad
                FROM sensores s
                LEFT JOIN eventos e using(id_sensor)
                WHERE e.fecha >= SYSDATE() - INTERVAL 2 DAY
                GROUP BY s.nombre;


select * from fotos;

select * from eventos;
UPDATE placas SET est=2 where id_e=1

UPDATE placas SET est=2 where id_placa=1;

SELECT nombre, ufecha FROM placas where sysdate()-placas.ufecha<120;

UPDATE placas SET ufecha='2023-05-24T08:12:03' WHERE id_placa=1

SELECT est FROM sensores ORDER BY id_sensor ASC;
SELECT est FROM placas WHERE id_placa = 1;

SELECT descripcion FROM sensores WHERE id_sensor=2;