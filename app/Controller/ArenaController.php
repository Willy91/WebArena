<?php 

    App::uses('AppController', 'Controller');

    /**
     * Main controller of our small application
     *
     * @author ...
     */
    class ArenaController extends AppController
    {

        public $uses = array('Player', 'Fighter', 'Event');
        /**
         * index method : first page
         *
         * @return void
         */
        public function index()
        {
            $this-> set ('myname'," Julien Falconnet ");
        }

        
        public function character()  
        {
            $this->set('raw',$this->Fighter->findById(1));
        }

        public function diary()  
        {
            $this->set('raw',$this->Event->find());

        }

        public function login()  
        {
            

        }

        public function sight()  
        {
            if ($this->request->is('post')) {
                if(key($this->request->data) == 'Fightermove') {
                    $this->Fighter->doMove(1, $this->request->data['Fightermove']['direction']);
                }
                
                elseif (key($this->request->data) == 'FighterAttack') {
                    $this->Fighter->doAttack(1, $this->request->data['FighterAttack']['direction']);
                }  
            }

        }

    }
?>