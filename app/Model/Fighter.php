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
    
    function add($playerId, $name) {


        $data = array(
            'name' => $name,
            'player_id' => $playerId,
            'coordinate_x' => rand(0,15),
            'coordinate_y' => rand(0,10),
            'level' => 1,
            'xp' => 0,
            'skill_sight' => 0,
            'skill_strength' => 1,
            'skill_health' => 3,
            'current_health' => 3
        );

        // prepare the model for adding a new entry
        $this->create();

        // save the data
        return $this->save($data);
    }


	


    function checkPosition($coordonnee_x, $coordonnee_y, $fighterId)
    {
        $a = false;
        //Obtenir poisiotn des autres fighter
        $tab = $this->query("Select coordinate_x, coordinate_y from fighters where id <> $fighterId");
   
        //Vérifier que la case est libre
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $coordonnee_y && 
                     $value['coordinate_x']== $coordonnee_x)
                  $a = true;  
            }
        
        //Obtenir coordonées des colonnes
        $tab = $this->query("Select coordinate_x, coordinate_y from surroundings where type='Colonne'");
    
        //Vérifier que le mec ne va pas sur une colonne
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $coordonnee_y && 
                     $value['coordinate_x']== $coordonnee_x)
                  $a = true;  
            }    
            
        return $a;
    }
    
