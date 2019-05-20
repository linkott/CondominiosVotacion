--
-- PostgreSQL database dump
--

-- Started on 2011-06-30 16:29:01

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 334 (class 2612 OID 16386)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

--
-- TOC entry 323 (class 1247 OID 16772)
-- Dependencies: 5 1526
-- Name: tablefunc_crosstab_2; Type: TYPE; Schema: public; Owner: fran
--

CREATE TYPE tablefunc_crosstab_2 AS (
	row_name text,
	category_1 text,
	category_2 text
);


ALTER TYPE public.tablefunc_crosstab_2 OWNER TO fran;

--
-- TOC entry 325 (class 1247 OID 16775)
-- Dependencies: 5 1527
-- Name: tablefunc_crosstab_3; Type: TYPE; Schema: public; Owner: fran
--

CREATE TYPE tablefunc_crosstab_3 AS (
	row_name text,
	category_1 text,
	category_2 text,
	category_3 text
);


ALTER TYPE public.tablefunc_crosstab_3 OWNER TO fran;

--
-- TOC entry 327 (class 1247 OID 16778)
-- Dependencies: 5 1528
-- Name: tablefunc_crosstab_4; Type: TYPE; Schema: public; Owner: fran
--

CREATE TYPE tablefunc_crosstab_4 AS (
	row_name text,
	category_1 text,
	category_2 text,
	category_3 text,
	category_4 text
);


ALTER TYPE public.tablefunc_crosstab_4 OWNER TO fran;

