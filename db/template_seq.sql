-- Sequence: template_seq

-- DROP SEQUENCE template_seq;

CREATE SEQUENCE template_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 244
  CACHE 1;
ALTER TABLE template_seq
  OWNER TO postgres;
