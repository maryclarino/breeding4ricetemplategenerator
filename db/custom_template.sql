-- Table: custom_template

-- DROP TABLE custom_template;

CREATE TABLE custom_template
(
  template_id integer NOT NULL DEFAULT nextval('template_seq'::regclass),
  username character varying(20),
  canvas_height integer,
  canvas_width integer,
  textfield_num integer,
  textfield_h character varying(200),
  textfield_w character varying(200),
  attribute_textfield character varying(1000),
  textfield_x character varying(200) DEFAULT 0,
  textfield_y character varying(200) DEFAULT 0,
  img_num integer,
  img_h character varying(200),
  img_w character varying(200),
  img_x character varying(200) DEFAULT 0,
  img_y character varying(200) DEFAULT 0,
  img_name character varying(1000),
  qrcode_h character varying(200),
  qrcode_w character varying(200),
  qrcode_x integer,
  qrcode_y integer,
  qrcode_text character varying(1000),
  qrcode_attrib character varying(1000),
  barcode_text character varying(1000),
  barcode_x character varying(200),
  barcode_y character varying(200),
  barcode_num integer,
  barcode_attrib character varying(1000),
  barcode_h character varying(200),
  barcode_w character varying(200),
  font_size character varying(200),
  font_family character varying(500),
  CONSTRAINT custom_template_pkey PRIMARY KEY (template_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE custom_template
  OWNER TO postgres;
