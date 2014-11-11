<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';

    public $belongsTo = array(

        'Player' => array(

            'className' => 'Player',

            'foreignKey' => 'player_id',

        ),

   );
    
    
    function checkPosition($coordonnee_x, $coordonnee_y, $fighterId)
    {
        $a = false;
        $tab = $this->query("Select coordinate_x, coordinate_y from fighters where id <> $fighterId");
   
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $coordonnee_y && 
                     $value['coordinate_x']== $coordonnee_x)
                  $a = true;  
            }
            
        return $a;
    }
    
    function doMove($fighterId, $direction)
    {
        // récupérer la position et fixer l'id de travail
        $datas = $this->read(null, $fighterId);      
        
        if ($direction == 'north') {
            if ($datas['Fighter']['coordinate_x']+1<15 && !$this->checkPosition($datas['Fighter']['coordinate_x']+1, $datas['Fighter']['coordinate_y'], $fighterId))
                $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + 1);
        } elseif ($direction == 'south') {
            if ($datas['Fighter']['coordinate_x']-1>=0 && !$this->checkPosition($datas['Fighter']['coordinate_x']-1, $datas['Fighter']['coordinate_y'], $fighterId))
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] - 1);
        } elseif ($direction == 'east') {
            if ($datas['Fighter']['coordinate_y']+1<10 && !$this->checkPosition($datas['Fighter']['coordinate_x'], $datas['Fighter']['coordinate_y']+1, $fighterId))
                $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] + 1);
        } elseif ($direction == 'west') {            
            if ($datas['Fighter']['coordinate_y']-1>=0 && !$this->checkPosition($datas['Fighter']['coordinate_x'], $datas['Fighter']['coordinate_y']-1, $fighterId))
                $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] - 1);
        } else {
            return false;
        }
        
        // sauver la modif
        $this->save();
        
        //@todo : Case déjà occupée 
        
        
        return true;
    }
    
    function getIdDef($coordonnee_x, $coordonnee_y, $fighterID){
        $tab = $this->query("Select * from fighters where id <> $fighterID");
        
        //Obtenir id défenseur aux coordonnées où on attaque
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $coordonnee_y && 
                     $value['coordinate_x']== $coordonnee_x)
                    return $value['id'];
            }
            
        return false;
    }
    
    function doAttack($fighterId,$direction){
       
       $datas = $this->read(null, $fighterId); 
       
       //Obtenir valeur de l'id défenseur
       if ($direction == 'north') 
       $defenderId = $this->getIdDef($datas['Fighter']['coordinate_x']+1, $datas['Fighter']['coordinate_y'], $fighterId);
       elseif ($direction == 'south') 
       $defenderId = $this->getIdDef($datas['Fighter']['coordinate_x']-1, $datas['Fighter']['coordinate_y'], $fighterId);
       elseif ($direction == 'east') 
       $defenderId = $this->getIdDef($datas['Fighter']['coordinate_x'], $datas['Fighter']['coordinate_y']+1, $fighterId);
       elseif ($direction == 'west') 
       $defenderId = $this->getIdDef($datas['Fighter']['coordinate_x'], $datas['Fighter']['coordinate_y']-1, $fighterId);
       else
           return false;
       
       echo "$defenderId\n";
       
       //Obtenir données du défenseur
       if(!$defenderId)
           return false;
       else{
          $datas2 = $this->read(null, $defenderId);
          
          //obtenir valeur aléatoire
          $a = rand(1 , 20 );     
       
          //Tester si l'attaque réussie ou non
          if ($a>(10 + $datas2['Fighter']['level'] - $datas['Fighter']['level']))
          {
            
            //Appliquer la force de l'attaque
              $this->set('skill_health', $datas2['Fighter']['skill_health'] - $datas['Fighter']['skill_strength']);
             
              //@todo : Retirer joueur du plateau
              
              //sauver modif
               $this->save();
          }
          else{
              return false;
          }
           
           
       }
       
    }

}
