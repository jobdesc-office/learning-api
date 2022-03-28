CREATE TABLE public.msuser
(
    userid serial NOT NULL,
    username character varying(50) COLLATE pg_catalog."default" NOT NULL,
    userpassword text COLLATE pg_catalog."default" NOT NULL,
    userfullname character varying(100) COLLATE pg_catalog."default" NOT NULL,
    useremail character varying(100) COLLATE pg_catalog."default",
    userphone character varying(100) COLLATE pg_catalog."default",
    userdeviceid character varying(50) COLLATE pg_catalog."default",
    userfcmtoken text COLLATE pg_catalog."default",
    createdby bigint,
    createddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updatedby bigint,
    updateddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    isactive boolean NOT NULL DEFAULT true,
    CONSTRAINT msuser_pkey PRIMARY KEY (userid)
)

CREATE TABLE public.msuserdt
(
    userdtid serial NOT NULL,
    userid bigint NOT NULL,
    userdttypeid bigint NOT NULL,
    userdtbpid bigint NOT NULL,
    userdtbranchnm character varying(100) COLLATE pg_catalog."default",
    userdtreferalcode character varying(50) COLLATE pg_catalog."default",
    userdtrelationid bigint,
    createdby bigint,
    createddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updatedby bigint,
    updateddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    isactive boolean NOT NULL DEFAULT true,
    CONSTRAINT msuserdt_pkey PRIMARY KEY (userdtid)
)


CREATE TABLE public.msmenu
(
    menuid serial,
    masterid bigint NOT NULL,
    menutypeid bigint NOT NULL,
    menunm character varying(100) COLLATE pg_catalog."default" NOT NULL,
    menuicon character varying(100) COLLATE pg_catalog."default",
    menuroute character varying(100) COLLATE pg_catalog."default",
    menucolor character varying(100) COLLATE pg_catalog."default",
    menuseq integer,
    createdby bigint,
    createddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updatedby bigint,
    updateddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    isactive boolean NOT NULL DEFAULT true,
    CONSTRAINT msmenu_pkey PRIMARY KEY (menuid)
)

CREATE TABLE public.mstype
(
    typeid serial NOT NULL,
    typecd character varying(10) COLLATE pg_catalog."default",
    typename character varying(100) COLLATE pg_catalog."default" NOT NULL,
    typeseq integer,
    typemasterid integer,
    typedesc text COLLATE pg_catalog."default",
    createdby bigint,
    createddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updatedby bigint,
    updateddate timestamp(0) without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    isactive boolean NOT NULL DEFAULT true,
    CONSTRAINT mstype_pkey PRIMARY KEY (typeid)
)