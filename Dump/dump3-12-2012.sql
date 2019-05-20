--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

--
-- Name: tablefunc_crosstab_2; Type: TYPE; Schema: public; Owner: fran
--

CREATE TYPE tablefunc_crosstab_2 AS (
	row_name text,
	category_1 text,
	category_2 text
);


ALTER TYPE public.tablefunc_crosstab_2 OWNER TO fran;

--
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
-- Name: connectby(text, text, text, text, integer, text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, integer, text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text';


ALTER FUNCTION public.connectby(text, text, text, text, integer, text) OWNER TO fran;

--
-- Name: connectby(text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, integer) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text';


ALTER FUNCTION public.connectby(text, text, text, text, integer) OWNER TO fran;

--
-- Name: connectby(text, text, text, text, text, integer, text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, text, integer, text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text_serial';


ALTER FUNCTION public.connectby(text, text, text, text, text, integer, text) OWNER TO fran;

--
-- Name: connectby(text, text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION connectby(text, text, text, text, text, integer) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'connectby_text_serial';


ALTER FUNCTION public.connectby(text, text, text, text, text, integer) OWNER TO fran;

--
-- Name: crosstab(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab(text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab(text) OWNER TO fran;

--
-- Name: crosstab(text, integer); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab(text, integer) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab(text, integer) OWNER TO fran;

--
-- Name: crosstab(text, text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab(text, text) RETURNS SETOF record
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab_hash';


ALTER FUNCTION public.crosstab(text, text) OWNER TO fran;

--
-- Name: crosstab2(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab2(text) RETURNS SETOF tablefunc_crosstab_2
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab2(text) OWNER TO fran;

--
-- Name: crosstab3(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab3(text) RETURNS SETOF tablefunc_crosstab_3
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab3(text) OWNER TO fran;

--
-- Name: crosstab4(text); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION crosstab4(text) RETURNS SETOF tablefunc_crosstab_4
    LANGUAGE c STABLE STRICT
    AS '$libdir/tablefunc', 'crosstab';


ALTER FUNCTION public.crosstab4(text) OWNER TO fran;

--
-- Name: normal_rand(integer, double precision, double precision); Type: FUNCTION; Schema: public; Owner: fran
--

CREATE FUNCTION normal_rand(integer, double precision, double precision) RETURNS SETOF double precision
    LANGUAGE c STRICT
    AS '$libdir/tablefunc', 'normal_rand';


ALTER FUNCTION public.normal_rand(integer, double precision, double precision) OWNER TO fran;

SET default_tablespace = '';

SET default_with_oids = true;

--
-- Name: asociacion; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE asociacion (
    idasociacion integer NOT NULL,
    nombre character varying(100),
    rif character varying(10),
    responsable character varying(100),
    email character varying(50),
    telefono character varying(15),
    fechainicio date,
    fechafin date,
    estatus character(1),
    idsede integer
);


ALTER TABLE public.asociacion OWNER TO fran;

--
-- Name: COLUMN asociacion.idasociacion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.idasociacion IS 'Identificación de la Asociación encargada de la Comida';


--
-- Name: COLUMN asociacion.nombre; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.nombre IS 'Nombre de la Asociación';


--
-- Name: COLUMN asociacion.rif; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.rif IS 'Número de RIF';


--
-- Name: COLUMN asociacion.responsable; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.responsable IS 'Nombre del Responsable de la Asociación';


--
-- Name: COLUMN asociacion.email; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.email IS 'Correo Electrónico Asociación o Responsable';


--
-- Name: COLUMN asociacion.telefono; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.telefono IS 'Teléfono de Contacto Asociación o Responsable';


--
-- Name: COLUMN asociacion.fechainicio; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.fechainicio IS 'Fecha de Incio de Contrato de la Asociación';


--
-- Name: COLUMN asociacion.fechafin; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.fechafin IS 'Fecha de Fin de Contrato de la Asociación';


--
-- Name: COLUMN asociacion.estatus; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.estatus IS 'Estatus Actual de la Asociación: [A]: Activa; [I]: Inactiva';


--
-- Name: COLUMN asociacion.idsede; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN asociacion.idsede IS 'Identificación de la Sede [Relacionado con la Tabla Sede]';


--
-- Name: asociacion_idasociacion_seq; Type: SEQUENCE; Schema: public; Owner: fran
--

CREATE SEQUENCE asociacion_idasociacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.asociacion_idasociacion_seq OWNER TO fran;

--
-- Name: asociacion_idasociacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: fran
--

ALTER SEQUENCE asociacion_idasociacion_seq OWNED BY asociacion.idasociacion;


--
-- Name: asociacion_idasociacion_seq; Type: SEQUENCE SET; Schema: public; Owner: fran
--

SELECT pg_catalog.setval('asociacion_idasociacion_seq', 9, true);


--
-- Name: hora; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE hora (
    idhora integer NOT NULL,
    horainicio time without time zone,
    horafin time without time zone,
    descripcion character varying(50),
    idsede integer NOT NULL
);


ALTER TABLE public.hora OWNER TO fran;

--
-- Name: COLUMN hora.idhora; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.idhora IS 'Identificación de la Hora';


--
-- Name: COLUMN hora.horainicio; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.horainicio IS 'Hora de Inicio';


--
-- Name: COLUMN hora.horafin; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.horafin IS 'Hora Fin';


--
-- Name: COLUMN hora.descripcion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.descripcion IS 'Descripción del Tipo de Menú';


--
-- Name: COLUMN hora.idsede; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN hora.idsede IS 'Identificación de la Sede [Relacionado con la Tabla Sede] ';


--
-- Name: hora_idsede_seq; Type: SEQUENCE; Schema: public; Owner: fran
--

CREATE SEQUENCE hora_idsede_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.hora_idsede_seq OWNER TO fran;

--
-- Name: hora_idsede_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: fran
--

ALTER SEQUENCE hora_idsede_seq OWNED BY hora.idsede;


--
-- Name: hora_idsede_seq; Type: SEQUENCE SET; Schema: public; Owner: fran
--

SELECT pg_catalog.setval('hora_idsede_seq', 3, true);


--
-- Name: menu; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE menu (
    idmenu integer NOT NULL,
    fecha date NOT NULL,
    descripcion text,
    idsede integer NOT NULL
);


ALTER TABLE public.menu OWNER TO fran;

--
-- Name: COLUMN menu.idmenu; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN menu.idmenu IS 'Identificación del Menú (Relacionado con tabla hora)';


--
-- Name: COLUMN menu.fecha; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN menu.fecha IS 'Fecha de Disponibilidad del Menú';


--
-- Name: COLUMN menu.descripcion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN menu.descripcion IS 'Descripción Detallada del Menú';


--
-- Name: COLUMN menu.idsede; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN menu.idsede IS 'Identificación de la Sede [Relacionado con la Tabla Sede] ';


SET default_with_oids = false;

--
-- Name: persona; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE persona (
    cedula integer NOT NULL,
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
    tipopersona character varying(2),
    idsede integer
);


ALTER TABLE public.persona OWNER TO fran;

--
-- Name: COLUMN persona.cedula; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.cedula IS 'Número de Cédula';


--
-- Name: COLUMN persona.apellidos; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.apellidos IS 'Apellidos';


--
-- Name: COLUMN persona.nombre; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.nombre IS 'Nombres';


--
-- Name: COLUMN persona.fechanacimiento; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.fechanacimiento IS 'Fecha de Nacimiento';


--
-- Name: COLUMN persona.fechaingreso; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.fechaingreso IS 'Fecha de Ingreso al CUC';


--
-- Name: COLUMN persona.sexo; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.sexo IS 'Sexo (F:Femenino, M:Masculino)';


--
-- Name: COLUMN persona.estadocivil; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.estadocivil IS 'Estado Civil (S:Soltero, C:Casado, D:Divorciado, V:Viudo, O:Otro)';


--
-- Name: COLUMN persona.direccion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.direccion IS 'Dirección de Habitación o Procedencia si tipopersona es Invitado';


--
-- Name: COLUMN persona.telhabitacion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.telhabitacion IS 'Teléfono de Habitación';


--
-- Name: COLUMN persona.teltrabajo; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.teltrabajo IS 'Teléfono de Trabajo';


--
-- Name: COLUMN persona.telcelular; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.telcelular IS 'Teléfono Celular';


--
-- Name: COLUMN persona.email; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.email IS 'Dirección Email';


--
-- Name: COLUMN persona.tipopersona; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.tipopersona IS 'Tipo de Persona (Relacionado con Tabla TipoPersona)';


--
-- Name: COLUMN persona.idsede; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN persona.idsede IS 'Identificación de la Sede [Relacionado con la Tabla Sede] ';


--
-- Name: sede; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE sede (
    idsede integer NOT NULL,
    nombre character varying(20)
);


ALTER TABLE public.sede OWNER TO fran;

--
-- Name: COLUMN sede.idsede; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sede.idsede IS 'Identificación de la Sede o Núcleo';


--
-- Name: COLUMN sede.nombre; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sede.nombre IS 'Nombre de la Sede o Núcleo';


SET default_with_oids = true;

--
-- Name: sugerencia; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE sugerencia (
    idsugerencia integer NOT NULL,
    cedula integer,
    email character varying(50),
    comentario text,
    tipo character(1),
    fecharegistro date,
    idsede integer
);


ALTER TABLE public.sugerencia OWNER TO fran;

--
-- Name: COLUMN sugerencia.idsugerencia; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sugerencia.idsugerencia IS 'Id de la Sugerencia';


--
-- Name: COLUMN sugerencia.cedula; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sugerencia.cedula IS 'Identificación de la Persona que hace la sugerencia - Relacionado con la Tabla Persona';


--
-- Name: COLUMN sugerencia.email; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sugerencia.email IS 'Email de la Persona que hace la sugerencia';


--
-- Name: COLUMN sugerencia.comentario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sugerencia.comentario IS 'Descripción de la Sugerencia o Reclamo';


--
-- Name: COLUMN sugerencia.tipo; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sugerencia.tipo IS 'Tipo de Sugerencia: 1:Sitio Web, 2:Atención, 3: Servicio, 4:horario';


--
-- Name: COLUMN sugerencia.fecharegistro; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sugerencia.fecharegistro IS 'Fecha de Registro de la Sugerencia';


--
-- Name: COLUMN sugerencia.idsede; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN sugerencia.idsede IS 'Identificación de la Sede - Relacionado con la TablaSede';


--
-- Name: sugerencia_idsugerencia_seq; Type: SEQUENCE; Schema: public; Owner: fran
--

CREATE SEQUENCE sugerencia_idsugerencia_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.sugerencia_idsugerencia_seq OWNER TO fran;

--
-- Name: sugerencia_idsugerencia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: fran
--

ALTER SEQUENCE sugerencia_idsugerencia_seq OWNED BY sugerencia.idsugerencia;


--
-- Name: sugerencia_idsugerencia_seq; Type: SEQUENCE SET; Schema: public; Owner: fran
--

SELECT pg_catalog.setval('sugerencia_idsugerencia_seq', 4, true);


--
-- Name: tarifa; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE tarifa (
    idtarifa integer NOT NULL,
    idtipopersona character varying(2) NOT NULL,
    monto money,
    idhora integer NOT NULL
);


ALTER TABLE public.tarifa OWNER TO fran;

--
-- Name: COLUMN tarifa.idtarifa; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tarifa.idtarifa IS 'Identificación de la Tarifa';


--
-- Name: COLUMN tarifa.idtipopersona; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tarifa.idtipopersona IS 'Identificación Tipo Persona (Relacionado con Tabla TipoPersona)';


--
-- Name: COLUMN tarifa.monto; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tarifa.monto IS 'Monto en Bs. de la Comida';


--
-- Name: COLUMN tarifa.idhora; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tarifa.idhora IS 'Identifica el tipo de hora (relacionado con tabla hora)';


SET default_with_oids = false;

--
-- Name: tipopersona; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE tipopersona (
    idtipo character varying(2) NOT NULL,
    descripcion character varying(50)
);


ALTER TABLE public.tipopersona OWNER TO fran;

--
-- Name: COLUMN tipopersona.idtipo; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tipopersona.idtipo IS 'Identificación Tipo de Persona';


--
-- Name: COLUMN tipopersona.descripcion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN tipopersona.descripcion IS 'Descripción del Tipo de Persona';


--
-- Name: transaccion; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE transaccion (
    cedula integer NOT NULL,
    fechatransaccion date NOT NULL,
    horatransaccion time without time zone,
    idhora integer NOT NULL,
    autorizado boolean,
    idsede integer,
    idusuario character varying(15)
);


ALTER TABLE public.transaccion OWNER TO fran;

--
-- Name: COLUMN transaccion.cedula; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.cedula IS 'Cedula de la Persona (Relacionado con la Tabla Persona)';


--
-- Name: COLUMN transaccion.fechatransaccion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.fechatransaccion IS 'Fecha de la Transacción (Fecha en que usó el Servicio)';


--
-- Name: COLUMN transaccion.horatransaccion; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.horatransaccion IS 'Hora de la Transacción (Hora en que usó el Servicio)';


--
-- Name: COLUMN transaccion.idhora; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.idhora IS 'Identifica el tipo de hora (relacionado con tabla hora)';


--
-- Name: COLUMN transaccion.autorizado; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.autorizado IS 'Verdadero si se autorizó la transacción';


--
-- Name: COLUMN transaccion.idsede; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.idsede IS 'Identificación de la Sede o Núcleo [Relacionado con la Tabla Sede]';


--
-- Name: COLUMN transaccion.idusuario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN transaccion.idusuario IS 'Identificación del Usuario que registró la Transacción [Relacionado con la Tabla Usuario]';


--
-- Name: usuario; Type: TABLE; Schema: public; Owner: fran; Tablespace: 
--

CREATE TABLE usuario (
    idusuario character varying(15) NOT NULL,
    nombreusuario character varying(50),
    password character varying(15),
    tipousuario character varying(2),
    preguntasecreta character varying(50),
    respuestasecreta character varying(50)
);


ALTER TABLE public.usuario OWNER TO fran;

--
-- Name: COLUMN usuario.idusuario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.idusuario IS 'Identificación del Usuario para inicio de sesión';


--
-- Name: COLUMN usuario.nombreusuario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.nombreusuario IS 'Nombre y Apellidos del Usuario';


--
-- Name: COLUMN usuario.password; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.password IS 'Password de inicio de sesión';


--
-- Name: COLUMN usuario.tipousuario; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.tipousuario IS 'Tipo de Usuario relacionado con la tabla TipoPersona';


--
-- Name: COLUMN usuario.preguntasecreta; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.preguntasecreta IS 'Pregunta Secreta para la recuperacón de la contraseña';


--
-- Name: COLUMN usuario.respuestasecreta; Type: COMMENT; Schema: public; Owner: fran
--

COMMENT ON COLUMN usuario.respuestasecreta IS 'Respuesta Secreta para la recuperación de la contraseña';


--
-- Name: idasociacion; Type: DEFAULT; Schema: public; Owner: fran
--

ALTER TABLE asociacion ALTER COLUMN idasociacion SET DEFAULT nextval('asociacion_idasociacion_seq'::regclass);


--
-- Name: idsugerencia; Type: DEFAULT; Schema: public; Owner: fran
--

ALTER TABLE sugerencia ALTER COLUMN idsugerencia SET DEFAULT nextval('sugerencia_idsugerencia_seq'::regclass);


--
-- Data for Name: asociacion; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO asociacion VALUES (9, 'COOPERATIVA ILUSION, C.A.', 'j452525252', 'JULIO PEREZ', 'juliop@gmail.com', '0212-2518517', '2012-10-01', '2012-10-01', 'A', 1);


--
-- Data for Name: hora; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO hora VALUES (2, '11:00:00', '14:00:00', 'Almuerzo', 1);
INSERT INTO hora VALUES (3, '17:00:00', '20:00:00', 'Cena', 1);
INSERT INTO hora VALUES (1, '07:00:00', '09:00:00', 'Desayuno', 1);


--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: fran
--



--
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO persona VALUES (10114111, 'MONTILLA ROJAS', 'FRANCISCO JOSE', '1969-03-16', '1998-02-01', 'M', 'C', 'PALO VERDE', '02122518517', '02127310762', '04265196999', 'franco01@gmail.com', '04', NULL);
INSERT INTO persona VALUES (3404624, 'GARCIA SULBARAN', 'MARIO JOSE', '1946-11-11', NULL, 'M', 'D', 'LA FLORIDA', '02127310033', '02127310762', '04166221512', 'garciam46@hotmail.com', '05', NULL);
INSERT INTO persona VALUES (3657041, 'ITURRIZA RUIZ', 'VASCO GONZALO', '1947-05-14', NULL, 'M', 'C', 'CAURIMARE', '02129864581', '02122086363', '04166327539', 'iturrizav@hotmail.com', '04', NULL);
INSERT INTO persona VALUES (55555555, 'BARRETO', 'MANUEL', '1953-06-15', NULL, 'M', 'C', 'CUA', '02122512525', '02127310033', '04166356714', 'mbarreto@gmail.com', '06', NULL);
INSERT INTO persona VALUES (11111111, 'GARCIA', 'BELEN', NULL, NULL, 'F', NULL, NULL, NULL, NULL, NULL, NULL, '07', NULL);
INSERT INTO persona VALUES (22222222, 'ANDRADE', 'JULIA', NULL, NULL, 'F', NULL, NULL, NULL, NULL, NULL, NULL, '07', NULL);
INSERT INTO persona VALUES (33333333, 'PEREZ', 'PEDRO', '1969-03-16', '2045-03-15', 'M', 'C', 'ASDASD', '02122721212', '02122721212', '02122721212', 'F@VF.COM', '07', NULL);
INSERT INTO persona VALUES (44444444, 'RAMIREZ', 'PETRA', '2001-02-15', '2001-02-15', 'F', 'C', 'SDFSDF', '02122525252', '02122525252', '02122525252', 'DF@GH.COM', '05', NULL);
INSERT INTO persona VALUES (66666666, 'SAENZ', 'MANUELA', '1945-12-15', '1945-12-15', 'F', 'C', 'SDFSDF', '4564564564', '4564564564', '4564564564', 'SDFS@SDF.COM', '05', NULL);
INSERT INTO persona VALUES (77777777, 'DIAZ', 'ANDREA', '1945-12-15', '1945-12-15', 'F', 'C', 'SDFSDF', '34534534534', '3453453454', '34534534534', 'WSE@QW.COM', '06', NULL);
INSERT INTO persona VALUES (11031905, 'GONZALEZ', 'SUYIN', '1971-10-23', '1986-03-16', 'F', 'C', 'PALO VERDE', '02122518517', '02122086746', '04265195285', 'suyin_gonzalez@hotmail.com', '04', NULL);
INSERT INTO persona VALUES (89898989, 'MONTILLA', 'FRANCISCO', NULL, '2012-10-21', NULL, NULL, 'DFGDFGDFGDFG', NULL, NULL, NULL, NULL, '08', 1);
INSERT INTO persona VALUES (32323232, 'SDFSDFSDF', 'SDFSDF', NULL, '2012-10-21', NULL, NULL, 'SDFSDFSDF', NULL, NULL, NULL, NULL, '08', 1);
INSERT INTO persona VALUES (12121212, 'PEREZ', 'PEDRO', NULL, '2012-10-21', NULL, NULL, 'CHACAO', NULL, NULL, NULL, NULL, '08', 1);


--
-- Data for Name: sede; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO sede VALUES (2, 'Los Cedros');
INSERT INTO sede VALUES (1, 'Edificio Sucre');


--
-- Data for Name: sugerencia; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO sugerencia VALUES (3, 10114111, 'franco01@gmail.com', 'PROBLEMAS DE COMEDOR', '1', '2012-12-03', 1);
INSERT INTO sugerencia VALUES (4, 10114111, 'franco01@gmail.com', 'ERTERTERT', '1', '2012-12-01', 1);


--
-- Data for Name: tarifa; Type: TABLE DATA; Schema: public; Owner: fran
--



--
-- Data for Name: tipopersona; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO tipopersona VALUES ('01', 'Administrador');
INSERT INTO tipopersona VALUES ('02', 'Usuario');
INSERT INTO tipopersona VALUES ('03', 'Supervisor');
INSERT INTO tipopersona VALUES ('04', 'Administrativo');
INSERT INTO tipopersona VALUES ('05', 'Docente');
INSERT INTO tipopersona VALUES ('06', 'Obrero');
INSERT INTO tipopersona VALUES ('07', 'Estudiante');
INSERT INTO tipopersona VALUES ('08', 'Invitado');


--
-- Data for Name: transaccion; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO transaccion VALUES (10114111, '2012-10-09', '17:05:24', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (10114111, '2012-10-22', '07:28:37', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (3657041, '2012-08-30', '08:31:40', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (3657041, '2012-08-30', '12:25:08', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (10114111, '2012-09-14', '08:46:47', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (11111111, '2012-09-15', '08:21:22', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (11111111, '2012-09-15', '18:45:17', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (11031905, '2012-09-15', '08:31:18', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (11031905, '2012-09-15', '19:20:45', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (33333333, '2012-09-15', '11:51:14', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (33333333, '2012-09-15', '19:22:08', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (44444444, '2012-09-15', '11:51:55', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (44444444, '2012-09-15', '19:05:14', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (66666666, '2012-09-15', '08:18:50', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (66666666, '2012-09-15', '12:45:30', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (77777777, '2012-09-15', '12:15:50', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (77777777, '2012-09-15', '07:33:36', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (22222222, '2012-09-15', '17:47:09', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (3404624, '2012-09-14', '18:54:25', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (3657041, '2012-09-14', '18:54:36', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (10114111, '2012-09-14', '17:48:56', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (10114111, '2012-09-14', '11:47:52', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (3404624, '2012-08-30', '08:51:10', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (3404624, '2012-08-30', '12:56:58', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (55555555, '2012-08-30', '08:57:05', 1, false, NULL, NULL);
INSERT INTO transaccion VALUES (55555555, '2012-08-30', '12:57:20', 2, false, NULL, NULL);
INSERT INTO transaccion VALUES (55555555, '2012-08-30', '18:45:30', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (10114111, '2012-09-30', '19:50:43', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (10114111, '2012-10-08', '19:14:09', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (11111111, '2012-10-08', '19:14:18', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (33333333, '2012-10-08', '19:14:27', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (22222222, '2012-10-08', '19:15:14', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (55555555, '2012-10-08', '19:42:02', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (66666666, '2012-10-08', '19:42:08', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (77777777, '2012-10-08', '19:42:14', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (3404624, '2012-10-08', '19:42:35', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (3657041, '2012-10-08', '19:42:42', 3, false, NULL, NULL);
INSERT INTO transaccion VALUES (11031905, '2012-10-08', '19:43:45', 3, false, NULL, NULL);


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: fran
--

INSERT INTO usuario VALUES ('pedro', 'Pedro Perez', 'perez', '08', 'cualquiera', 'cualquiera');
INSERT INTO usuario VALUES ('admin', 'Administrador', 'admin', '01', 'pregunta', 'respuesta');
INSERT INTO usuario VALUES ('manuel', 'Manuel Rodriguez', '12345', '02', 'pelicula favorita', 'matrix');


--
-- Name: asociacion_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY asociacion
    ADD CONSTRAINT asociacion_pkey PRIMARY KEY (idasociacion);


--
-- Name: hora_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY hora
    ADD CONSTRAINT hora_pkey PRIMARY KEY (idhora, idsede);


--
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (idmenu, fecha, idsede);


--
-- Name: persona_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_pkey PRIMARY KEY (cedula);


--
-- Name: sede_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY sede
    ADD CONSTRAINT sede_pkey PRIMARY KEY (idsede);


--
-- Name: tarifa_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY tarifa
    ADD CONSTRAINT tarifa_pkey PRIMARY KEY (idtarifa);


--
-- Name: tipopersona_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY tipopersona
    ADD CONSTRAINT tipopersona_pkey PRIMARY KEY (idtipo);


--
-- Name: transaccion_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY transaccion
    ADD CONSTRAINT transaccion_pkey PRIMARY KEY (cedula, fechatransaccion, idhora);


--
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: fran; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (idusuario);


--
-- Name: asociacion_idsede_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY asociacion
    ADD CONSTRAINT asociacion_idsede_fkey FOREIGN KEY (idsede) REFERENCES sede(idsede);


--
-- Name: hora_idsede_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY hora
    ADD CONSTRAINT hora_idsede_fkey FOREIGN KEY (idsede) REFERENCES sede(idsede);


--
-- Name: menu_idsede_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_idsede_fkey FOREIGN KEY (idsede) REFERENCES sede(idsede);


--
-- Name: persona_idsede_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_idsede_fkey FOREIGN KEY (idsede) REFERENCES sede(idsede);


--
-- Name: persona_tipopersona_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_tipopersona_fkey FOREIGN KEY (tipopersona) REFERENCES tipopersona(idtipo);


--
-- Name: tarifa_idtipopersona_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY tarifa
    ADD CONSTRAINT tarifa_idtipopersona_fkey FOREIGN KEY (idtipopersona) REFERENCES tipopersona(idtipo);


--
-- Name: transaccion_idsede_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY transaccion
    ADD CONSTRAINT transaccion_idsede_fkey FOREIGN KEY (idsede) REFERENCES sede(idsede);


--
-- Name: transaccion_idusuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY transaccion
    ADD CONSTRAINT transaccion_idusuario_fkey FOREIGN KEY (idusuario) REFERENCES usuario(idusuario);


--
-- Name: usuario_tipousuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fran
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_tipousuario_fkey FOREIGN KEY (tipousuario) REFERENCES tipopersona(idtipo);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
GRANT ALL ON SCHEMA public TO fran;


--
-- PostgreSQL database dump complete
--

