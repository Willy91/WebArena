<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class Tool extends AppModel {

    public $displayField = 'name';

    public $belongsTo = array(

        'Fighter' => array(

            'className' => 'Fighter',

            'foreignKey' => 'fighter_id',

        ),

    );
    
    //Vérifier si un fighter a déjà un équipement du type
    function equipFighter($fighterId, $toolId){
        $datas = $this->read(null, $toolId);
        
        $tab = $this->query("Select * from tools where player_id == $fighterId");
        
        //S'il a déjà un équipement du type alors on demande s'il veut l'échanger ou non.
        foreach ($tab as $key) {
            foreach ($key as $value) {
                if ($value['type_bonus']==$datas['Tool']['type_bonus']){
                    //@todo : Demander si on remplace ou non
                }
                
            }
            }
    }
    
    //On attribue un fighter à un objet
    function getFighter($fighterId, $toolId){
       $this->read(null, $toolId);
        
       $this->set('fighter_id', $fighterId);
        
       $this->save();
    }
    
    //On enlève un objet à un fighter
    function removeTool($fighterId, $toolId){
        
        $tab = $this->query("Select * from fighters where id == $fighterId");
        $this->read(null, $toolId);
        
        //On dépose l'objet à la position du mec
        foreach ($tab as $key) {
            foreach ($key as $value) {
                $this->set('coordinate_x', $value['coordinate_x']);
                $this->set('coordinate_y', $value['coordinate_y']);
            }
        }
                
        $this->set('fighter_id', NULL);
        
        $this->save();
    }
    
}