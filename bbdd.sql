CREATE DATABASE IF NOT EXISTS api_angular;
use api_angular;

CREATE TABLE productos(
	id int(255) auto_increment not null,
	nombre varchar (255),
	descripcion text,
	precio (255),
	imagen (255),
	CONSTRAINT pk_productos PRIMARY KEY (ID) 
);
