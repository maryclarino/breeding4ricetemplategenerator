-- Table: signup

-- DROP TABLE signup;

CREATE TABLE signup
(
  fname character varying(20),
  mname character varying(20),
  lname character varying(20),
  username character varying(20),
  password character varying(3000),
  eadd character varying(50),
  contact_num character varying(12)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE signup
  OWNER TO postgres;
