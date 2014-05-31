#crea el usuario admin
php ../app/console fos:user:create admin admin@admin.com admin

#le asigna los roles ROLE_ADMIN y ROLE_ADMINISTRADOR al usuario admin
php ../app/console fos:user:promote admin ROLE_ADMIN
php ../app/console fos:user:promote admin ROLE_ADMINISTRADOR
