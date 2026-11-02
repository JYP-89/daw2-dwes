/*¿Qué datos metemos dentro?*/ 
INSERT INTO categorias (nombre) VALUES ('Muebles');
INSERT INTO categorias (nombre) VALUES ('Portatiles');
INSERT INTO categorias (nombre) VALUES ('Telefonos');
INSERT INTO categorias (nombre) VALUES ('Adornos');
INSERT INTO categorias (nombre) VALUES ('Libros');

/* Los artículos*/

INSERT INTO productos (nombre, precio, id_categoria)
VALUES ('Mesa de escritorio', 120.00, 1);

INSERT INTO productos (nombre, precio, id_categoria)
VALUES ('Portátil Lenovo', 750.00, 2);

INSERT INTO productos (nombre, precio, id_categoria)
VALUES ('Teléfono Samsung', 450.00, 3);

INSERT INTO productos (nombre, precio, id_categoria)
VALUES ('Jarrón decorativo', 35.50, 4);

INSERT INTO productos (nombre, precio, id_categoria)
VALUES ('El Quijote', 25.00, 5);

/*Esto se lee como lo haría el worckbench de clase de BBDD*/