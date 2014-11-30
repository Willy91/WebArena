  <?php

App::uses('AppModel', 'Model');

define("POINT", 3);
define("DELAI", 10);

class Fighter extends AppModel {

    public $displayField = 'name';
    public $uses = array('Surrounding','Event');
    public $belongsTo = array(

        'Player' => array(

            'className' => 'Player',

            'foreignKey' => 'player_id',

        ),

    );
    
    function add($playerId, $name) {

        if($this->find('count', array("conditions" => array('name' => $name, 'player_id' => $playerId)))==0){
        $data = array(
            'name' => $name,
            'player_id' => $playerId,
            'level' => 1,
            'xp' => 0,
            'skill_sight' => 0,
            'skill_strength' => 1,
            'skill_health' => 3,
            'current_health' => 3
        );

        $pos = $this->InitPosition();
        
        $data['coordinate_x'] = $pos[0];
        $data['coordinate_y'] = $pos[1];
        // prepare the model for adding a new entry
        $this->create();

        // save the data
        return $this->save($data);
        }
        else
            return false;
    }

    function getSeen($id){
      $user=$this->findById($id);
      $x=$user['Fighter']['coordinate_x'];
      $y=$user['Fighter']['coordinate_y'];

      $data2 = $this->find('all');
       $nb = 0;
       $tab = array();
       foreach($data2 as $key){
           $sight_x = $key['Fighter']['coordinate_x']-$x;
           if ($sight_x<0)
               $sight_x = $sight_x*(-1);
           $sight_y = $key['Fighter']['coordinate_y']-$y;
           if ($sight_y<0)
               $sight_y = $sight_y*(-1);
           $total = $sight_x+$sight_y;
          
           if ($total<=$user['Fighter']['skill_sight'] && $key['Fighter']['id']==NULL){
                echo $total . " ";
               $key['Distance']=$total;
                $tab[$nb]=$key;
               $nb++;
           }
               
       }
       $tab[$nb]=$user;
       //array_push($tab,$user);
       return $tab;
    }
    function checkPosition($coordonnee_x, $coordonnee_y, $fighterId)
    {
        $a = false;
        $tab = $this->query("Select coordinate_x, coordinate_y from fighters where id <> $fighterId");
   
        foreach($tab as $key)
            foreach($key as $value){
                if ($value['coordinate_y']== $coordonnee_y && $value['coordinate_x']== $coordonnee_x)
                  $a = true;  
            }
        
        
        $tab = $this->query("Select coordinate_x, coordinate_y from surroundings where type='Colonne'");
        
        foreach($tab as $key)
            foreach($key as $value){
                pr($value);
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

        if ($direction == 'north') {

            if ($datas['Fighter']['coordinate_x']+1<15 && !$this->checkPosition($datas['Fighter']['coordinate_x']+1, $datas['Fighter']['coordinate_y'], $fighterId))
            {
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + 1);
            //$Even->MoveEvent($fighterId,$direction);
            }
            else
              return false;
        } 
        elseif ($direction == 'south') {
            if ($datas['Fighter']['coordinate_x']-1>=0 && !$this->checkPosition($datas['Fighter']['coordinate_x']-1, $datas['Fighter']['coordinate_y'], $fighterId))
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] - 1);
          else 
            return false;
            //$Even->MoveEvent($fighterId,$direction);
        } 
        elseif ($direction == 'east') {
            if ($datas['Fighter']['coordinate_y']+1<10 && !$this->checkPosition($datas['Fighter']['coordinate_x'], $datas['Fighter']['coordinate_y']+1, $fighterId))
            
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] + 1);
            else 
              return false;
            //$Even->MoveEvent($fighterId,$direction);
          
        } 
        elseif ($direction == 'west') {

            if ($datas['Fighter']['coordinate_y']-1>=0 && !$this->checkPosition($datas['Fighter']['coordinate_x'], $datas['Fighter']['coordinate_y']-1, $fighterId))
            
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] - 1);
            //$Even->MoveEvent($fighterId,$direction);
            else 
              return false;
        } 
        

        // sauver la modif
        $this->save();


