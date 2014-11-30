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
    
    
    function fighterOnTool($data2){
       $data = $this->find('all', array('conditions'=>array('fighter_id' => NULL)));
       $x = $data2['Fighter']['coordinate_x'];
       $y = $data2['Fighter']['coordinate_y'];
   
       foreach ($data as $key){
           if($key['Tool']['coordinate_x']==$x && $key['Tool']['coordinate_y']==$y){
               
               $this->pickTool($data2, $key['Tool']['id']);
               return true;
           }     
       }
       return false;
   }
    
    //Vérifier si un fighter a déjà un équipement du type
    function pickTool($data, $toolId){
        $data2 = $this->findById($toolId);
     
        $data2['Tool']['fighter_id']=$data['Fighter']['id'];
        $this->save($data2);
        if($data2['Tool']['type']=='Armure'){
             $data['Fighter']['skill_health']= $data['Fighter']['skill_health']+$data2['Tool']['bonus'];
             $data['Fighter']['current_health']=$data['Fighter']['current_health']+$data2['Tool']['bonus'];
        }
        if($data2['Tool']['type']=='Epee')
            $data['Fighter']['skill_strenght']= $data['Fighter']['skill_strength']+$data2['Tool']['bonus'];
        if($data2['Tool']['type']=='Lunette')
            $data['Fighter']['skill_sight']= $data['Fighter']['skill_sight']+$data2['Tool']['bonus'];
        $this->Fighter->save($data);
    }
    
    function getTool($idTool){
        return $this->findById($idTool);
    }
      
    function useAgainTool($data){
        $nb = $this->find('count', array('conditions' => array('fighter_id' => NULL)));
        if ($nb==0){
            $this->initPositionTool($data);
            return true;
        }
        else
            return false;
    }
    
    
    function initPositionTool($data2){
       // $this->query("Delete from tools");
        $array = array();
       
       for ($i=0; $i<Configure::read('Largeur_x'); $i++){
           for ($j=0; $j<Configure::read('Longueur_y');$j++){
               $array[$i][$j] = true;
           }
       }
       
       //On marque indispo les cases occupées par l'es colonnes'environnement
        foreach($data2 as $key)
               $array[$key['Surrounding']['coordinate_x']][$key['Surrounding']['coordinate_y']]= false;
        
           
        //20 objets
        for ($i=0; $i<25; $i++){
           do{
               $fin = false;
               $y = rand(0 , Configure::read('Longueur_y')-1 );
               $x = rand(0,Configure::read('Largeur_x')-1);
               
               if($array[$x][$y]==true)
                   $fin=true;
               
           }while(!$fin);
           
           
           //On sauvegarde 
           $data=$this->create();
           $data['Tool']['coordinate_x'] = $x;
           $data['Tool']['coordinate_y'] = $y;
        
           $a = rand(0,3);
           switch($a){
               case 0: $data['Tool']['type'] = 'Armure'; break;
               case 1: $data['Tool']['type'] = 'Epee'; break;
               case 2: $data['Tool']['type'] = 'Lunettes'; break;
               case 3 : $data['Tool']['type'] = 'Armure'; break;
           }
           $data['Tool']['bonus'] = rand(1,3);
           
           
          $this->save($data);
           
           $array[$x][$y] = false;
       }  
        
        
    }
    
    function getFreeTool(){
        return $this->find('all', array('conditions' => array('fighter_id'=>NULL)));
    }
    
    function getToolSight($data){
       $x = $data['Fighter']['coordinate_x'];
       $y = $data['Fighter']['coordinate_y'];
       
       $data2 = $this->find('all');
       $nb = 0;
       $tab = array();
       foreach($data2 as $key){
           $sight_x = $key['Tool']['coordinate_x']-$x;
           if ($sight_x<0)
               $sight_x = $sight_x*(-1);
           $sight_y = $key['Tool']['coordinate_y']-$y;
           if ($sight_y<0)
               $sight_y = $sight_y*(-1);
           $total = $sight_x+$sight_y;
          
           if ($total<=$data['Fighter']['skill_sight'] && $key['Tool']['fighter_id']==NULL){
                echo $total . " ";
               $key['Distance']=$total;
                $tab[$nb]=$key;
               $nb++;
           }
               
       }
       
       return $tab;
       
   }
    
    
}