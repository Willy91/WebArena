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
            un slider des avapaars
             * Retourne un tableau décroissant des fighters classés par level
             * $this->Fighter->getRankFighter()
             */
            $tab = $this->Fighter->getAllFighterview();
            $this->Cookie->check('idFighter');
          
            
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
             
            $this->Cookie->check('idFighter');
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

        
        
        function newAction(){
            
            //A TESTER QUAND CA MARCHERA BIEN
        $nb = $this->Cookie->read("nbAction");
        
        
        $this->Cookie->write("nbAction", $this->Fighter->Action($nb, $this->Cookie->read('idFighter')));
      
        
        }

        
        public function fighter()  
        {
            
           $this->Cookie->check('idFighter');
       

            //Fighter view. Need IdFighter
            $tab = $this->Fighter->getAllFighterviewPlayer($this->Session->read('Connected'));
            
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
            
        $this->set('fighter', $this->Cookie->read('idFighter'));    
        $this->set('players',$this->Player->find('list'));

            
        if($this->request->is('post'))
 		{
 		    if(key($this->request->data) == 'CreateFighter') 
			{
                    if ($this->request->data['CreateFighter']['name']!=""){
                           $this->Fighter->add($this->Session->read('Connected'), $this->request->data['CreateFighter']['name']);
                           $this->redirect(array('action' => 'fighter'));
                    }
            }
            elseif (key($this->request->data) == 'Upload') {
                    $this->Fighter->updateAvatar($this->Cookie->read('idFighter'),$this->request->data['Upload']['avatar']['tmp_name']);                
            }
            elseif(key($this->request->data)=='PassLvl')
                    $this->Fighter->upgrade($this->Cookie->read('idFighter'),$this->request->data['PassLvl']['Skill']);
            elseif(key($this->request->data)=='ReviveFighter')
                    $this->redirect(array('action' => 'sight'));
            elseif(key($this->request->data)=='ChangeFighter') {
                    $id = $this->Fighter->getFighterId($this->request->data['ChangeFighter']['OtherName'],$this->Session->read('Connected'));
                    $this->Cookie->write('idFighter', $id);
            }     
            $this->redirect(array('action' => 'fighter'));
        }
    }
                
		
        

        public function diary()  
        {
            $this->Cookie->check('idFighter');
            $data = $this->Event->getEvent();
            $this->set('raw',$data);
            
        }
        public function resend_password(){
           $this->Cookie->check('idFighter');
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
            $this->Cookie->check('idFighter');
            if($this->request->is('post')) {

            if(key($this->request->data) == 'Login') {

                if( $this->Player->checkLogin($this->request->data['Login']['Email address'],$this->request->data['Login']['Password'])) {
                   
                    $this->Cookie->write('nbAction', 0);
                    
                    $d = $this->Fighter->find('first', array ('conditions' => array('player_id' => $this->Player->getidPlayer($this->request->data['Login']['Email address']))));
                    
                    $this->Cookie->write('idFighter',$d['Fighter']['id'], false, '1 Month');
                    
                    
                    $this->Session->write('Connected', $this->Player->getidPlayer($this->request->data['Login']['Email address']));
                    $this->redirect(array('controller'=>'Arena', 'action'=>'fighter'));
            
                }
            }
            elseif (key($this->request->data) == 'Password_forgotten') {
                $this->Player->send_email($this->request->data['Password_forgotten']['Email']);
                return $this->redirect(array('action' => 'resend_password'));
            }
            elseif (key($this->request->data) == 'Signup') {
                if($this->request->data['Signup']['Password'] == $this->request->data['Signup']['Confirm Password']) {
                    
                    $this->Player->createNew($this->request->data['Signup']['Email address'], $this->request->data['Signup']['Password']);
                }
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
            $this->Cookie->check('idFighter');
           
          //Réinitialiser les objets s'ils ont tous été rammasé  
          $this->Tool->useAgainTool($this->Surrounding->getAllSurrounding());
         
        
          //A ENLEVER SAUF POUR CEUX QUI N ONT PAS ENCORE INITIALISE LA BDD DES OBJETS ET DES SURROUNDING
        //$this->Surrounding->beginGame();
        //$this->Tool->initPosition($this->Surrounding->getAllSurrounding());
          
        $this->Cookie->check('idFighter');
        //Partie à alex
        $dd1 = $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter')));
        $dd2 =$this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter')));
 
        $this->set('result_sight', $dd1);
        $this->set('result_tool', $dd2);

        //$this->set('result_fighter',$this->Fighter->getSeen(1));
        //$this->set('result_fighter',$this->Fighter->find('all'));
        $this->set('result_fighter',$this->Fighter->getSeen($this->Cookie->read('idFighter')));

            //Alex
            $this->set('me',$this->Fighter->findById($this->Cookie->read('idFighter')));
                $c = $this->Surrounding->nearFromPiege($this->Fighter->findById($this->Cookie->read('idFighter')));
                $d = $this->Surrounding->nearFromMonster($this->Fighter->findById($this->Cookie->read('idFighter')));
                $this->set('neartrap',$c);
                $this->set('nearmonster',$d);
            //Si on a des paramètres reçus en post
            if ($this->request->is('post')) {
                //Si le mec veut bouger 
                if (key($this->request->data) == 'Tool') {
                  
                    $this->Tool->fighterOnTool($this->Fighter->getFighterview($this->Cookie->read('idFighter')));
                }
                
                elseif(key($this->request->data) == 'Fightermove') {
                    
                    //Do Move 
                    if($this->Fighter->doMove($this->Cookie->read('idFighter'), $this->request->data['Fightermove']['direction']) == true){
                            
                            $this->Event->MoveEvent($this->Fighter->findById($this->Cookie->read('idFighter')),$this->request->data['Fightermove']['direction'] );    
                        }
                    else
                    {
                        $this->Event->FailMove($this->Fighter->findById($this->Cookie->read('idFighter')),$this->request->data['Fightermove']['direction'] );

                    }
                
                $tab = $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter')));    
                $tab2 = $this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter')));
                $this->set('result_sight', $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter'))));
                $this->set('result_tool',$this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter'))));


                //Retourn True si le fighter est mort à cause d'un piège
                    if($this->Fighter->deathFromSurrounding($this->Cookie->read('idFighter'), $this->Surrounding->fighterOnPiege($this->Fighter->findById($this->Cookie->read('idFighter')))) )
                        {
                        $this->Event->TrapEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                        $this->Event->NewDeathEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                        }
                //Return True si le fighter est mort à cause du monstre
                if($this->Fighter->deathFromSurrounding($this->Cookie->read('idFighter'),$this->Surrounding->fighterOnMonster($this->Fighter->findById($this->Cookie->read('idFighter')))) )
                {
                        $this->Event->MonsterEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                        $this->Event->NewDeathEvent($this->Fighter->findById($this->Cookie->read('idFighter')));

                }
                /*
                $this->Fighter->deathFromSurrounding(1, $a);*/  
                    
                   // $this->Session->setFlash('Une action a été réalisée.', 'flash_success');
                    
                    $this->redirect(array('controller' => 'Arena', 'action' => 'sight'));
                    
                }
                
                elseif (key($this->request->data) == 'FighterAttack') {		
	                     $this->Fighter->doAttack($this->Cookie->read('idFighter'), $this->request->data['FighterAttack']['direction']);
                }
                 elseif(key($this->request->data) == 'Scream'){
                     $this->Event->Crier($this->Fighter->findById($this->Cookie->read('idFighter')), $this->request->data["Scream"]['name']);
                 }
                
            }
        }
    }
?>
