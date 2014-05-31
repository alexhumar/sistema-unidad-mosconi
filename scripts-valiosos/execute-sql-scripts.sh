#!/bin/bash

#ejecuta cada script de carga de la base de datos
echo "Pidiendo pass para el usuario root para cargar diagnosticos (esto tarda un poco)...";
mysql -u root -p -D unidad_mosconi < sql-scripts/diagnosticos.sql
echo "Pidiendo pass para el usuario root para cargar especialidades...";
mysql -u root -p -D unidad_mosconi < sql-scripts/especialidades.sql
echo "Pidiendo pass para el usuario root para cargar paises...";
mysql -u root -p -D unidad_mosconi < sql-scripts/paises.sql
echo "Pidiendo pass para el usuario root para cargar partidos...";
mysql -u root -p -D unidad_mosconi < sql-scripts/partidos.sql
echo "Pidiendo pass para el usuario root para cargar localidades...";
mysql -u root -p -D unidad_mosconi < sql-scripts/localidades.sql
echo "Pidiendo pass para el usuario root para cargar roles...";
mysql -u root -p -D unidad_mosconi < sql-scripts/roles.sql
echo "Pidiendo pass para el usuario root para cargar tipos de documento...";
mysql -u root -p -D unidad_mosconi < sql-scripts/tipos-documentos.sql
echo "Pidiendo pass para el usuario root para cargar vacunas...";
mysql -u root -p -D unidad_mosconi < sql-scripts/vacunas.sql
