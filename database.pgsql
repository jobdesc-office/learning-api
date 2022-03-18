--
-- PostgreSQL database dump
--

-- Dumped from database version 12.9 (Ubuntu 12.9-0ubuntu0.20.04.1)
-- Dumped by pg_dump version 14.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: migrations; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO hsm01_postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO hsm01_postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: msbusinesspartner; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.msbusinesspartner (
    bpid bigint NOT NULL,
    bpname character varying(100) NOT NULL,
    bptypeid bigint NOT NULL,
    bppicname character varying(255),
    bpemail character varying(255),
    bpphone character varying(255),
    createdby bigint,
    createddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updatedby bigint,
    updateddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    isactive boolean DEFAULT true NOT NULL
);


ALTER TABLE public.msbusinesspartner OWNER TO hsm01_postgres;

--
-- Name: msbusinesspartner_bpid_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.msbusinesspartner_bpid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.msbusinesspartner_bpid_seq OWNER TO hsm01_postgres;

--
-- Name: msbusinesspartner_bpid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.msbusinesspartner_bpid_seq OWNED BY public.msbusinesspartner.bpid;


--
-- Name: msmenu; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.msmenu (
    menuid bigint NOT NULL,
    masterid bigint,
    menutypeid bigint NOT NULL,
    menunm character varying(100) NOT NULL,
    icon character varying(100),
    route character varying(100),
    color character varying(100),
    seq integer,
    createdby bigint,
    createddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updatedby bigint,
    updateddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    isactive boolean DEFAULT true NOT NULL
);


ALTER TABLE public.msmenu OWNER TO hsm01_postgres;

--
-- Name: msmenu_menuid_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.msmenu_menuid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.msmenu_menuid_seq OWNER TO hsm01_postgres;

--
-- Name: msmenu_menuid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.msmenu_menuid_seq OWNED BY public.msmenu.menuid;


--
-- Name: mstype; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.mstype (
    typeid bigint NOT NULL,
    typecd character varying(10),
    typename character varying(100) NOT NULL,
    typeseq integer,
    masterid integer,
    description text,
    createdby bigint,
    createddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updatedby bigint,
    updateddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    isactive boolean DEFAULT true NOT NULL
);


ALTER TABLE public.mstype OWNER TO hsm01_postgres;

--
-- Name: mstype_typeid_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.mstype_typeid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mstype_typeid_seq OWNER TO hsm01_postgres;

--
-- Name: mstype_typeid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.mstype_typeid_seq OWNED BY public.mstype.typeid;


--
-- Name: msuser; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.msuser (
    userid bigint NOT NULL,
    username character varying(50) NOT NULL,
    userpassword text NOT NULL,
    userfullname character varying(100) NOT NULL,
    useremail character varying(100),
    userphone character varying(100),
    userdeviceid character varying(50),
    createdby bigint,
    createddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updatedby bigint,
    updateddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    isactive boolean DEFAULT true NOT NULL
);


ALTER TABLE public.msuser OWNER TO hsm01_postgres;

--
-- Name: msuser_userid_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.msuser_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.msuser_userid_seq OWNER TO hsm01_postgres;

--
-- Name: msuser_userid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.msuser_userid_seq OWNED BY public.msuser.userid;


--
-- Name: msuserdt; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.msuserdt (
    userdtid bigint NOT NULL,
    userid bigint NOT NULL,
    usertypeid bigint NOT NULL,
    bpid bigint NOT NULL,
    createdby bigint,
    createddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updatedby bigint,
    updateddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    isactive boolean DEFAULT true NOT NULL
);


ALTER TABLE public.msuserdt OWNER TO hsm01_postgres;

--
-- Name: msuserdt_userdtid_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.msuserdt_userdtid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.msuserdt_userdtid_seq OWNER TO hsm01_postgres;

--
-- Name: msuserdt_userdtid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.msuserdt_userdtid_seq OWNED BY public.msuserdt.userdtid;


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: msbusinesspartner bpid; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msbusinesspartner ALTER COLUMN bpid SET DEFAULT nextval('public.msbusinesspartner_bpid_seq'::regclass);


--
-- Name: msmenu menuid; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msmenu ALTER COLUMN menuid SET DEFAULT nextval('public.msmenu_menuid_seq'::regclass);


--
-- Name: mstype typeid; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.mstype ALTER COLUMN typeid SET DEFAULT nextval('public.mstype_typeid_seq'::regclass);


