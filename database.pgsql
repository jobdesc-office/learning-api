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
    menuicon character varying(100),
    menuroute character varying(100),
    menucolor character varying(100),
    menuseq integer,
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
    typemasterid integer,
    typedesc text,
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
    userfcmtoken text,
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
    userdttypeid bigint NOT NULL,
    userdtbpid bigint NOT NULL,
    userdtbranchnm character varying(100),
    userdtreferalcode character varying(50),
    userdtrelationid bigint,
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
-- Name: vtschedule; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.vtschedule (
    scheid bigint NOT NULL,
    schenm character varying(50),
    schestartdate date,
    scheenddate date,
    schestarttime time(0) without time zone,
    scheendtime time(0) without time zone,
    schetypeid integer,
    scheactdate date,
    schetowardid integer,
    schebpid integer,
    schereftypeid integer,
    scherefid integer,
    scheallday boolean,
    scheloc text,
    scheprivate boolean,
    scheonline boolean,
    schetz text,
    scheremind integer,
    schedesc text,
    scheonlink text,
    createdby bigint,
    createddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updatedby bigint,
    updateddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    isactive boolean DEFAULT true NOT NULL
);


ALTER TABLE public.vtschedule OWNER TO hsm01_postgres;

--
-- Name: vtschedule_scheid_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.vtschedule_scheid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vtschedule_scheid_seq OWNER TO hsm01_postgres;

--
-- Name: vtschedule_scheid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.vtschedule_scheid_seq OWNED BY public.vtschedule.scheid;


--
-- Name: vtscheduleguest; Type: TABLE; Schema: public; Owner: hsm01_postgres
--

CREATE TABLE public.vtscheduleguest (
    scheguestid bigint NOT NULL,
    scheid integer,
    scheuserid integer,
    schebpid integer,
    createdby bigint,
    createddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updatedby bigint,
    updateddate timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    isactive boolean DEFAULT true NOT NULL,
    schepermisid integer[]
);


ALTER TABLE public.vtscheduleguest OWNER TO hsm01_postgres;

--
-- Name: vtscheduleguest_scheguestid_seq; Type: SEQUENCE; Schema: public; Owner: hsm01_postgres
--

CREATE SEQUENCE public.vtscheduleguest_scheguestid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vtscheduleguest_scheguestid_seq OWNER TO hsm01_postgres;

--
-- Name: vtscheduleguest_scheguestid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: hsm01_postgres
--

ALTER SEQUENCE public.vtscheduleguest_scheguestid_seq OWNED BY public.vtscheduleguest.scheguestid;


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
-- Name: vtschedule scheid; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.vtschedule ALTER COLUMN scheid SET DEFAULT nextval('public.vtschedule_scheid_seq'::regclass);


--
-- Name: vtscheduleguest scheguestid; Type: DEFAULT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.vtscheduleguest ALTER COLUMN scheguestid SET DEFAULT nextval('public.vtscheduleguest_scheguestid_seq'::regclass);


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
29	2022_03_10_045810_create_msuser_table	1
30	2022_03_10_052651_create_msuserdt_table	1
31	2022_03_10_055254_create_mstype_table	1
32	2022_03_10_061238_create_msbusinesspartner_table	1
33	2022_03_11_135942_create_msmenu_table	1
34	2022_03_30_040856_create_vtschedule_table	1
35	2022_03_30_043658_create_vtscheduleguest_table	1
\.


