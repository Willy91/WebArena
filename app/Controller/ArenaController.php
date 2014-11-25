<?php 

    App::uses('AppController', 'Controller');

    /**
     * Main controller of our small application
     *
     * @author ...
     */
    class ArenaController extends AppController
    {

        public $uses = array('Player', 'Fighter', 'Event','Guild','Surrounding','Tool');

        public $components = array('Session','Cookie');

        

        /**
         * index method : first page
         *
         * @return void
         */
        public function index()
        {
        }

        public function signup() 
        {
           
        }
        
        function newAction(){
        $nb = $this->Cookie->read("nbAction");
        
        
        $this->Cookie->write("nbAction", $this->Fighter->Action($nb, $this->Cookie->read('idFighter')));
      
        
    }

        
        public function fighter()  
        {
            //Fighter view. Need IdFighter
        //$this->getFighterview($idFighter);
        
        
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
 		if(key($this->request->data) == 'CreateFighter') 
			{
                	if($this->Fighter->add("545f827c-576c-4dc5-ab6d-27c33186dc3e", $this->request->data['CreateFighter']['name'])) 
				{
                   	 	$this->Session->setFlash('Done !');
                		}
			}
		elseif (key($this->request->data) == 'PassLvl') {	
                    $this->Fighter->upgrade(1, $this->request->data['PassLvl']['Choose a skill to upgrade']);
            	}
		}
        }

        public function diary()  
        {
            $this->set('raw',$this->Event->find());

        }

        public function login()
        {
            //$this->Session->delete('Connected');
          //  pr($this->Session->read('Connected'));
              $this->Player->createNew("root","root");
            if($this->request->is('post')) {
                if( $this->Player->checkLogin($this->request->data['Login']['Email address'],$this->request->data['Login']['Password'])== true) {
                    pr("ok");
                    $this->Session->write('Connected', $this->Player->getidPlayer($this->request->data['Login']['Email address']));
                    $this->Cookie->write('idFighter',1);
                    
                }
                // $this->Cookie->write('idFighter', 5);
                // $this->Cookie->write('nbAction', 0);
            }

        }

        public function logout()
        {

            $this->Session->delete('Connected');
            $this->redirect(array('controller' => 'Arena', 'action' => 'index'));
            
        }


    	public function BeforeFilter() {

        	echo   $this->request->params['action'];

        	if($this->Session->read('Connected')!=true && $this->request->params['action']!='login')
        	{
        		//$this->request->params['action'];
        		$this->redirect(array('controller' => 'Arena', 'action' => 'login'));	
        	}
    	}

        public function sight()  
        {
            /**Elle affichera les combattants et les objets du décors en vue classés par
distance croissante.**/
            
            
          //Réinitialiser les objets s'ils ont tous été rammasé  
          $this->Tool->useAgainTool($this->Surrounding->getAllSurrounding());
        
        //$this->Surrounding->beginGame();
        //$this->Tool->initPosition($this->Surrounding->getAllSurrounding());
          
        
        $this->set('result_sight', $this->Surrounding->getSurroundingSight($this->Fighter->findById(1)));
        $this->set('result_tool',$this->Tool->getToolSight($this->Fighter->findById(1)));



            $this->set('me',$this->Fighter->findById($this->Cookie->read('idFighter')));
            if ($this->request->is('post')) {
                if(key($this->request->data) == 'Fightermove') {
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
                
                echo " _test $a $b $c $d ";
                pr($tab);
                pr($tab2);
                /*
                $this->Fighter->deathFromSurrounding(1, $a);*/
                    
                    $this->Session->setFlash('Une action a été réalisée.', 'flash_success');
                    

                    
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
