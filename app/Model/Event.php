        <?php

App::uses('AppModel', 'Model');

class Event extends AppModel {
    
    public $uses = array('Fighter');    
    
    function doAttackEvent($def, $fighter){

        
        $name = $fighter['Fighter']['name'] . " attacked " . $def['Fighter']['name'] . " and touched him";
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$fighter['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$fighter['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    function killAttackEvent($def, $fighter){

        
        $name = $fighter['Fighter']['name'] . " attacked " . $def['Fighter']['name'] . " and killed him";
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$fighter['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$fighter['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }


    function NobodyAttackEvent($data){
      $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " attacked in a wrong way";
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);


    }
    
    function failAttackEvent($data, $data2){
        
        $name = $data['Fighter']['name'] . " attacked " . $data2['Fighter']['name'] . " but he missed him";
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    function newFighterEvent($data){
         
        $name = "Entrée de " . $data['Fighter']['name'];
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    function getToolEvent($data, $data2){
       
        
        $name = $data['Fighter']['name'] . " ramasse un nouvel objet : " . $data2['Tool']['type'];
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    function joinGuildEvent($data, $data2){
        
        
        $name = $data['Fighter']['name'] . " rejoint " . $data2;
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    
    function newGuildEvent($idFighter, $nameGuild){
        //$data = $this->Fighter->findById($idFighter);
        
        $name = $data['Fighter']['name'] . " crée une nouvelle guilde sous le nom de " . $nameGuild;
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    function newDeathEvent($data){
       // $data = $this->Fighter->findById($idFighter);
        
        $name = $data['Fighter']['name'] . " est mort ";
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        //echo date("d-m-Y H-i-s");
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    function Crier($data, $Name){
        
       pr($Name);
        
        $data2 = $this->create();
        $data2['Event']['name'] = $data['Fighter']['name']." screams ".$Name;
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);
    }
    
    
    //In order to get the events in last 24 hours.
    function getEvent($data_fighter){
        
        $date_lim = date ("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")-1,date("Y")));
        
        $data = $this->find('all', array('conditions' => array ("date >" => $date_lim)));        
        
       $x = $data_fighter['Fighter']['coordinate_x'];
       $y = $data_fighter['Fighter']['coordinate_y'];
       
      
       $nb = 0;
       $tab = array();
       foreach($data as $key){
           
           $sight_x = $key['Event']['coordinate_x']-$x;
           if ($sight_x<0)
               $sight_x = $sight_x*(-1);
           $sight_y = $key['Event']['coordinate_y']-$y;
           if ($sight_y<0)
               $sight_y = $sight_y*(-1);
           $total = $sight_x+$sight_y;
          
           if ($total<=$data_fighter['Fighter']['skill_sight']){
                $tab[$nb]=$key;
                $nb++;
           }
             
       }
       
       return $tab;
       
    }

    function MoveEvent($data,$direction){
        //$data = $this->Fighter->findById($idFighter);

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " moved to " . $direction;
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);
    }
    
    function FailMove($data,$direction){
       

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " failed to move to " . $direction;
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);

    }

    function TrapEvent($data){
        //$data = $this->Fighter->findById($idFighter);

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " walked on a trap";
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);

    }

    function MonsterEvent($data){
        //$data = $this->Fighter->findById($idFighter);

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " killed the monster";
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);

    }
    function DeathMonsterEvent($data){
    $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " has been killed by the monster";
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);


    }

    

    function UplevelEvent($idFighter){
        $data = $this->Fighter->findById($idFighter);

        $data2 = $this->create();
        
        $data2['Event']['name'] = $data['Fighter']['name'] . "vient de gagner un niveau! Niveau ". $data['Fighter']['level'];
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);


    }



}