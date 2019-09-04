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
## Entorno
Para la configuración en local se ha utilizado un servidor apache y para su correcto funcionamiento se han configurado:
### Hosts
Añadido a `/etc/hosts`
```
 127.0.1.1  testhola.local
```
###VirtualHost
Se ha creado y activado (`a2ensite testhola.local.conf`)
el siguiente virtualhost:
```
<VirtualHost *:80>
    ServerName testhola.local
    ServerAlias testhola.local

    DocumentRoot /var/www/test_hola/web
    <Directory /var/www/test_hola/web>
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeeScript assets
    # <Directory /var/www/test_hola>
    #     Options FollowSymlinks
    # </Directory>

    ErrorLog /var/log/apache2/test_hola_error.log
    CustomLog /var/log/apache2/test_hola_access.log combined
</VirtualHost>
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
Los Usuarios generados automáticamente son los siguientes:
```
    Admin: 1234
    Page1: 1234
    Page2:1234
```
```
    php bin/console doctrine:fixtures:load
```
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
[colección ](./HOLA_TEST_API.postman_collection.json) [POSTMAN](https://www.getpostman.com/) con la que se realizaron las pruebas de la API REST.
   