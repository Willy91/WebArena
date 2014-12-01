        <?php

App::uses('AppModel', 'Model');

class Event extends AppModel {
    
    public $uses = array('Fighter');    
    
    function doAttackEvent($data, $data2){
        $fighter = $this->Fighter->findById($data);
      //  $data2 = $this->Fighter->findById($idDefender);
        
        $name = $fighter['Fighter']['name'] . " attaque " . $data2['Fighter']['name'] . " et le touche";
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$fighter['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$fighter['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }


    function NobodyAttackEvent($data){
      $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " attaque dans le vent";
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);


    }
    
    function failAttackEvent($idFighter, $idDefender){
        $data = $this->Fighter->findById($idFighter);
        $data2 = $this->Fighter->findById($idDefender);
        
        $name = $data['Fighter']['name'] . " attaque " . $data2['Fighter']['name'] . " mais le rate";
        
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
    
    function getToolEvent($idFighter, $idTool){
        $data = $this->Fighter->findById($idFighter);
        $data2 = $this->Tool->findById($idTool);
        
        $name = $data['Fighter']['name'] . " ramasse un nouvel objet : " . $data2['Tool']['type'];
        
        $new = $this->create();
        $new['Event']['name'] = $name;
        $new['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $new['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $new['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($new);
        
    }
    
    function joinGuildEvent($idFighter, $idGuid){
        $data = $this->Fighter->findById($idFighter);
        $data2 = $this->Guild->findById($idGuid);
        
        $name = $data['Fighter']['name'] . " rejoint " . $data2['Guild']['name'];
        
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
    function getEvent(){
        
        $date_lim = date ("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")-1,date("Y")));
        
        $tab = $this->find('all', array('conditions' => array ("date >" => $date_lim)));        
        
        return $tab;
    }

    function MoveEvent($data,$direction){
        //$data = $this->Fighter->findById($idFighter);

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " moves to " . $direction;
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);
    }
    
    function FailMove($data,$direction){
       

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . " fails to move to " . $direction;
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);

    }

    function TrapEvent($data){
        //$data = $this->Fighter->findById($idFighter);

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . "déclenche un piège";
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);

    }

    function MonsterEvent($data){
        //$data = $this->Fighter->findById($idFighter);

        $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . "a tué un monstre";
        $data2['Event']['coordinate_x']=$data['Fighter']['coordinate_x'];
        $data2['Event']['coordinate_y']=$data['Fighter']['coordinate_y'];
        $data2['Event']['date'] = date("Y-m-d H:i:s");
        $this->save($data2);

    }
    function DeathMonsterEvent($data){
    $data2 = $this->create();

        $data2['Event']['name'] = $data['Fighter']['name'] . "a été tué par un monstre";
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