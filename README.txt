# optiplace
Actuellement, notre version de Excel sur Windows à l'IUT date de 2010.
Dans le fichier upload_and_convert.php, à la ligne 34, on utilise donc Excel2007, sa structure étant la même que la version 2010.
De même, l'extention par défaut est .xlsx, à changer dans le même fichier si besoin.

Pour importer les fichiers, il est nécessaire d'avoir les droits. Par exemple, il n'est pas possible d'importer des fichiers sur infoweb.

Lorsqu'on utilise le plug-in sweet alert avec jQuery, il est nécessaire d'inclure le fichier sweet-alert.js avant le fichier jQuery dans le header.
Comme la fonction alert de Javascript, swal permet d'afficher des messages. Mais depuis un fichier PHP, il n'est pas possible d'appeler une fonction swal comme on le ferait avec une fonction alert. On doit utiliser jQuery pour déclencher un événement qui appelle une fonction Javascript effectuant swal.
