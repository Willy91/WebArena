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
    
    public $uses = array('Player', 'Fighter', 'Event', 'Guild');
    
    public function index() {

    }

    function barchart () {
        $this->layout = 'ajax';

        $this->set('datas', $this->Fighter->find('all', array('limit' => 5,'order'=>array('xp DESC'), 'fields'=>array('name','xp'))));

        $this->render('fighterview');
    }

    function piechart () {
        $this->layout = 'ajax';
        
        $this->set('datas', $this->Fighter->find('all', array('limit' => 1,'order'=>array('xp DESC'), 'fields'=>array('name', 'MAX(xp)', 'skill_sight', 'skill_strength', 'skill_health'))));
        $this->render('fighterview');
    }

    function monthlyevents () {
        $this->layout = 'ajax';

        $this->set('datas', $this->Event->find(
            'all', 
            array(
                'conditions' => array(
                    'date >=' => date('Y-m-d', strtotime('-1 month'))
                    ),
                'fields' => array(
                    'COUNT(*) as nbevents', "DATE_FORMAT(date, '%Y-%m-%d') as date"
                    ),
                'group' => "DATE_FORMAT(date, '%Y-%m-%d')"
                )
            )
        );

        $this->render('fighterview');
    }

    function membersInGuilds () {
        $this->layout = 'ajax';
        $this->set('datas', $this->Fighter->find(
            'all',
            array(
                'limit' => 5,
                'conditions' => array(
                    'not' => array('guild_id'=>null)
                    ),
                'fields' => array (
                    'COUNT(*) as members', 'Guild.name'
                    ),
                'group' => 'guild_id',
                'order' => array('members DESC')
                )
            )
        );
        $this->render('fighterview');
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