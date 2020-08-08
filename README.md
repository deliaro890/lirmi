Prueba Lirmi

Este proyecto es una prueba técnica en donde se utilizó el framework laravel 7 y postgres como database. Consiste en mostrar una tabla con datos de profesores, dicha información fue consumida de una API, y organizada en forma de tabla. Cada profesor es susceptible a ser registrado en la base de datos del proyecto en cuestión.

La segunda vista es una tabla con los profesores registrados en la base de datos, donde cada uno puede ser eliminado de dicha tabla.


Instalación

Requisitos:

- php versión >= 7
- git
- composer
- postgres

Pasos:

1. Para la base de datos, en postgres:
    - Crear un usuario con password: 
        # CREATE ROLE newuser WITH LOGIN PASSWORD 'password';
    - A dicho usuario darle permisos para crear una base de datos:
        # ALTER ROLE newuser CREATEDB;
    - Crear una database con dicho usuario
        # CREATE DATABASE colegio WITH OWNER  newuser;
    - Reiniciar postgres

2. Descargar el repositorio de github
3. Entrar a la carpeta donde se ubico el proyecto
4. Crear el .env:
    $ cp .env.example .env

5. Editar el .env, solo en la parte de la DB. Las credenciales de la DB son: nombre de la base de datos (DB_DATABASE), usuario (DB_USERNAME) y contraseña (DB_PASSWORD), dichas credenciales pueden cambiar deacuerdo a las que se hayan puesto en el paso (1):

        DB_CONNECTION=pgsql
        DB_HOST=127.0.0.1
        DB_PORT=5432
        DB_DATABASE=colegio
        DB_USERNAME=newuser
        DB_PASSWORD=password


6. Dar permisos a la carpeta storage:
    $ sudo chmod -R 777 storage/

7. Instalar la carpeta vendor:
    $ composer install

8. Generar la key:
    $ php artisan key:generate

9. Hacer la migraciones:
    $ php artisan migrate

10. Probar en el servidor de desarrollo, correrá en el localhost, por default en el puerto 8000:
    $ php artisan serve





  


