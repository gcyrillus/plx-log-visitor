<?php
    if(!defined('PLX_ROOT')) {
        die('oups!');
    }

    class visitor extends plxPlugin {
        const HOOKS = array(
			'AdminTopEndHead',
            'AdminUsersTop',
        );
        const BEGIN_CODE = '<?php' . PHP_EOL;
        const END_CODE = PHP_EOL . '?>';

        public function __construct($default_lang) {
            # appel du constructeur de la classe plxPlugin (obligatoire)
            parent::__construct($default_lang);

            # Ajoute des hooks
            foreach(self::HOOKS as $hook) {
                $this->addHook($hook, $hook);
            }
        }
		
		public function AdminTopEndHead() {
            echo self::BEGIN_CODE;
?>
		    if(isset($_SESSION['profil']) and $_SESSION['profil'] == PROFIL_VISITOR) { header("location: /");}
<?php
            echo self::END_CODE;
        }

        public function AdminUsersTop() {
            echo self::BEGIN_CODE;
?>
# Tableau des profils
$aProfils = array(
	PROFIL_ADMIN => L_PROFIL_ADMIN,
	PROFIL_MANAGER => L_PROFIL_MANAGER,
	PROFIL_MODERATOR => L_PROFIL_MODERATOR,
	PROFIL_EDITOR => L_PROFIL_EDITOR,
	PROFIL_WRITER => L_PROFIL_WRITER,
	PROFIL_VISITOR => L_PLUGINS_REQUIREMENTS_NONE 
);

<?php
            echo self::END_CODE;
			
			
        } 

    }