--
-- Data for Name: msbusinesspartner; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msbusinesspartner (bpid, bpname, bptypeid, bppicname, bpemail, bpphone, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	Marvin-Donnelly	7	Mr. Cleveland Armstrong	emilio98@hotmail.com	+1 (262) 755-1183	1	2022-04-12 08:40:22	1	2022-04-12 08:40:22	t
2	Schroeder-Casper	7	Brice Crooks	emmanuel.treutel@hoppe.org	+1-678-933-3295	1	2022-04-12 08:40:22	1	2022-04-12 08:40:22	t
3	Champlin-Hill	7	Aubrey Keebler	assunta61@wisozk.biz	+1-603-609-1807	1	2022-04-12 08:40:22	1	2022-04-12 08:40:22	t
4	Schinner-Denesik	7	Reymundo Gutkowski DVM	bernhard47@yahoo.com	(339) 636-0552	1	2022-04-12 08:40:22	1	2022-04-12 08:40:22	t
5	Ernser-Turner	7	Martine Williamson	emmy.torp@hotmail.com	+1 (364) 642-5797	1	2022-04-12 08:40:22	1	2022-04-12 08:40:22	t
\.


--
-- Data for Name: msmenu; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msmenu (menuid, masterid, menutypeid, menunm, menuicon, menuroute, menucolor, menuseq, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
\.


--
-- Data for Name: mstype; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.mstype (typeid, typecd, typename, typeseq, typemasterid, typedesc, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	role	Role	\N	\N	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
2	rolespa	Super Admin	\N	1	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
3	bptype	Tipe Business Partner	\N	\N	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
4	\N	Otomotif	\N	3	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
5	\N	Manufaktur	\N	3	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
6	mntp	Menu Type	\N	\N	\N	\N	2022-04-12 08:40:21	\N	2022-04-12 08:40:21	t
7	\N	Web	\N	6	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
8	\N	Apps	\N	6	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
9	schedule	Schedule	\N	\N	\N	\N	2022-04-12 08:40:21	\N	2022-04-12 08:40:21	t
10	\N	Task	\N	9	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
11	\N	Event	\N	9	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
12	\N	Reminder	\N	9	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
13	scp	Schedule Permission	\N	\N	\N	\N	2022-04-12 08:40:21	\N	2022-04-12 08:40:21	t
14	\N	Read Only	\N	13	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
15	\N	Add Member	\N	13	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
16	\N	Share Link	\N	13	\N	1	2022-04-12 08:40:21	1	2022-04-12 08:40:21	t
\.


--
-- Data for Name: msuser; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msuser (userid, username, userpassword, userfullname, useremail, userphone, userdeviceid, userfcmtoken, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	developer	$2y$10$YyD3kTIeMUQkMzITqaPC0Ov0n8w41xz3kkeDFZENPuGQbfBTFuNKi	Waino Kirlin	kmaggio@feeney.info	+1 (260) 505-2153	\N	\N	1	2022-04-12 08:40:22	1	2022-04-12 08:40:22	t
2	Novan	$2y$10$b7SWdN9akCKQ/rkVKCYqguVllWrEAFCBe7iXZiQ2tmWonvNoOIFMi	Novan Andre Andriansyah Putra	novanandre41@gmail.com	+628988803500	\N	\N	1	2022-04-12 09:34:50	1	2022-04-14 07:00:32	t
\.


--
-- Data for Name: msuserdt; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.msuserdt (userdtid, userid, userdttypeid, userdtbpid, userdtbranchnm, userdtreferalcode, userdtrelationid, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
1	1	2	2	\N	\N	\N	1	2022-04-12 08:40:23	1	2022-04-12 08:40:23	t
2	2	2	2	\N	\N	\N	\N	2022-04-12 09:34:50	\N	2022-04-14 06:36:02	t
\.


--
-- Data for Name: vtschedule; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.vtschedule (scheid, schenm, schestartdate, scheenddate, schestarttime, scheendtime, schetypeid, scheactdate, schetowardid, schebpid, schereftypeid, scherefid, scheallday, scheloc, scheprivate, scheonline, schetz, scheremind, schedesc, scheonlink, createdby, createddate, updatedby, updateddate, isactive) FROM stdin;
\.


--
-- Data for Name: vtscheduleguest; Type: TABLE DATA; Schema: public; Owner: hsm01_postgres
--

COPY public.vtscheduleguest (scheguestid, scheid, scheuserid, schebpid, createdby, createddate, updatedby, updateddate, isactive, schepermisid) FROM stdin;
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 35, true);


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

SELECT pg_catalog.setval('public.mstype_typeid_seq', 16, true);


--
-- Name: msuser_userid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.msuser_userid_seq', 6, true);


--
-- Name: msuserdt_userdtid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.msuserdt_userdtid_seq', 8, true);


--
-- Name: vtschedule_scheid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.vtschedule_scheid_seq', 1, false);


--
-- Name: vtscheduleguest_scheguestid_seq; Type: SEQUENCE SET; Schema: public; Owner: hsm01_postgres
--

SELECT pg_catalog.setval('public.vtscheduleguest_scheguestid_seq', 1, false);


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
-- Name: vtschedule vtschedule_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.vtschedule
    ADD CONSTRAINT vtschedule_pkey PRIMARY KEY (scheid);


--
-- Name: vtscheduleguest vtscheduleguest_pkey; Type: CONSTRAINT; Schema: public; Owner: hsm01_postgres
--

ALTER TABLE ONLY public.vtscheduleguest
    ADD CONSTRAINT vtscheduleguest_pkey PRIMARY KEY (scheguestid);


--
-- PostgreSQL database dump complete
--

