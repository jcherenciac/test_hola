# Proyecto "hola_test"

## Requisitos
    - php 7.2
    - mysql
    - Web server (Apache recomendado)
    - phpcs
    - phpcs
    - phpcbf
## Instalación 
Instalación de vendors
```
composer install
```
Creación de la BD:
```
doctrine:database:create
```
Generación de la estructura de BD:
```
doctrine:schema:create
```
## Configuración
Modificar en  `app/config/parameters.yml` los siguientes datos en función  de los la configuración de la BD.
```
parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: test_hola
    database_user: test_hola
    database_password: hola
```
## Carga de datos
    php bin/console doctrine:fixtures:load
##  Clean code

Ejecutar limpieza de código (Estandar: PRS2) 
```bash
phpcbf --standard=PSR2
```
Ver resultado Code Snifer (Estandar: PRS2) 
```bash
phpcs --standard=PSR2 ./src/AppBundle/
```
## Herramientas de prueba
En el proyecto se ha incluido un archivo con la  
[colección POSTMAN](./HOLA_TEST_API.postman_collection.json) con la que se realizaron las pruebas de la API REST.
   