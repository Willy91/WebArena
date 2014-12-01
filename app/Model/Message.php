<?php

App::uses('AppModel', 'Model');

class Message extends AppModel {

    public $belongsTo = array(

        'Fighter' => array(

            'className' => 'Fighter',

            'foreignKey' => 'fighter_id_from',

        ),

    );
    
    
    function sendMessage($data,$sender, $dest){
        
        $data2 = $this->create();
        
        $data2['Message']['date'] = date("Y-m-d H:i:s");
        $data2['Message']['title'] = $data['title'];
        $data2['Message']['message']=$data['message'];
        $data2['Message']['fighter_id_from'] = $sender;
        $data2['Message']['fighter_id'] = $dest['Fighter']['id'];
        
        return $this->save($data2);
        
    }
    
    function getAllMessage($idFighter){
        
        return $this->find('all', array('conditions'=> array('fighter_id' => $idFighter), 'order' => array('date DESC')));
        
        
    }
    
    function getAllMessageSent($idFighter){
        
        return $this->find('all', array('conditions'=> array('fighter_id_from' => $idFighter), 'order' => array('date DESC')));
        
        
    }
    
    function MessageSentforView($tab1, $tab2){
        $data = array();
        $n=0;
        foreach ($tab1 as $key){
            foreach($tab2 as $fighter){
                if($fighter['Fighter']['id']==$key['Message']['fighter_id']){
                    $data[$n]= array('date'=>$key['Message']['date'], 'to' => $fighter['Fighter']['name'], 'title' => $key['Message']['title'], 'mes'=> $key['Message']['message']);
                    $n++;
                    
                }
            }
        }
        return $data;
    }
    
    
    
    
}