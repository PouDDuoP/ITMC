--- Script idempotente para inicialización de ITMC ---
--- Se ejecuta automáticamente via docker-entrypoint-initdb.d ---

-- Crear esquema si no existe
CREATE SCHEMA IF NOT EXISTS itmc AUTHORIZATION postgres;

--Creacion de tablas
--Inicio--
CREATE TABLE IF NOT EXISTS itmc.departamento
(
  id serial NOT NULL,
  nombre varchar (50) NOT NULL,
  descripcion varchar (100),
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_departamento PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS itmc.cargo
(
  id serial NOT NULL,
  departamento int NOT NULL,
  nombre varchar (50) NOT NULL,
  descripcion varchar (100),
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_cargo PRIMARY KEY (id),
  CONSTRAINT fkey_departamento FOREIGN KEY (departamento)
      REFERENCES itmc.departamento (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS itmc.perfil_usuario
(
  id serial NOT NULL,
  nombre varchar (50) NOT NULL,
  descripcion varchar (100),
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_pefil PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS itmc.empleado
(
  id varchar(15) NOT NULL,
  nombre varchar(40) NOT NULL,
  apellido varchar(40) NOT NULL,
  email varchar(40),
  cargo int NOT NULL,
  fecha_ingreso timestamp without time zone NOT NULL,
  ext_telefono varchar(6) NOT NULL,
  nro_telefono varchar(8) NOT NULL,
  departamento int NOT NULL,
  sueldo float NOT NULL,
  status boolean NOT NULL DEFAULT true,
 CONSTRAINT pkey_id_empleado PRIMARY KEY (id),
 CONSTRAINT fkey_cargo FOREIGN KEY (cargo)
     REFERENCES itmc.cargo (id) MATCH SIMPLE
     ON UPDATE NO ACTION ON DELETE NO ACTION,
 CONSTRAINT fkey_departamento FOREIGN KEY (departamento)
     REFERENCES itmc.departamento (id) MATCH SIMPLE
     ON UPDATE NO ACTION ON DELETE NO ACTION
);


CREATE TABLE IF NOT EXISTS itmc.usuario
(
  id serial NOT NULL,
  cedula_empleado varchar(15) NOT NULL,
  clave varchar (50) NOT NULL,
  perfil int NOT NULL,
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_usuario PRIMARY KEY (id),
  CONSTRAINT fkey_cedula_empleado FOREIGN KEY (cedula_empleado)
      REFERENCES itmc.empleado (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_perfil FOREIGN KEY (perfil)
      REFERENCES itmc.perfil_usuario (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS itmc.hijo
(
  id serial NOT NULL,
  cedula_hijo varchar(15),
  nombre varchar(40) NOT NULL,
  apellido varchar(40) NOT NULL,
  fecha_nacimiento timestamp without time zone NOT NULL,
  nivel_academico varchar(60),
  CONSTRAINT pkey_id_hijo PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS itmc.hijo_empleado
(
  id serial NOT NULL,
  cedula_empleado varchar(15) NOT NULL,
  hijo int NOT NULL,
  CONSTRAINT pkey_id_hijo_empleado PRIMARY KEY (id),
  CONSTRAINT fkey_cedula_empleado FOREIGN KEY (cedula_empleado)
      REFERENCES itmc.empleado (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_hijo FOREIGN KEY (hijo)
      REFERENCES itmc.hijo (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS itmc.estado_solicitud
(
  id serial NOT NULL,
  nombre varchar (50) NOT NULL,
  descripcion varchar (100),
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_estado_solicitud PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS itmc.tipo_solicitud
(
  id serial NOT NULL,
  nombre varchar (50) NOT NULL,
  descripcion varchar (100),
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_tipo_solicitud PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS itmc.solicitud
(
  id serial NOT NULL,
  fecha_solicitud timestamp without time zone NOT NULL,
  cedula_solicitante varchar(15) NOT NULL,
  descripcion varchar(200) NOT NULL,
  tipo_solicitud int NOT NULL,
  estado_solicitud int NOT NULL,
  departamento int NOT NULL,
  CONSTRAINT pkey_id_solicitud PRIMARY KEY (id),
  CONSTRAINT fkey_cedula_solicitante FOREIGN KEY (cedula_solicitante)
      REFERENCES itmc.empleado (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_estado_solicitud FOREIGN KEY (estado_solicitud)
      REFERENCES itmc.estado_solicitud (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_tipo_solicitud FOREIGN KEY (tipo_solicitud)
      REFERENCES itmc.tipo_solicitud (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_departamento FOREIGN KEY (departamento)
      REFERENCES itmc.departamento (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS itmc.tipo_beneficio
(
  id serial NOT NULL,
  nombre varchar (50) NOT NULL,
  descripcion varchar (100),
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_tipo_beneficio PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS itmc.beneficiario
(
  id serial NOT NULL,
  cedula_empleado character varying(15) NOT NULL,
  cod_hijo integer NOT NULL,
  tipo_beneficio integer NOT NULL,
  fecha_solicitud timestamp without time zone NOT NULL,
  estado_solicitud integer NOT NULL,
  status boolean NOT NULL DEFAULT true,
  CONSTRAINT pkey_id_estado PRIMARY KEY (id),
  CONSTRAINT fkey_cedula_empleado FOREIGN KEY (cedula_empleado)
      REFERENCES itmc.empleado (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_cod_hijo FOREIGN KEY (cod_hijo)
      REFERENCES itmc.hijo_empleado (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_estado_solicitud FOREIGN KEY (estado_solicitud)
      REFERENCES itmc.estado_solicitud (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_tipo_beneficio FOREIGN KEY (tipo_beneficio)
      REFERENCES itmc.tipo_beneficio (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS itmc.bitacora
(
  id serial NOT NULL,
  cedula_empleado varchar(15) NOT NULL,
  cod_usuario int NOT NULL,
  cod_operacion varchar (100) NOT NULL,
  tabla varchar (40) NOT NULL,
  columna varchar (40) NOT NULL,
  valor_original varchar (500),
  valor_nuevo varchar (500),
  url varchar (300) NOT NULL,
  --sql_query varchar (500) NOT NULL,
  fecha timestamp without time zone NOT NULL,
  CONSTRAINT pkey_id_bitacora PRIMARY KEY (id),
  CONSTRAINT fkey_cedula_empleado FOREIGN KEY (cedula_empleado)
      REFERENCES itmc.empleado (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fkey_cod_usuario FOREIGN KEY (cod_usuario)
      REFERENCES itmc.usuario (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

--Fin creación de tablas--

--Inserciones a la base de datos--
--Inicio--

INSERT INTO itmc.departamento(nombre, descripcion, status)
  SELECT 'DESARROLLO WEB','DEPARTAMENTO ACARGO DE LA OPTIMIZACION DE LA PAGINA',TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.departamento WHERE nombre = 'DESARROLLO WEB');
INSERT INTO itmc.departamento(nombre, descripcion, status)
  SELECT 'ADMINISTRACION','555',TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.departamento WHERE nombre = 'ADMINISTRACION');
INSERT INTO itmc.departamento(nombre, descripcion, status)
  SELECT 'TALENTO HUMANO','',TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.departamento WHERE nombre = 'TALENTO HUMANO');


INSERT INTO itmc.cargo(departamento,nombre,descripcion,status)
  SELECT 1,'DESRROLLADOR WEB', 'PERSONAL A CARGO DE LA CREACION DE MODULOS Y OPTIMIZACION DE LAS PAGINAS WEB', TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.cargo WHERE nombre = 'DESRROLLADOR WEB');
INSERT INTO itmc.cargo(departamento,nombre,descripcion,status)
  SELECT 2,'ADMINISTRADOR', '555', TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.cargo WHERE nombre = 'ADMINISTRADOR');
INSERT INTO itmc.cargo(departamento,nombre,descripcion,status)
  SELECT 3,'ANALISTA DE TALENTO HUMANO', '', TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.cargo WHERE nombre = 'ANALISTA DE TALENTO HUMANO');


INSERT INTO itmc.perfil_usuario(nombre, descripcion, status)
  SELECT 'EMPLEADO', 'PERSONAL QUE LABORA EN LA ENTIDAD', TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.perfil_usuario WHERE nombre = 'EMPLEADO');
INSERT INTO itmc.perfil_usuario(nombre, descripcion, status)
  SELECT 'ANALISTA DE TALENTO HUMANO', 'PERSONAL A CARGO DE CONTRATAR PERSONAL CAPACITADO PARA LABORAR EN LA ENTIDAD', TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.perfil_usuario WHERE nombre = 'ANALISTA DE TALENTO HUMANO');
INSERT INTO itmc.perfil_usuario(nombre, descripcion, status)
  SELECT 'ANALISTA DE SISTEMAS', 'PERSONAL A CARGO DE LA DOCUMENTACION DE LOS SISTEMAS EXISTENTES EN LA ENTIDAD', TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.perfil_usuario WHERE nombre = 'ANALISTA DE SISTEMAS');
INSERT INTO itmc.perfil_usuario(nombre, descripcion, status)
  SELECT 'ADMINISTRADOR DEL SISTEMA', 'PERSONAL CON PERMISOS Y ACCESO A LA MAYORIA DE LOS MODULOS', TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.perfil_usuario WHERE nombre = 'ADMINISTRADOR DEL SISTEMA');


INSERT INTO itmc.empleado(id, nombre, apellido, email, cargo, fecha_ingreso, ext_telefono,nro_telefono, departamento, sueldo, status)
  SELECT '1','Yenn', 'Yann', 'Yenn@gmail.com', 1,'2017-03-01', '0424', '9829234',1, 30000000, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.empleado WHERE id = '1');
INSERT INTO itmc.empleado(id, nombre, apellido, email, cargo, fecha_ingreso, ext_telefono,nro_telefono, departamento, sueldo, status)
  SELECT '2','Barr', 'Berr', 'Barr@gmail.com', 3,'2014-02-15', '0424', '8011634',3, 30000000, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.empleado WHERE id = '2');
INSERT INTO itmc.empleado(id, nombre, apellido, email, cargo, fecha_ingreso, ext_telefono,nro_telefono, departamento, sueldo, status)
  SELECT '3','Kenn', 'Kann', 'Kenn@gmail.com', 1,'2015-01-27', '0414', '9000034',1, 30000000, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.empleado WHERE id = '3');
INSERT INTO itmc.empleado(id, nombre, apellido, email, cargo, fecha_ingreso, ext_telefono,nro_telefono, departamento, sueldo, status)
  SELECT '4','Gerr', 'Garr', 'Gerr@gmail.com', 2,'2017-03-19', '0412', '1009234',2, 30000000, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.empleado WHERE id = '4');


INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '1', 'c4ca4238a0b923820dcc509a6f75849b', 4, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '1' AND perfil = 4);
INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '1', 'c4ca4238a0b923820dcc509a6f75849b', 3, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '1' AND perfil = 3);
INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '1', 'c4ca4238a0b923820dcc509a6f75849b', 2, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '1' AND perfil = 2);
INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '1', 'c4ca4238a0b923820dcc509a6f75849b', 1, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '1' AND perfil = 1);

INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '2', 'c4ca4238a0b923820dcc509a6f75849b', 2, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '2' AND perfil = 2);
INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '2', 'c4ca4238a0b923820dcc509a6f75849b', 1, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '2' AND perfil = 1);

INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '3', 'c4ca4238a0b923820dcc509a6f75849b', 3, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '3' AND perfil = 3);
INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '3', 'c4ca4238a0b923820dcc509a6f75849b', 1, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '3' AND perfil = 1);

INSERT INTO itmc.usuario(cedula_empleado, clave, perfil, status)
  SELECT '4', 'c4ca4238a0b923820dcc509a6f75849b', 1, TRUE
  WHERE NOT EXISTS (SELECT 1 FROM itmc.usuario WHERE cedula_empleado = '4' AND perfil = 1);

INSERT INTO itmc.tipo_solicitud(nombre, descripcion)
  SELECT 'Recibo de pago', 'Recibo de pago'
  WHERE NOT EXISTS (SELECT 1 FROM itmc.tipo_solicitud WHERE nombre = 'Recibo de pago');
INSERT INTO itmc.tipo_solicitud(nombre, descripcion)
  SELECT 'Constancia de trabajo', 'Constancia de trabajo'
  WHERE NOT EXISTS (SELECT 1 FROM itmc.tipo_solicitud WHERE nombre = 'Constancia de trabajo');

INSERT INTO itmc.estado_solicitud(nombre, descripcion)
  SELECT 'Nueva', 'Nueva'
  WHERE NOT EXISTS (SELECT 1 FROM itmc.estado_solicitud WHERE nombre = 'Nueva');
INSERT INTO itmc.estado_solicitud(nombre, descripcion)
  SELECT 'Pendiente','Pendiente'
  WHERE NOT EXISTS (SELECT 1 FROM itmc.estado_solicitud WHERE nombre = 'Pendiente');
INSERT INTO itmc.estado_solicitud(nombre, descripcion)
  SELECT 'Rechazada', 'Rechazada'
  WHERE NOT EXISTS (SELECT 1 FROM itmc.estado_solicitud WHERE nombre = 'Rechazada');

INSERT INTO itmc.tipo_beneficio(nombre, descripcion)
  SELECT 'Plan vacacional', ''
  WHERE NOT EXISTS (SELECT 1 FROM itmc.tipo_beneficio WHERE nombre = 'Plan vacacional');
INSERT INTO itmc.tipo_beneficio(nombre, descripcion)
  SELECT 'Utiles escolares',''
  WHERE NOT EXISTS (SELECT 1 FROM itmc.tipo_beneficio WHERE nombre = 'Utiles escolares');
INSERT INTO itmc.tipo_beneficio(nombre, descripcion)
  SELECT 'Juguetes',''
  WHERE NOT EXISTS (SELECT 1 FROM itmc.tipo_beneficio WHERE nombre = 'Juguetes');
INSERT INTO itmc.tipo_beneficio(nombre, descripcion)
  SELECT 'Guarderia', ''
  WHERE NOT EXISTS (SELECT 1 FROM itmc.tipo_beneficio WHERE nombre = 'Guarderia');

--Fin--


--FUNCIONES


CREATE OR REPLACE FUNCTION itmc.sp_bitacora(cedula_id varchar , usuario_id integer ,operacion varchar ,tabla varchar, columna varchar, valor_original varchar, valor_nuevo varchar, url varchar, fecha timestamp without time zone) RETURNS boolean AS
$BODY$
DECLARE resultado boolean = TRUE;
BEGIN
  INSERT INTO itmc.bitacora(cedula_empleado, cod_usuario, cod_operacion, tabla, columna, valor_original, valor_nuevo, url, fecha) 
  VALUES (cedula_id, usuario_id, operacion, tabla, columna, valor_original, valor_nuevo, url, fecha);
  return resultado;
END
$BODY$
language plpgsql;



--Alter table
-- ALTER TABLE itmc.bitacora
-- ALTER COLUMN cod_operacion SET DATA TYPE character varying(100);