//changement de niveau
    function upgrade($fighterId,$upskill)
	{
	$datas = $this->read(null, $fighterId); 

	 if ($upskill == 'sight') {
            
                $this->set('skill_sight', $datas['Fighter']['skill_sight'] + 1);
        } elseif ($upskill == 'strength') {
            
                $this->set('skill_strength', $datas['Fighter']['skill_strength'] + 1);
        } elseif ($upskill == 'health') {
            
                $this->set('skill_health', $datas['Fighter']['skill_health'] + 3);
		$this->set('current_health', $datas['Fighter']['current_health'] + 3);
        }  else {
            return false;
        }
	$this->save();

	return true;
	}




    //Déplacement du fighter

    function doMove($fighterId, $direction)
    {
        // récupérer la position et fixer l'id de travail
        $datas = $this->read(null, $fighterId);      
        
        
        //Vérifier si en fonction de la direction on sort du plateau et si la case est libre
        //Si elle est libre on met a jour les coordonées
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
        
        
        return true;
    }
    
    //Piege mortel
    function deadPiege($fighterId){
        //Obtenir coordonées des pieges
        $tab = $this->query("Select coordinate_x, coordinate_y from surroundings where type='Piege'");
    
        //Lire les données sur le fighter
        $data=$this->read(null,$fighterId);
        
        //Vérifier s'il se trouve sur un piege. 
        //Si il est sur un piège, il meurt
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $data['Fighter']['coordinate_y'] && 
                     $value['coordinate_x']== $data['Fighter']['coordinate_x'])
                  $this->set('current_health', 0);
            }
            
         //Sauver modif
         $this->save();
    }
    
    //Obtenir l'ID du mec attaqué
    function getIdDef($coordonnee_x, $coordonnee_y, $fighterID){
        //Obtenir les autres fighter susceptibles d'être attaqué
        $tab = $this->query("Select * from fighters where id<> $fighterID");
        
        //Vérifier si l'un des fighter est attaqué en fonction de sa position et retourner l'ID du mec attaqué
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $coordonnee_y && 
                     $value['coordinate_x']== $coordonnee_x)
                    return $value['id'];
            }
        
         //Obtenir les infos sur le monstre
        $tab = $this->query("Select * from surroundings where type='Monster'");    
        
        //Renvoyer -1 si le truc attaqué correspond au monstre
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $coordonnee_y && 
                     $value['coordinate_x']== $coordonnee_x)
                    return -1;
            }
        
        
        return false;
    }
	function createAvatar($fighterId,$file){
		$datas= $this->read(null,$fighterId);
		move_uploaded_file($file,"/var/www/html/WebArena/app/Avatar/$fighterId.jpg");

	}
    
    //Fonction faire l'attaque
    function doAttack($fighterId,$direction){
       
       //Lire les info sur le fighter 
       $datas = $this->read(null, $fighterId); 
       
       //Obtenir l'ID du mec qui défend
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
       
       //Si le mec qui défend est en fait le monstre on supprime le monstre et on augmente l'xp
       if($defenderId==-1){
           $this->query("Delete from surrounding where type='Monster'");
           $this->set('xp', $datas['Fighter']['xp']);
           //On sauvegarde
           $this->save();
       }
       
       //Si on a pas détecté de défender, l'attaque est dans le vide 
       if(!$defenderId)
           return false;
       else{
           //Lire les info sur le défenseur
          $datas2 = $this->read(null, $defenderId);
          
          //Aléatoire pour l'attaque
          $a = rand(1 , 20 );     
       
          //Si l'attaque réussie
          if ($a>(10 + $datas2['Fighter']['level'] - $datas['Fighter']['level']))
          {
             //On met a jour la senté du mec attaqué, on sauve, on augmente l'xp de l'attaquant, on sauve
              $this->set('current_health', $datas2['Fighter']['current_health'] - $datas['Fighter']['skill_strength']);
             
              //@todo : Retirer joueur du plateau
              
              //sauver modif
               $this->save();
               $datas = $this->read(null, $fighterId);
               $this->set('xp', $datas['Fighter']['xp']);
               $this->save();
          }
          else{
              return false;
          }
           
           
       }
       
    }
    
    //Ramasser un outil
    function getTools($fighterId,$toolId){
        //Sélection de l'objet par son ID 
        $tab = $this->query("Select * from tools where id == $toolId");
        //lecture du mec qui a ramassé
         $datas = $this->read(null, $fighterId);
         
         //Pour chaque (mais en fait y en a qu'un mais bref, je code avec le cul)
         foreach ($tab as $key) {
            foreach ($key as $value) {

                //en fonction du type d'objet, on augmente le skill avec le bonus de l'objet
                switch ($value['type_bonus']) {
                    case 1:
                        $this->set('skill_strenght',$datas['Fighter']['skill_strenght'] + $value['bonus']);
                        break;
                    case 2:
                        $this->set('skill_sight',$datas['Fighter']['skill_sight'] + $value['bonus']);
                        break;
                    case 3:
                        $this->set('skill_health',$datas['Fighter']['skill_health'] + $value['bonus']);
                        break;
                    case 4: //genre de potion de santé
                        if ($datas['Fighter']['current_health'] + $value['bonus']<=$datas['Fighter']['skill_health'])
                            $this->set('current_health',$datas['Fighter']['current_health'] + $value['bonus']);
                        else
                            $this->set('current_health',$datas['Fighter']['skill_health']);
                        break;
                }
            }
        }
        //On sauve
         $this->save();
    }
    
    //Jeter l'objet 
    function throwTools($fighterId, $toolId){
        //On obtient les info sur l'objet a jeter
        $tab = $this->query("Select * from tools where id == $toolId");
        
        //On lit les infos sur le mec 
        $datas = $this->read(null, $fighterId);
         
        //Pour chaque objet (je code avec le cul y en a qu'un vu la requete)
         foreach ($tab as $key) {
            foreach ($key as $value) {

                //On enlève le bonus.
                switch ($value['type_bonus']) {
                    case 1:
                        $this->set('skill_strenght',$datas['Fighter']['skill_strenght'] -= $value['bonus']);
                        break;
                    case 2:
                        $this->set('skill_sight',$datas['Fighter']['skill_sight'] - $value['bonus']);
                        break;
                    case 3:
                        $this->set('skill_health',$datas['Fighter']['skill_health'] - $value['bonus']);
                        if ($datas['Fighter']['skill_health']<$datas['Fighter']['current_health'])
                            $this->set('current_health',$datas['Fighter']['skill_health']);
                        break;
                }
            }
        }
        
        //On sauve
         $this->save();
    }
	function createAvatar($fighterId,$file){
		$this->read(null,$fighterId);
		imagejpeg($file, 'avatar.jpg');		

	}
    
    

}