return true;
}
    

    //Obtenir l'ID du mec attaqué
    function getIdDef($coordonnee_x, $coordonnee_y, $fighterID){
        //Obtenir les autres fighter susceptibles d'être attaqué
        $tab = $this->query("Select * from fighters where id<> $fighterID and current_health>0");
        
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
           return 3;
       
       //Si le mec qui défend est en fait le monstre on supprime le monstre et on augmente l'xp
       if($defenderId==-1){
           $this->query("Delete from surrounding where type='Monster'");
           $this->set('xp', $datas['Fighter']['xp']);
           //On sauvegarde
           $this->save();
       }
       
       //Si on a pas détecté de défender, l'attaque est dans le vide 
       if(!$defenderId)
           return 1;
       else{
           
           //Lire les info sur le défenseur
          $datas2 = $this->read(null, $defenderId);
          
          if($datas['Fighter']['guild_id']!=NULL)
               $attackBonus = $this->getAttackBonus($datas['Fighter']['guild_id'],$datas2, $fighterId);
          
          echo "Attack $attackBonus";
          //Aléatoire pour l'attaque
          $a = rand(1 , 20 ) + $attackBonus;     
       
          //Si l'attaque réussie
          if ($a>(10 + $datas2['Fighter']['level'] - $datas['Fighter']['level']))
          {
             
              $xp=1;
              //On met a jour la senté du mec attaqué, on sauve, on augmente l'xp de l'attaquant, on sauve
              $this->set('current_health', $datas2['Fighter']['current_health'] - $datas['Fighter']['skill_strength']);
             echo "Current_health". $datas2['Fighter']['current_health'];
              //@todo : Retirer joueur du plateau
              if ($datas2['Fighter']['current_health'] - $datas['Fighter']['skill_strength']<=0){
                  $this->set('current_health', 0);
                  $xp=$xp+$datas2['Fighter']['level'];
              }
                  
              //sauver modif
               $this->save();
               $datas = $this->read(null, $fighterId);
               $this->set('xp', $datas['Fighter']['xp']+$xp);
               $this->save();
               return 2;
          }
          else{
              return false;
          }
           
           
       }
       
    }
    
    function getAttackBonus($guild_id, $defender, $idAttack){
        $data=$this->find('all', array('conditions' => array('guild_id' => $guild_id, 'Fighter.id !=' => $idAttack)));
        $bonus = 0;
        foreach($data as $key){
            if(($key['Fighter']['coordinate_x']==$defender['Fighter']['coordinate_x']+1 && $key['Fighter']['coordinate_y']==$defender['Fighter']['coordinate_y'])
                    || ($key['Fighter']['coordinate_x']==$defender['Fighter']['coordinate_x']- 1 && $key['Fighter']['coordinate_y']==$defender['Fighter']['coordinate_y'])
                    || ($key['Fighter']['coordinate_x']==$defender['Fighter']['coordinate_x'] && $key['Fighter']['coordinate_y']+1==$defender['Fighter']['coordinate_y'])
                    || ($key['Fighter']['coordinate_x']==$defender['Fighter']['coordinate_x'] && $key['Fighter']['coordinate_y']-1==$defender['Fighter']['coordinate_y']))
                $bonus++;
            
        }
        return $bonus;
    }
    
    function InitPosition(){
        
         $array = array();
        
        //Tableau pour éviter qu'un mec soit bloqué par tous les poteaux autours de lui
       for ($i=0; $i<10; $i++){
           for ($j=0; $j<15;$j++){
               $array[$i][$j] = true;
           }
       }
       
       $tab = $this->query("Select coordinate_x, coordinate_y from surroundings");
       
       //On marque indispo les cases occupées par les colonnes
        foreach($tab as $key)
            foreach($key as $value){
               $array[$value['coordinate_y']][$value['coordinate_x']]= false;
            }
              
       $data = $this->find('all');
       
       
        
        foreach($data as $key)
           // foreach($key as $value){
               if ($key['Fighter']['current_health']>0)
               $array[$key['Fighter']['coordinate_y']][$key['Fighter']['coordinate_x']]= false;
           // }
        
        $fin = false;
        $pos = array();
      do{
          $pos[0] = rand(0,14);
          $pos[1] = rand(0,9);

        if ($array[$pos[1]][$pos[0]]==true)
            $fin = true;
          
      }while(!$fin);
      
      return $pos;
    }
    
     //Function to join a guild by its name
    function joinGuild($idFighter, $idGuild){
        $data=$this->findById($idFighter);
        $data['Fighter']['guild_id']= $idGuild;
        return $this->save($data);
    }
    
    //Function revive for a dead figther
    function reviveFighter($idFighter){
        $data = $this->findById($idFighter);
        
        if($data['Fighter']['current_health']==0){
           $data['Fighter']['level'] = 1;
           $data['Fighter']['xp'] = 0;
           $data['Fighter']['skill_sight'] = 0;
           $data['Fighter']['skill_strenght'] = 1;
           $data['Fighter']['skill_health'] = 3;
           $data['Fighter']['current_health'] = 3;
           $tab = $this->InitPosition();
           $data['Fighter']['coordinate_x'] = $tab[0];
           $data['Fighter']['coordinate_y'] = $tab[1];
           $data['Fighter']['next_action_time'] = "0000-00-00 00:00:00";
           return $this->save($data);
        }
        else return false;
    }

    function getFighterview($idFighter){
        return $this->findById($idFighter);
    }
    
    function getFighterId($name, $player){
        $data = $this->find('first', array('conditions'=> array('name'=> $name, 'player_id'=>$player)));
    
        return $data['Fighter']['id'];
    }
    
    function getAllFighterviewPlayer($idPlayer){
        return $this->find('all', array('conditions' => array('player_id like' => $idPlayer)));
    }
    
    function getAllFighterview(){
        return $this->find('all');
    }
    
    function deathFromSurrounding($idFighter, $bool){
        if ($bool == true){
            $data = $this->findById($idFighter);
            $data['Fighter']['current_health'] = 0;
            $this->save($data);
        }
    }
    
   
    
    function getFighterUser($idUser){
        return $this->find('all', array('conditions'=>array('player_id'=>$idUser)));
    }
    
    function Action($nb, $fighterId){
        $data=$this->findById($fighterId);
        
        if(date("Y-m-d H:i:s")<=$data['Fighter']['next_action_time'])
                return false;
        else{
        
        
        if (date("Y-m-d H:i:s")>($data['Fighter']['next_action_time']+mktime(date("H"),date("i"),date("s")+2*DELAI,date("m"),date("d"),date("Y"))))
            $nb--;
        if (date("Y-m-d H:i:s")>($data['Fighter']['next_action_time']+mktime(date("H"),date("i"),date("s")+3*DELAI,date("m"),date("d"),date("Y"))))
            $nb--;  
        if (date("Y-m-d H:i:s")>($data['Fighter']['next_action_time']+mktime(date("H"),date("i"),date("s")+DELAI,date("m"),date("d"),date("Y")))){
            $nb--;
            $data['Fighter']['next_action_time'] = date("Y-m-d H:i:s");
        }    
        
        if($nb<0)
            $nb=0;
        
        $nb++;
        if ($nb==POINT){
            $data['Fighter']['next_action_time']=date ("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s")+DELAI,date("m"),date("d"),date("Y")));
            $this->save($data);
        }
        return $nb;
    }
    }
    
    function getFighterSight($data){
       $x = $data['Fighter']['coordinate_x'];
       $y = $data['Fighter']['coordinate_y'];
       
       $data2 = $this->find('all');
       $nb = 0;
       $tab = array();
       foreach($data2 as $key){
           $sight_x = $key['Fighter']['coordinate_x']-$x;
           
           if ($sight_x<0)
               $sight_x = $sight_x*(-1);
           $sight_y = $key['Fighter']['coordinate_y']-$y;
           if ($sight_y<0)
               $sight_y = $sight_y*(-1);
           echo " sighty ".$sight_y. " sightx " . $sight_x;
           $total = $sight_x+$sight_y;
            echo " total ".$total;
           if ($total<=$data['Fighter']['skill_sight'] && $key['Fighter']['current_health']>0 && $data['Fighter']['id']!=$key['Fighter']['id']){
               $key['Distance']=$total;
               $tab[$nb]=$key;
               $nb++;
           }
               
       }
       
       return $tab;
       
   }

   
   function getNbFighterFromPlayer($idPlayer){
       $nb = $this->find('count', array('conditions' => array('player_id' => $idPlayer)));
       return $nb;
   }
   
   function getRankFighter(){
       return $this->find('all', array('order' => array('level'=>'desc')));
   }

   function getNbGuild($idGuild){
       echo $idGuild;
        return $this->find('count', array('conditions'=>array('guild_id'=>$idGuild)));
    }
    
   function getIdGuild($idFighter){
       $data = $this->findById($idFighter);
       return $data['Fighter']['guild_id'];
   }
   
   
}
