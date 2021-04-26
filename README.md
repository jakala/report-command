# report command
Se trata de una utilidad de consola para generar un informe con unos datos, por una parte con origen remoto (una url)
y por otra parte, de archivos xml.
## Requisitos
 - php 8.0
 - composer
## instalación
 - descomprimir el archivo .zip
 - instalar vendors con `composer install`
## Uso
```
./console isalud:import [-f|--file FILE] [--] <output-file>
```
Este comando requiere un parametro obligatorio:
- <output-file>: es el nombre del archivo destino tipo csv en el que se vuelca la información.

tambien tiene uno/varios parametros opcionales:
- [-f | --file FILE]: hace referencia al archivo o archivos xml de tipo cliente para mezclarlos con los
datos obtenidos de la url.
  
## Errores controlados