<?php if(!defined("PLX_ROOT")) exit; 

//$plxPlugin->setParam('param2', $_POST['param2'], 'string');
// configuation : fait un backup du fichier users.xml
	if (!file_exists(PLX_ROOT.PLX_CONFIG_PATH.'users.xml.bak')) {
		$file = PLX_ROOT.PLX_CONFIG_PATH.'users.xml';
        $newfile = PLX_ROOT.PLX_CONFIG_PATH.'users.xml.bak';

		if (!copy($file, $newfile)) {
			echo "La copie $file du fichier a échoué...\n";
		}
		else {
			$jour = date("d/m/Y");
        $plxPlugin->setParam('set', '<p class="alert yellow"> '.PLX_ROOT.PLX_CONFIG_PATH.'<b>users.xml.bak </b> <i style="color:green"> - '.L_SAVE_FILE_SUCCESSFULLY.' - <b>'.$jour. '</b></i></p>', 'cdata');
        $plxPlugin->saveParams();
        header('Location: parametres_plugin.php?p='.$plugin);
        exit;
		}
	}

if  (@($open = fopen(PLX_PLUGINS.$plugin."/username.csv", "r")) !== FALSE) {
	 $fileCsv = file_get_contents(PLX_PLUGINS.$plugin."/username.csv", true);
}
else {
	$open = fopen(PLX_PLUGINS.$plugin."/username.csv", "w") ;
	$fileCsv="login ; name ; password ; email\n";
	fwrite($open, $fileCsv);
	fclose($open);
}



  if(!empty($_GET['ploc'])) {	  
	$fileupdate = fopen(PLX_PLUGINS.$plugin."/username.csv", "w")  ;
	fwrite($fileupdate, $_POST['csv']);
	$fileCsv=$_POST['csv'];
	fclose($fileupdate); 	  
	updateFromCsv(); 
  }
  ?>
  

  
  <?php

	echo '
	<header style="display:flex;align-items:center;gap:1em;"><h2 style="margin:auto 0;">'.L_CONFIG_USERS_UPDATE.'</h2>
    <p class="alert orange" style="margin:0;flex:1;"><b>'. L_PROFIL.':</b> '.L_ADMIN.' == '.L_NO_ENTRY.'</p></header>
	<form action="parametres_plugin.php?p='.$plugin.'&ploc=envoyer" method="post" style="margin:2em;">
	<label for="csv"><b>'.L_COMMENT_EDIT.':</b><br> '.L_MEDIAS_FILENAME.' :<code>username.csv</code> <br> '.L_MEDIAS_DIRECTORY.' <code>/plugins/visitor</code>. </label>
	<textarea name="csv" style="width:100%;height:200px;" name="csv" >'.  $fileCsv . '</textarea>
	<br>
	<input value="'.L_SAVE_FILE.' username.csv & '.L_CONFIG_USERS_UPDATE.'" type="submit">
	</form>';
	echo '<p>'.L_MEDIAS_DOCUMENTS .' & '.L_MEDIAS_DIRECTORY .'</p>';
	echo '<ol><li>'.PLX_ROOT.PLX_CONFIG_PATH.'<b>users.xml</b></li><li>' ;
	echo $plxPlugin->getParam('set').'</li><li>' ;
	echo PLX_PLUGINS.$plugin."/<b>username.csv</b></li></ol>";	
	

class SimpleXMLExtended extends SimpleXMLElement {
// from https://web.archive.org/web/20110223233311/http://coffeerings.posterous.com/php-simplexml-and-cdata	
  public function addCData($cdata_text) {
    $node = dom_import_simplexml($this); 
    $no   = $node->ownerDocument; 
    $node->appendChild($no->createCDATASection($cdata_text)); 
  } 
}
function updateFromCsv() {

// on verfie que nos fichiers sont accessibles
if ((file_exists(PLX_ROOT.PLX_CONFIG_PATH.'users.xml')) && (($open = fopen(PLX_PLUGINS."visitor/username.csv", "r")) !== FALSE) ) {
	




	// on commence avec le fichier csv  
    while (($data = fgetcsv($open, 1000, ";")) !== FALSE)     {        
      $array[] = $data; 
    }  
    fclose($open);

	// on recupere le fichier XML
    $xml = file_get_contents(PLX_ROOT.PLX_CONFIG_PATH.'users.xml', true);

    // on charge le fichier xml
	$doc = new SimpleXMLExtended($xml); 
    // on compte les enregistrements
	$kids = $doc->children();
	$nbUser = count($kids);


  // on boucle sur les lignes du fichiers CSV pour récuperer les données et les ajouter aux données existantes 

foreach($array as $i => $line){ 


		if($i >0) { // on passe la premiere ligne ou sont  stockées les entêtes de colonnes.
				  $nbUser++;

			//foreach($line  as $key => $value){
			
	 
			$element = $doc->addChild('user'); 
			$element->addAttribute('number', str_pad($nbUser, 3,'0', STR_PAD_LEFT)  );
			$element->addAttribute('active', '1' );
			$element->addAttribute('profil', '5' );
			$element->addAttribute('delete', '0' );	 
			
			$login = $element->addChild('login'); 
			$login->addCData($line[0]); 

			$name = $element->addChild('name'); 
			$name->addCData($line[1]); 

			$infos = $element->addChild('infos'); 
			$infos->addCData(''); 

	//$salt='';
	$salt = plxUtils::charAleatoire(10);
	
	//$pwd=$line[2];
	$pwd=sha1($salt.md5($line[2]));			
			
			$password = $element->addChild('password'); 
			$password->addCData($pwd); 
			

			$salted = $element->addChild('salt'); 
			$salted->addCData($salt); 

			$email = $element->addChild('email'); 
			$email->addCData($line[3]); 

			$lang = $element->addChild('lang'); 
			$lang->addCData('fr'); 

			$password_token = $element->addChild('password_token'); 
			$password_token->addCData(''); 

			$password_token_expiry = $element->addChild('password_token_expiry'); 
			$password_token_expiry->addCData(''); 
			//}

	   }
      }
			//On refait l'indentation du fichier  parceque c'est plus joli
			$xmlDoc = new DOMDocument ();
			$xmlDoc->preserveWhiteSpace = false;
			$xmlDoc->formatOutput = true;
			$xmlDoc->loadXML ( $doc->asXML() );
			// on sauvegarde le fichier xml mis à jour.
			$xmlDoc->save(PLX_ROOT.PLX_CONFIG_PATH.'users.xml');
			$nbUser = $nbUser -2 ;
echo '<p class="alert green ">'.L_SAVE_SUCCESSFUL. ' - '.L_CONFIG_USERS_NEW.' <b> '.$nbUser  .'</b></p>';

} else {
    exit(L_SAVE_FILE_ERROR.' user.xml / username.csv.');
}
}

?>

