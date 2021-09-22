## plx-log-visitor

Plugin laissant l’accès à une page après connexion.

déposer dans le dossiers **/plugins** de votre PluXml le répertoire **/visitor** et tout ses fichiers. (l'archive téléchargeable)

installez le plugin via l'administration.
L'ajout d'un nouveau profil est aussitôt disponible dans la gestion des utilisateurs. Il est conseillé de lancer la configuration du plugin avant de modifier modifier votre liste d'utilisateurs.

cliquez sur configuration. 
Un backup du fichier **users.xml** est effectué en **users.xml.bak** et un fichier **username.csv** est créer dans le répertoire du plugin avec les entêtes suivant:
```
login ; name ; password ; email
```
Ce fichier est chargé et affiché dans un textarea
Il vous est possible de l’éditer pour y ajouter un nouvel utilisateur par ligne en respectant l'entête .

**Attention** il n'y a pas de vérification de doublons , les données qui sont affichées sont les dernières qui ont été enregistrées, il faudra les effacer avant d'ajouter de nouveaux utilisateurs et de soumettre le formulaire.

Les mots de passe sont crypté à l'enregistrement , pour qu'un utilisateur puisse le changer par la suite, il faudra que l'adresse mail fournie soit valide. Cette récupération d'oubli de mot de passe est géré nativement par PluXml.

Coté administration des utilisateurs :
Un champ supplémentaire est alors disponible pour les profiles utilisateurs dans l'admin :  PROFIL_VISITOR , qui utilise pour les langues : `L_NONE` pour décrire le profil à ***aucun***  )


Exemple d'usage basique pour obliger a s'identifier pour accéder à une page article ou categorie:

Ajouter dans les fichiers du thème et en première ligne: **article.php** et **article-full-width.php** , idem pour **categorie.php** et **categorie-full-width.php** la portion de code suivante qui renverra l'utilisateur sur la page d'authentification pour y accéder.

si vous souhaitez proteger **seulement une page statique**, ce code est alors à inserer dans cette page statique uniquement.
```
<?php if($_SESSION['profil']!='') {}
else {header('Location: /core/admin/auth.php?page='.$_SERVER['REQUEST_URI']);}
?>
``` 

Si vous étes logué avec le profil `PROFIL_VISITOR`, toutes tentatives d’accès à l'administration  vous renvoi sur la page d'accueil du site.

**Pour se déconnecter :** Vous pouvez ajouter dans le thème ce lien de déconnexion, dans le fichier **footer.php** sur la ligne avant la balise `</footer>` ou pour le cas d'une page statique , dans celle-ci. Le lien ne s'affiche que si vous étes connecté.

```
<?php 	
if(isset($_SESSION['profil']) and $_SESSION['profil'] == '5') { echo '<a href="/core/admin/auth.php?d=1" class="alert orange">Déconnexion</a>' ;} 	
?>
``` 

N’hésitez pas a forker et commenter.

Cdt GC
