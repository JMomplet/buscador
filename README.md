Buscador utilizando Solr y Phalcon
==================================

Instrucciones de instalación:
- En caso de no tener instalado el Java Development Kit, descargarlo desde [aquí](http://www.oracle.com/technetwork/es/java/javase/downloads/jdk7-downloads-1880260.html)
- Descargar [Solr](http://www.apache.org/dyn/closer.cgi/lucene/solr/4.5.0) y descomprimirlo en una ruta accesible como C:/solr
- Acceder al archivo 'buscador.rar' situado en este proyecto en 'extras/solr/' y descomprimirlo en la carpeta donde hayamos instalado Solr, de manera que el archivo start.jar se situe así: <carpeta solr>/buscador/start.jar
- Importar la base de datos en MySQL con el archivo situado en 'extras/mysql/'
- Acceder a los archivos data-config.xml detro de /buscador/solr/equipos/conf/ y /buscador/solr/partidos/conf/ y cambiar los parametros de la conexión a la base de datos necesarios
- Descargar e installar [Phalcon](http://phalconphp.com/en/download) siguiendo las instrucciones segun el sistema operativo.
- Habilitar el modulo mod_rewrite de Apache. Para ello habrá que acceder al archivo httpd.conf de nuestra instalación de Apache y descomentar la linea LoadModule rewrite_module modules/mod_rewrite.so
- Situar el contenido (exceptuando la carpeta extras) en la raiz del servidor web o crear un host virtual que apunte a donde hayas descomprimido el proyecto
- Acceder a app/config/config.php para cambiar los datos de conexión a la base de datos

Tras todo esto, debería estar listo.

Poner en marcha Solr
--------------------
Para poner en marcha el servicio de Solr, habrá que acceder por la consola de comandos a <carpeta de solr>/buscador y escribir el siguiente comando:
    java -jar start.jar
Una vez iniciado podremos acceder al gestor web desde http://localhost:8983/solr

Generar partidos
----------------
La base de datos viene con datos de partidos para las 2 ligas incluidas, pero para generar (y sustituir) todos los partidos de la temporada habrá que acceder a la url <host>/generarpartidos?liga=1 (siendo 1 la española y 2 la inglesa)
