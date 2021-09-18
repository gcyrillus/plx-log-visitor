# visitor
squelette d'un plugin laissant l'accés à une page aprés connexion.

installé le plugin via l'administration.

Un champ supplementaire est alors disponible pour les profiles utilisateurs dans l'admin :  PROFIL_VISITOR , qui utilises pour les langues : `L_PLUGINS_REQUIREMENTS_NONE` pour decrire le profil à ***aucun***  )


Exemple d'usage basique pour obliger a s'identifier pour accéder à une page article ou categorie:

Ajouter dans les fichiers du thème et en premiere ligne: **article.php** et **article-full-width.php** , idem pour **categorie.php** et **categorie-full-width.php** la portion de code suivante qui renverra l'utilisateur sur la page d'authenfication pour y accéder.
```
<?php if($_SESSION['profil']!='') {}
else {header('Location: auth.php?p='.htmlentities($_SERVER['REQUEST_URI']));}
?>
``` 

si vous étes logué avec le profil `PROFIL_VISITOR`, toutes tentatives d'accés à l'administration doit vous renvoyer sur la page d'accueil du site.

N'hesitez pas a forker et commenter.

Cdt GC
