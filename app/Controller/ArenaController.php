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
        public $components = array('Cookie');
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
            $this->Cookie->write('idFighter', 5);
            $this->Cookie->write('nbAction', 0);

        }

        public function sight()  
        {
          //$this->Fighter->InitPosition(1);
        
       // $this->set('raw',$this->Fighter->find('all'));
          
        
      //  $this->Surrounding->beginGame();
        //$this->Fighter->add(1, "ttt");
        
        //$this->Tool->initPosition($this->Surrounding->getAllSurrounding());
        
      // $this->Tool->pickTool($this->Fighter->getFighterview(5), 52);
            $this->set('result_array', $this->Surrounding->getAllSurrounding());
            $result_array=$this->Surrounding->getAllSurrounding();

            if ($this->request->is('post')) {
                if(key($this->request->data) == 'Fightermove') {
                    $this->Fighter->doMove(1, $this->request->data['Fightermove']['direction']);
                    $c = $this->Surrounding->nearFromPiege($this->Fighter->findById(5));
                $d = $this->Surrounding->nearFromMonster($this->Fighter->findById(5));
                $a = $this->Surrounding->fighterOnPiege($this->Fighter->findById(5));
                $b = $this->Surrounding->fighterOnMonster($this->Fighter->findById(5));
                $this->Fighter->deathFromSurrounding(5, $a);
                    
                    $this->Session->setFlash('Une action a été réalisée.', 'flash_success');
                    

                    
                }
                
                elseif (key($this->request->data) == 'FighterAttack') {
                    $this->Fighter->doAttack(1, $this->request->data['FighterAttack']['direction']);
                }

                elseif (key($this->request->data) == 'UploadPicture') {
                    $this->Fighter->createAvatar(1,$this->request->data['UploadPicture']['avatar']['tmp_name']);
                }
		
	 
            }

        }


    }
?>
