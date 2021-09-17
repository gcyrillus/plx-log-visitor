# visitor
squelette d'un plugin laissant l'accés à une page aprés connexion.

installé le plugin via l'administration 
un champ supplementaire est disponible , PROFIL_VISITOR (utilise pour les langues : `L_PLUGINS_REQUIREMENTS_NONE` pour decrire le profil à ***aucun***  )

Ce qu'il manque : le fichier langue pour afficher visiteur ou visitor :)

Exemple d'usage basique pour obligé a se loguer pour afficher une page article ou categorie:
ajouter dans les fichiers du théme : **article.php** et **article-full-width.php** , idem pour **categorie.php** et **categorie-full-width.php** la portion de code suivante qui renverra l'utilisateur sur la page d'authenfication.
```
<?php if($_SESSION['profil']!='') {}
else {header('Location: auth.php?p='.htmlentities($_SERVER['REQUEST_URI']));}
?>
``` 

si vous étes logué avec le profil PROFIL_VISITOR, toute tentatives d'accés à l'administration doit vous renvoyé sur la page d'accueil.

N'hesitez pas a forker et commenter.

Cdt GC
