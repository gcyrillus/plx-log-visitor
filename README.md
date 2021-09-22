# plx-log-visitor

squelette d'un plugin laissant l’accès à une page après connexion.

installé le plugin via l'administration.

cliquez sur configuration. 
Un backup du fichier users.xml est effectué en users.xml.bak et un fichier username.csv est créer dans le répertoire du plugin avec les entêtes suivant:
```
login , name , password , email
```
Ce fichier est chargé et affiché dans un textarea
Il vous est possible de l’éditer pour y ajouter un nouvel utilisateur par ligne en respectant l'entête .

**Attention** il n'y a pas de vérification de doublons , les données qui sont affichées sont les dernières qui ont été enregistrées, il faudra les effacer avant d'ajouter de nouveaux utilisateurs et de soumettre le formulaire.

Coté administration des utilisateurs :
Un champ supplémentaire est alors disponible pour les profiles utilisateurs dans l'admin :  PROFIL_VISITOR , qui utilise pour les langues : `L_NONE` pour décrire le profil à ***aucun***  )


Exemple d'usage basique pour obliger a s'identifier pour accéder à une page article ou categorie:

Ajouter dans les fichiers du thème et en première ligne: **article.php** et **article-full-width.php** , idem pour **categorie.php** et **categorie-full-width.php** la portion de code suivante qui renverra l'utilisateur sur la page d'authentification pour y accéder.
```
<?php if($_SESSION['profil']!='') {}
else {header('Location: /core/admin/auth.php?page='.$_SERVER['REQUEST_URI']);}
?>
``` 

Si vous étes logué avec le profil `PROFIL_VISITOR`, toutes tentatives d’accès à l'administration doit vous renvoyer sur la page d'accueil du site.

Pour se déconnecter : Vous pouvez ajouter dans le thème ce lien de déconnexion, dans le fichier **footer.php** sur la ligne avant la balise `</footer>`.

```
<?php 	if(isset($_SESSION['profil']) and $_SESSION['profil'] == '5') { echo '<a href="/core/admin/auth.php?d=1" class="alert orange">Déconnexion</a>' ;} 	?>
``` 

N'hesitez pas a forker et commenter.

Cdt GC
