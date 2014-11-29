<?php 

    App::uses('AppController', 'Controller');
    App::uses('CakeEmail', 'Network/Email');

    /**
     * Main controller of our small application
     *
     * @author ...
     */
    class ArenaController extends AppController
    {

        public $uses = array('Player', 'Fighter', 'Event','Guild','Surrounding','Tool');

    
        public $components = array('Cookie','Session');

       
        /**
         * index method : first page
         *
         * @return void
         */
        public function index()
        {
            //PAGE D ACCUEIL 
            /*
            un slider des avatars
             * Retourne un tableau décroissant des fighters classés par level
             * $this->Fighter->getRankFighter()
             */
            $tab = $this->Fighter->getAllFighterview("545f827c-576c-4dc5-ab6d-27c33186dc3e");
            pr($tab);
            $this->set('table_fighter2', $tab);
            
            if($this->request->is('post')){
                $this->redirect(array('controller'=>'arena', 'action'=>'login'));
            }
        }

        
        public function hallofframe(){
            /*
        
            Ajoutez une page «hall of fame» en espace public où vous présentez une liste de
            statistiques sur les caractéristiques, les dates de connexion etc, en utilisant au moins 4
            «charts» de jqplot
            */
           
           
        }
        
        public function guild(){
             
            
            $data = $this->Guild->getAllGuild();
            $tab = array();
            $i=0;
            foreach($data as $key){
                $tab[$i]['Guild'] = $key['Guild'];
                $tab[$i]['Nb'] = $this->Fighter->getNbGuild($key['Guild']['id']);
                $i++;
            }
            $this->set('result_guild', $tab);
            $this->set('name_guild', $this->Guild->getGuildName($this->Fighter->getIdGuild($this->Cookie->read('idFighter'))));
            if($this->request->is('post'))
 		{
 		if(key($this->request->data) == 'CreateGuild'){
                 $this->Guild->createGuild($this->request->data['CreateGuild']['name']);
                 $this->Fighter->joinGuild($this->Cookie->read('idFighter'), $this->Guild->getIdGuild($this->request->data['CreateGuild']['name']));
                 $this->redirect(array('controller'=>'Arena', 'action'=>'guild'));
                 
                }
                if(key($this->request->data) == 'JoinGuild'){
                    $this->Fighter->joinGuild($this->Cookie->read('idFighter'), $this->Guild->getIdGuild($this->request->data['JoinGuild']['name']));
                
                    $this->redirect(array('controller'=>'Arena', 'action'=>'guild'));
                }
                
                }
        }
        
        public function signup() 
        {

            if($this->request->is('post')) {
                if($this->request->data['Signup']['Password'] == $this->request->data['Signup']['Confirm Password'])
                    $this->Player->createNew($this->request->data['Signup']['Email address'], $this->request->data['Signup']['Password']);
                else
                    $this->Session->setFlash('Passwords not correct', 'flash_error');
                if($this->request->data == 'Password_forgotten'){
                    pr("hello");
                }
            }


        }
        
        
        function newAction(){
            
            //A TESTER QUAND CA MARCHERA BIEN
        $nb = $this->Cookie->read("nbAction");
        
        
        $this->Cookie->write("nbAction", $this->Fighter->Action($nb, $this->Cookie->read('idFighter')));
      
        
        }

        
        public function fighter()  
        {
           

            //Fighter view. Need IdFighter
            $tab = $this->Fighter->getAllFighterviewPlayer("545f827c-576c-4dc5-ab6d-27c33186dc3e");
            
            $this->set('table_fighter2', $tab);
        
            /*
            $nb = $this->Fighter->getNbFighterFromPlayer($this->Player->getIdFighter($mail));
               if ($nb == 0)
        */
        //Function to join a guild
        //Need the name of the guild and the id of the fighter
        //$this->Fighter->joinGuild($IdFighter, $this->Guild->getIdGuild($nameGuild) );
        
        
        
        //Function to revive. Need the idFighter 
        //$this->Fighter->reviveFighter($idFighter);


        //Function to create a guild. Need the fighter ID and the name of the guild
        //$this->Guild->CreateGuild("Test2");
        
        
        
        //Function to get all the name of guilds.
        //Return an array Array like this
        //(
        //  [0] => Array
        //(
        //    [Guild] => Array
        //        (
        //            [name] => Test
        //       )
        //  )
        //)
        //$this->Guild->getAllGuild();
            
            
	$this->set('players',$this->Player->find('list'));

            
            if($this->request->is('post'))
 		{
                echo key($this->request->data);
 		if(key($this->request->data) == 'CreateFighter') 
			{
                            $this->Fighter->add($this->Session->read('Connected'), $this->request->data['CreateFighter']['name']);
                    
			}
		elseif (key($this->request->data) == 'PassLvl') {	
                    $this->Fighter->upgrade(1, $this->request->data['PassLvl']['Choose a skill to upgrade']);
            	}
                
		}
        }

        public function diary()  
        {
            $data = $this->Event->getEvent();
            $this->set('raw',$data);
            
        }
        public function resend_password(){
            if($this->request->is('post')){

   /*          $Email = new CakeEmail('gmail');
                $Email->emailFormat('html');
                $Email->template('forgotten_password','email');
                $Email->to($this->request->data['Password_forgotten']['Email']);
                $Email->subject('Automagically generated email');
                $Email->from ('abruneau@ece.fr');
                $Email->send();
                 return $this->redirect(array('action' => 'index'));
                 */
                $this->Player->send_email($this->request->data['Password_forgotten']['Email']);
                return $this->redirect(array('action' => 'resend_password'));
            }
        }
        public function login()
        {

            if($this->request->is('post')) {

            if(key($this->request->data) == 'Login') {

                if( $this->Player->checkLogin($this->request->data['Login']['Email address'],$this->request->data['Login']['Password'])) {
                   
                    
                    $this->Cookie->write('nbAction', 0);
                    $this->Cookie->write('idFighter',1);

                    
                    $this->Session->write('Connected', $this->Player->getidPlayer($this->request->data['Login']['Email address']));
                   
                    
                    $this->redirect(array('controller'=>'Arena', 'action'=>'fighter'));
            
                }
            }
            elseif (key($this->request->data) == 'Password_forgotten') {
                $this->Player->send_email($this->request->data['Password_forgotten']['Email']);
                return $this->redirect(array('action' => 'resend_password'));
            }


            }

        }

        public function logout()
        {

            $this->Session->delete('Connected');
            $this->redirect(array('controller' => 'Arena', 'action' => 'index'));
            
        }


    	public function BeforeFilter() {
           
            
            if(!$this->Session->read('Connected') && $this->request->params['action']!='login' && $this->request->params['action']!='index' && $this->request->params['action']!='signup')
        	{
        		if ($this->request->params['action']!='login' && $this->request->params['action']!='signup' && $this->request->params['action']!='index' && $this->request->params['action']!='hallofframe'){
                        $this->request->params['action'];
        		$this->redirect(array('controller' => 'Arena', 'action' => 'login'));	
                        }
        	}
    	}

        public function sight()  
        {
            /**Elle affichera les combattants et les objets du décors en vue classés par
distance croissante.
             * 
             * faites apparaître un tooltip au survol des trucs sur le damier.
             * 
             * **/
            
            
          //Réinitialiser les objets s'ils ont tous été rammasé  
          $this->Tool->useAgainTool($this->Surrounding->getAllSurrounding());
        
        
          //A ENLEVER SAUF POUR CEUX QUI N ONT PAS ENCORE INITIALISE LA BDD DES OBJETS ET DES SURROUNDING
        //$this->Surrounding->beginGame();
        //$this->Tool->initPosition($this->Surrounding->getAllSurrounding());
          echo $this->Cookie->read('idFighter');
        //Partie à alex
        $this->set('result_sight', $this->Surrounding->getSurroundingSight($this->Fighter->findById(1)));
        $this->set('result_tool',$this->Tool->getToolSight($this->Fighter->findById(1)));

        $this->set('result_fighter',$this->Fighter->find('all'));
            //Alex
            $this->set('me',$this->Fighter->findById($this->Cookie->read('idFighter')));
            //Si on a des paramètres reçus en post
            if ($this->request->is('post')) {
                //Si le mec veut bouger 
                if(key($this->request->data) == 'Fightermove') {
                    
                    //Do Move 
                    $this->Fighter->doMove($this->Cookie->read('idFighter'), $this->request->data['Fightermove']['direction']);
                
                $tab = $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter')));    
                $tab2 = $this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter')));
                $this->set('result_sight', $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter'))));
                $this->set('result_tool',$this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter'))));

                $c = $this->Surrounding->nearFromPiege($this->Fighter->findById($this->Cookie->read('idFighter')));
                $d = $this->Surrounding->nearFromMonster($this->Fighter->findById($this->Cookie->read('idFighter')));
                
                //Retourn True si le fighter est mort à cause d'un piège
                $this->Fighter->deathFromSurrounding($this->Cookie->read('idFighter'), $this->Surrounding->fighterOnPiege($this->Fighter->findById($this->Cookie->read('idFighter'))));
                //Return True si le fighter est mort à cause du monstre
                $this->Fighter->deathFromSurrounding($this->Cookie->read('idFighter'),$this->Surrounding->fighterOnMonster($this->Fighter->findById($this->Cookie->read('idFighter'))));
                
                /*
                $this->Fighter->deathFromSurrounding(1, $a);*/
                    
                    $this->Session->setFlash('Une action a été réalisée.', 'flash_success');
                    
                    $this->redirect(array('controller' => 'Arena', 'action' => 'sight'));
                    
                }
                
                elseif (key($this->request->data) == 'FighterAttack') {		
	                     $this->Fighter->doAttack($this->Cookie->read('idFighter'), $this->request->data['FighterAttack']['direction']);
                }
                 //CA NA RIEN A FAIRE LA
                elseif (key($this->request->data) == 'UploadPicture') {
                    $this->Fighter->createAvatar($this->Cookie->read('idFighter'),$this->request->data['UploadPicture']['avatar']['tmp_name']);
                }
                
                elseif (key($this->request->data) == 'pickTool') {
                    $this->Tool->fighterOnTool($this->Cookie->read('idFighter'));
                }
            }
        }
    }
?>
