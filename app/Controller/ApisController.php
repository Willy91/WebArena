<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ApisController extends AppController
{
    
    public $uses = array('Player', 'Fighter', 'Event');
    
    public function index() {

    }


    function fighterview(){
    
        $this->layout = 'ajax'; 
        
        
        if (isset($this->request->params['pass'][0]))
            $this->set('datas', $this->Fighter->findById($this->request->params['pass'][0]));
        else
            $this->set('datas', "Error");

       // $this->set('datas', $this->Fighter->find('all'));

        
    }
    
    function fighterdomove(){
    
        $this->layout = 'ajax'; 
        
        
        if (isset($this->request->params['pass'][0])&&isset($this->request->params['pass'][1])){
            $this->Fighter->doMove($this->request->params['pass'][0], $this->request->params['pass'][1]);
        }

       // $this->set('datas', $this->Fighter->find('all'));

        
    }
    
    function fighterdoattack(){
    
        $this->layout = 'ajax'; 
        
        
        if (isset($this->request->params['pass'][0])&&isset($this->request->params['pass'][1])){
            $this->Fighter->doAttack($this->request->params['pass'][0], $this->request->params['pass'][1]);
        }

       // $this->set('datas', $this->Fighter->find('all'));

        
    }


}