--
-- TOC entry 26 (class 1255 OID 16784)
-- Dependencies: 5
-- Name: connectby(text, text, text, text, integer, text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, integer, text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text';


ALTER FUNCTION public.connectby(text, text, text, text, integer, text) OWNER TO fran;

--
-- TOC entry 27 (class 1255 OID 16785)
-- Dependencies: 5
-- Name: connectby(text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, integer) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text';


ALTER FUNCTION public.connectby(text, text, text, text, integer) OWNER TO fran;

--
-- TOC entry 28 (class 1255 OID 16786)
-- Dependencies: 5
-- Name: connectby(text, text, text, text, text, integer, text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, text, integer, text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text_serial';


ALTER FUNCTION public.connectby(text, text, text, text, text, integer, text) OWNER TO fran;

--
-- TOC entry 29 (class 1255 OID 16787)
-- Dependencies: 5
-- Name: connectby(text, text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, text, integer) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text_serial';


ALTER FUNCTION public.connectby(text, text, text, text, text, integer) OWNER TO fran;

--
-- TOC entry 20 (class 1255 OID 16769)
-- Dependencies: 5
-- Name: crosstab(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab(text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab(text) OWNER TO fran;

--
-- TOC entry 24 (class 1255 OID 16782)
-- Dependencies: 5
-- Name: crosstab(text, integer); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab(text, integer) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab(text, integer) OWNER TO fran;

--
-- TOC entry 25 (class 1255 OID 16783)
-- Dependencies: 5
-- Name: crosstab(text, text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab(text, text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab_hash';


ALTER FUNCTION public.crosstab(text, text) OWNER TO fran;

--
-- TOC entry 21 (class 1255 OID 16779)
-- Dependencies: 5 323
-- Name: crosstab2(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab2(text) RETURNS SETOF tablefunc_crosstab_2
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab2(text) OWNER TO fran;

--
-- TOC entry 22 (class 1255 OID 16780)
-- Dependencies: 325 5
-- Name: crosstab3(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab3(text) RETURNS SETOF tablefunc_crosstab_3
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab3(text) OWNER TO fran;

--
-- TOC entry 23 (class 1255 OID 16781)
-- Dependencies: 327 5
-- Name: crosstab4(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab4(text) RETURNS SETOF tablefunc_crosstab_4
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab4(text) OWNER TO fran;

--
-- TOC entry 19 (class 1255 OID 16768)
-- Dependencies: 5
-- Name: normal_rand(integer, double precision, double precision); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION normal_rand(integer, double precision, double precision) RETURNS SETOF double precision
    LANGUAGE c STRICT
    AS '$libdir/tablefunc', 'normal_rand';


ALTER FUNCTION public.normal_rand(integer, double precision, double precision) OWNER TO fran;

SET default_tablespace = '';

SET default_with_oids = true;

--
-- TOC entry 1529 (class 1259 OID 16794)
-- Dependencies: 5
-- Name: hora; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE hora (
    idhora integer,
    horainicio time without time zone,
    horafin time without time zone,
    descripcion character varying(50)
);


ALTER TABLE public.hora OWNER TO fran;

--
-- TOC entry 1820 (class 0 OID 0)
-- Dependencies: 1529
-- Name: COLUMN hora.idhora; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.idhora IS 'Identificación de la Hora';


--
-- TOC entry 1821 (class 0 OID 0)
-- Dependencies: 1529
-- Name: COLUMN hora.horainicio; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.horainicio IS 'Hora de Inicio';


--
-- TOC entry 1822 (class 0 OID 0)
-- Dependencies: 1529
-- Name: COLUMN hora.horafin; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.horafin IS 'Hora Fin';


--
-- TOC entry 1823 (class 0 OID 0)
-- Dependencies: 1529
-- Name: COLUMN hora.descripcion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.descripcion IS 'Descripción del Tipo de Menú';


--
-- TOC entry 1530 (class 1259 OID 16809)
-- Dependencies: 5
-- Name: menu; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE menu (
    idmenu integer,
    fecha date,
    descripcion text
);


ALTER TABLE public.menu OWNER TO fran;

--
-- TOC entry 1824 (class 0 OID 0)
-- Dependencies: 1530
-- Name: COLUMN menu.idmenu; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN menu.idmenu IS 'Identificación del Menú (Relacionado con tabla hora)';


--
-- TOC entry 1825 (class 0 OID 0)
-- Dependencies: 1530
-- Name: COLUMN menu.fecha; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN menu.fecha IS 'Fecha de Disponibilidad del Menú';


--
-- TOC entry 1826 (class 0 OID 0)
-- Dependencies: 1530
-- Name: COLUMN menu.descripcion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN menu.descripcion IS 'Descripción Detallada del Menú';


SET default_with_oids = false;

--
-- TOC entry 1521 (class 1259 OID 16705)
-- Dependencies: 5
-- Name: persona; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE persona (
    cedula integer,
    apellidos character varying(50),
    nombre character varying(50),
    fechanacimiento date,
    fechaingreso date,
    sexo character varying(1),
    estadocivil character varying(1),
    direccion character varying(100),
    telhabitacion character varying(15),
    teltrabajo character varying(15),
    telcelular character varying(15),
    email character varying(50),
    tipopersona character varying(2)
);


ALTER TABLE public.persona OWNER TO fran;

--
-- TOC entry 1827 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.cedula; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.cedula IS 'Número de Cédula';


--
-- TOC entry 1828 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.apellidos; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.apellidos IS 'Apellidos';


--
-- TOC entry 1829 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.nombre; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.nombre IS 'Nombres';


--
-- TOC entry 1830 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.fechanacimiento; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.fechanacimiento IS 'Fecha de Nacimiento';


--
-- TOC entry 1831 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.fechaingreso; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.fechaingreso IS 'Fecha de Ingreso al CUC';


--
-- TOC entry 1832 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.sexo; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.sexo IS 'Sexo (F:Femenino, M:Masculino)';


--
-- TOC entry 1833 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.estadocivil; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.estadocivil IS 'Estado Civil (S:Soltero, C:Casado, D:Divorciado, V:Viudo, O:Otro)';


--
-- TOC entry 1834 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.direccion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.direccion IS 'Dirección de Habitación ';


--
-- TOC entry 1835 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.telhabitacion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.telhabitacion IS 'Teléfono de Habitación';


--
-- TOC entry 1836 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.teltrabajo; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.teltrabajo IS 'Teléfono de Trabajo';


--
-- TOC entry 1837 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.telcelular; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.telcelular IS 'Teléfono Celular';


--
-- TOC entry 1838 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.email; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.email IS 'Dirección Email';


--
-- TOC entry 1839 (class 0 OID 0)
-- Dependencies: 1521
-- Name: COLUMN persona.tipopersona; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.tipopersona IS 'Tipo de Persona (Relacionado con Tabla TipoPersona)';


--
-- TOC entry 1524 (class 1259 OID 16729)
-- Dependencies: 5
-- Name: tarifa; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE tarifa (
    idtipopersona character varying(2),
    monto money
);


ALTER TABLE public.tarifa OWNER TO fran;

--
-- TOC entry 1840 (class 0 OID 0)
-- Dependencies: 1524
-- Name: COLUMN tarifa.idtipopersona; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tarifa.idtipopersona IS 'Identificación Tipo Persona (Relacionado con Tabla TipoPersona)';


--
-- TOC entry 1841 (class 0 OID 0)
-- Dependencies: 1524
-- Name: COLUMN tarifa.monto; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tarifa.monto IS 'Monto en BsF. de la Comida';


--
-- TOC entry 1523 (class 1259 OID 16720)
-- Dependencies: 5
-- Name: tipopersona; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE tipopersona (
    idtipo character varying(2),
    descripcion character varying(50)
);


ALTER TABLE public.tipopersona OWNER TO fran;

--
-- TOC entry 1842 (class 0 OID 0)
-- Dependencies: 1523
-- Name: COLUMN tipopersona.idtipo; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tipopersona.idtipo IS 'Identificación Tipo de Persona';


--
-- TOC entry 1843 (class 0 OID 0)
-- Dependencies: 1523
-- Name: COLUMN tipopersona.descripcion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tipopersona.descripcion IS 'Descripción del Tipo de Persona';


--
-- TOC entry 1522 (class 1259 OID 16717)
-- Dependencies: 5
-- Name: transaccion; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE transaccion (
    cedula integer,
    fechatransaccion date,
    horatransaccion time without time zone,
    idhora integer
);


ALTER TABLE public.transaccion OWNER TO fran;

--
-- TOC entry 1844 (class 0 OID 0)
-- Dependencies: 1522
-- Name: COLUMN transaccion.cedula; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.cedula IS 'Cedula de la Persona (Relacionado con la Tabla Persona)';


--
-- TOC entry 1845 (class 0 OID 0)
-- Dependencies: 1522
-- Name: COLUMN transaccion.fechatransaccion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.fechatransaccion IS 'Fecha de la Transacción (Fecha en que usó el Servicio)';


--
-- TOC entry 1846 (class 0 OID 0)
-- Dependencies: 1522
-- Name: COLUMN transaccion.horatransaccion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.horatransaccion IS 'Hora de la Transacción (Hora en que usó el Servicio)';


--
-- TOC entry 1847 (class 0 OID 0)
-- Dependencies: 1522
-- Name: COLUMN transaccion.idhora; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.idhora IS 'Identifica el tipo de hora, relacionado con tabla hora';


--
-- TOC entry 1525 (class 1259 OID 16732)
-- Dependencies: 5
-- Name: usuario; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE usuario (
    idusuario character varying(15),
    nombreusuario character varying(50),
    password character varying(15),
    tipousuario character varying(2),
    preguntasecreta character varying(50),
    respuestasecreta character varying(50)
);


ALTER TABLE public.usuario OWNER TO fran;

--
-- TOC entry 1848 (class 0 OID 0)
-- Dependencies: 1525
-- Name: COLUMN usuario.idusuario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.idusuario IS 'Identificación del Usuario para inicio de sesión';


--
-- TOC entry 1849 (class 0 OID 0)
-- Dependencies: 1525
-- Name: COLUMN usuario.nombreusuario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.nombreusuario IS 'Nombre y Apellidos del Usuario';


--
-- TOC entry 1850 (class 0 OID 0)
-- Dependencies: 1525
-- Name: COLUMN usuario.password; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.password IS 'Password de inicio de sesión';


--
-- TOC entry 1851 (class 0 OID 0)
-- Dependencies: 1525
-- Name: COLUMN usuario.tipousuario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.tipousuario IS 'Tipo de Usuario relacionado con la tabla TipoPersona';


--
-- TOC entry 1852 (class 0 OID 0)
-- Dependencies: 1525
-- Name: COLUMN usuario.preguntasecreta; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.preguntasecreta IS 'Pregunta Secreta para la recuperacón de la contraseña';


--
-- TOC entry 1853 (class 0 OID 0)
-- Dependencies: 1525
-- Name: COLUMN usuario.respuestasecreta; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.respuestasecreta IS 'Respuesta Secreta para la recuperación de la contraseña';


--
-- TOC entry 1813 (class 0 OID 16794)
-- Dependencies: 1529
-- Data for Name: hora; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO hora (idhora, horainicio, horafin, descripcion) VALUES (2, '11:00:00', '14:00:00', 'Almuerzo');
INSERT INTO hora (idhora, horainicio, horafin, descripcion) VALUES (3, '17:00:00', '20:00:00', 'Cena');
INSERT INTO hora (idhora, horainicio, horafin, descripcion) VALUES (1, '07:00:00', '09:00:00', 'Desayuno');


--
-- TOC entry 1814 (class 0 OID 16809)
-- Dependencies: 1530
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO menu (idmenu, fecha, descripcion) VALUES (1, '2011-06-30', '1. Empanadas de Carne Molida.
2. Arepas de jamon y queso.
3. Jugo de Manzana.
4. Jugo de Parchita.
	');
INSERT INTO menu (idmenu, fecha, descripcion) VALUES (2, '2011-06-30', '1. Arroz con Pollo.
2. Sopa de cebolla.
3. Jugo de Manzana. ');
INSERT INTO menu (idmenu, fecha, descripcion) VALUES (3, '2011-06-30', '1. Croisant Queso.
2. Empanadas.
3. Ensalada Fria.
4. Nestea. 
	');
INSERT INTO menu (idmenu, fecha, descripcion) VALUES (3, '2011-06-30', '1. Croisant Queso.
2. Empanadas.
3. Ensalada Fria.
4. Nestea. 
	');
INSERT INTO menu (idmenu, fecha, descripcion) VALUES (1, '2011-06-30', 'Carne con papas');
INSERT INTO menu (idmenu, fecha, descripcion) VALUES (1, '2011-06-30', 'Detalle el Menú por contenido ...
	1.xxxxxxx
	2.xxxxxxx
	');
INSERT INTO menu (idmenu, fecha, descripcion) VALUES (1, '2011-06-30', 'Detalle el Menú por contenido ...
	1.xxxxxxx
	2.xxxxxxx
	');


--
-- TOC entry 1808 (class 0 OID 16705)
-- Dependencies: 1521
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (10114111, 'MONTILLA', 'FRANCISCO', '1969-03-16', NULL, 'M', 'C', 'PALO VERDE', '02122518517', '02127310762', '04265196999', 'franco01@hotmail.com', '04');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (3404624, 'GARCIA', 'MARIO', '1946-11-11', NULL, 'M', 'D', 'LA FLORIDA', '02127310033', '02127310762', '04166221512', 'garciam46@hotmail.com', '05');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (55555555, 'BARRETO', 'MANUEL', '1953-12-15', NULL, 'M', 'C', 'CUA', '02123335858', '02127310044', '04165532523', 'mbarreto@gmail.com', '06');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (10114111, 'MONTILLA ROJAS', 'FRANCISCO JOSE', '1969-03-16', '1998-02-01', 'M', 'C', 'PALO VERDE', '02122518517', '02127310762', '04265196999', 'franco01@gmail.com', '04');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (3404624, 'GARCIA SULBARAN', 'MARIO JOSE', '1946-11-11', NULL, 'M', 'D', 'LA FLORIDA', '02127310033', '02127310762', '04166221512', 'garciam46@hotmail.com', '05');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (3657041, 'ITURRIZA RUIZ', 'VASCO GONZALO', '1947-05-14', NULL, 'M', 'C', 'CAURIMARE', '02129864581', '02122086363', '04166327539', 'iturrizav@hotmail.com', '04');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (55555555, 'BARRETO', 'MANUEL', '1953-06-15', NULL, 'M', 'C', 'CUA', '02122512525', '02127310033', '04166356714', 'mbarreto@gmail.com', '06');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (11111111, 'GARCIA', 'BELEN', NULL, NULL, 'F', NULL, NULL, NULL, NULL, NULL, NULL, '07');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (22222222, 'ANDRADE', 'JULIA', NULL, NULL, 'F', NULL, NULL, NULL, NULL, NULL, NULL, '07');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (33333333, 'PEREZ', 'PEDRO', '1969-03-16', '2045-03-15', 'M', 'C', 'ASDASD', '02122721212', '02122721212', '02122721212', 'F@VF.COM', '07');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (44444444, 'RAMIREZ', 'PETRA', '2001-02-15', '2001-02-15', 'F', 'C', 'SDFSDF', '02122525252', '02122525252', '02122525252', 'DF@GH.COM', '05');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (66666666, 'SAENZ', 'MANUELA', '1945-12-15', '1945-12-15', 'F', 'C', 'SDFSDF', '4564564564', '4564564564', '4564564564', 'SDFS@SDF.COM', '05');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (77777777, 'DIAZ', 'ANDREA', '1945-12-15', '1945-12-15', 'F', 'C', 'SDFSDF', '34534534534', '3453453454', '34534534534', 'WSE@QW.COM', '06');
INSERT INTO persona (cedula, apellidos, nombre, fechanacimiento, fechaingreso, sexo, estadocivil, direccion, telhabitacion, teltrabajo, telcelular, email, tipopersona) VALUES (11031905, 'GONZALEZ', 'SUYIN', '1971-10-23', '1986-03-16', 'F', 'C', 'PALO VERDE', '02122518517', '02122086746', '04265195285', 'suyin_gonzalez@hotmail.com', '04');


--
-- TOC entry 1811 (class 0 OID 16729)
-- Dependencies: 1524
-- Data for Name: tarifa; Type: TABLE DATA; Schema: public; Owner: fran
--



--
-- TOC entry 1810 (class 0 OID 16720)
-- Dependencies: 1523
-- Data for Name: tipopersona; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO tipopersona (idtipo, descripcion) VALUES ('01', 'Administrador');
INSERT INTO tipopersona (idtipo, descripcion) VALUES ('02', 'Usuario');
INSERT INTO tipopersona (idtipo, descripcion) VALUES ('03', 'Supervisor');
INSERT INTO tipopersona (idtipo, descripcion) VALUES ('04', 'Administrativo');
INSERT INTO tipopersona (idtipo, descripcion) VALUES ('05', 'Docente');
INSERT INTO tipopersona (idtipo, descripcion) VALUES ('06', 'Obrero');
INSERT INTO tipopersona (idtipo, descripcion) VALUES ('07', 'Estudiante');
INSERT INTO tipopersona (idtipo, descripcion) VALUES ('08', 'Invitado');


--
-- TOC entry 1809 (class 0 OID 16717)
-- Dependencies: 1522
-- Data for Name: transaccion; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-31', '03:32:51', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-31', '03:32:58', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-31', '03:33:11', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-31', '03:33:17', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-31', '03:33:29', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-31', '03:33:35', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-31', '03:33:48', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-31', '03:33:54', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-31', '03:34:19', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-31', '03:34:25', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-31', '03:34:37', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-31', '03:34:42', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-31', '03:34:54', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-31', '03:35:01', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-30', '20:51:10', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-30', '20:56:58', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-30', '20:57:05', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3657041, '2011-03-30', '20:57:13', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-30', '20:57:20', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-30', '20:57:30', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-30', '20:57:49', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-30', '20:58:00', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3657041, '2011-03-30', '20:58:08', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-30', '20:58:14', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-30', '20:58:32', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-30', '20:59:14', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-30', '20:59:25', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (55555555, '2011-03-30', '20:59:34', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-03-30', '20:59:42', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3404624, '2011-04-14', '18:54:25', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (3657041, '2011-04-14', '18:54:36', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (11111111, '2011-04-15', '20:57:42', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (11111111, '2011-04-15', '20:58:17', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (22222222, '2011-04-15', '20:58:39', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (33333333, '2011-04-15', '21:06:53', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (33333333, '2011-04-15', '21:07:02', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (44444444, '2011-04-15', '21:07:11', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (44444444, '2011-04-15', '21:07:20', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (66666666, '2011-04-15', '21:07:46', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (66666666, '2011-04-15', '21:07:58', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (77777777, '2011-04-15', '21:08:07', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (77777777, '2011-04-15', '21:08:17', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (11031905, '2011-04-15', '21:11:39', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (11031905, '2011-04-15', '21:11:47', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (10114111, '2011-06-14', '08:46:47', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (10114111, '2011-06-14', '11:47:52', NULL);
INSERT INTO transaccion (cedula, fechatransaccion, horatransaccion, idhora) VALUES (10114111, '2011-06-14', '17:48:56', NULL);


--
-- TOC entry 1812 (class 0 OID 16732)
-- Dependencies: 1525
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO usuario (idusuario, nombreusuario, password, tipousuario, preguntasecreta, respuestasecreta) VALUES ('admin', 'Administrador', 'admin', '01', NULL, NULL);
INSERT INTO usuario (idusuario, nombreusuario, password, tipousuario, preguntasecreta, respuestasecreta) VALUES ('pedro', 'Pedro Perez', 'perez', NULL, 'cualquiera', 'cualquiera');
INSERT INTO usuario (idusuario, nombreusuario, password, tipousuario, preguntasecreta, respuestasecreta) VALUES ('ggg', 'hhhh', 'ñññ', NULL, 'bhhh', 'jjjj');


--
-- TOC entry 1819 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
GRANT ALL ON SCHEMA public TO fran;


-- Completed on 2011-06-30 16:29:01

--
-- PostgreSQL database dump complete
--

