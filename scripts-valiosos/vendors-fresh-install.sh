#correr sin sudo. NOTA: si se produce algun inconveniente con algun bundle, borrar toda la carpeta vendor y el archivo composer.lock y ejecutar php composer.phar install.


export GIT_DISCOVERY_ACROSS_FILESYSTEM=1 #esto es porque el /home lo tengo en otra particion

#elimina toda la carpeta vendor y el archivo composer.lock
rm -rf ../vendor
rm ../composer.lock

php ../composer.phar install
