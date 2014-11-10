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

        }

        public function diary()  
        {
            

        }

        public function login()  
        {
            

        }
        public function sight()  
        {
            

        }

    }
?>