--
-- Name: msuser userid; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msuser ALTER COLUMN userid SET DEFAULT nextval('public.msuser_userid_seq'::regclass);


--
-- Name: msuserdt userdtid; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msuserdt ALTER COLUMN userdtid SET DEFAULT nextval('public.msuserdt_userdtid_seq'::regclass);


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2022_03_10_045810_create_msuser_table	1
2	2022_03_10_052651_create_msuserdt_table	1
3	2022_03_10_055254_create_mstype_table	1
4	2022_03_10_061238_create_msbusinesspartner_table	1
5	2022_03_11_135942_create_msmenu_table	1
\.


--
-- Data for Name: msbusinesspartner; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msbusinesspartner (bpid, bpname, bptypeid, bppicname, bpemail, bpphone, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	O'Kon Inc	5	Dr. Murphy Roberts	hagenes.kevin@hotmail.com	+1 (361) 205-5354	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
2	Beatty-Smitham	5	Mrs. Charlene Donnelly Jr.	kris.cornelius@hotmail.com	712-708-4537	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
3	Friesen PLC	5	Dr. Morgan DuBuque	chauncey52@yahoo.com	727-874-9482	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
4	Collier PLC	5	Laura Little IV	pgreenholt@yahoo.com	(219) 649-0178	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
5	Lubowitz, Upton and Kiehn	5	Haven Kozey	lessie.weber@hotmail.com	(325) 501-8767	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
\.


--
-- Data for Name: msmenu; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msmenu (menuid, masterid, menutypeid, menunm, icon, route, color, seq, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
\.


--
-- Data for Name: mstype; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.mstype (typeid, typecd, typename, typeseq, masterid, description, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	role	Role	\N	\N	\N	1	2022-03-18 02:42:27	1	2022-03-18 02:42:27	t
2	rolespa	Super Admin	\N	1	\N	1	2022-03-18 02:42:27	1	2022-03-18 02:42:27	t
3	bptype	Tipe Business Partner	\N	\N	\N	1	2022-03-18 02:42:27	1	2022-03-18 02:42:27	t
4	\N	Otomotif	\N	3	\N	1	2022-03-18 02:42:27	1	2022-03-18 02:42:27	t
5	\N	Manufaktur	\N	3	\N	1	2022-03-18 02:42:27	1	2022-03-18 02:42:27	t
6	MNTP	Menu Type	\N	\N	\N	\N	2022-03-18 02:42:28	\N	2022-03-18 02:42:28	t
7	\N	Web	\N	6	\N	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
8	\N	Apps	\N	6	\N	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
\.


--
-- Data for Name: msuser; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msuser (userid, username, userpassword, userfullname, useremail, userphone, userdeviceid, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	developer	$2y$10$a3onPpKKBO8ZdYiszKQwU.J3hLLmvsVqB4uRNxWZBRiCggVlStjv2	Meaghan Swaniawski	klein.peter@yahoo.com	1-479-361-3972	\N	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
\.


--
-- Data for Name: msuserdt; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msuserdt (userdtid, userid, usertypeid, bpid, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	1	2	5	1	2022-03-18 02:42:28	1	2022-03-18 02:42:28	t
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 5, true);


--
-- Name: msbusinesspartner_bpid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.msbusinesspartner_bpid_seq', 5, true);


--
-- Name: msmenu_menuid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.msmenu_menuid_seq', 1, false);


--
-- Name: mstype_typeid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.mstype_typeid_seq', 8, true);


--
-- Name: msuser_userid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.msuser_userid_seq', 1, true);


--
-- Name: msuserdt_userdtid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.msuserdt_userdtid_seq', 1, true);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: msbusinesspartner msbusinesspartner_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msbusinesspartner
    ADD CONSTRAINT msbusinesspartner_pkey PRIMARY KEY (bpid);


--
-- Name: msmenu msmenu_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msmenu
    ADD CONSTRAINT msmenu_pkey PRIMARY KEY (menuid);


--
-- Name: mstype mstype_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.mstype
    ADD CONSTRAINT mstype_pkey PRIMARY KEY (typeid);


--
-- Name: msuser msuser_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msuser
    ADD CONSTRAINT msuser_pkey PRIMARY KEY (userid);


--
-- Name: msuserdt msuserdt_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.msuserdt
    ADD CONSTRAINT msuserdt_pkey PRIMARY KEY (userdtid);


--
-- PostgreSQL database dump complete
--

