<?php

App::uses('AppModel', 'Model');

class Message extends AppModel {

    
    function sendMessage($data,$sender, $dest){
        
        $data2 = $this->create();
        
        $data2['Message']['date'] = date("Y-m-d H:i:s");
        $data2['Message']['title'] = $data['title'];
        $data2['Message']['message']=$data['message'];
        $data2['Message']['fighter_id_from'] = $sender;
        $data2['Message']['fighter_id'] = $dest['Fighter']['id'];
        
        $this->save($data2);
        
    }
    
    function getAllMessage($idFighter){
        
        return $this->find('all', array('constraints', array('fighter_id' => $idFighter)));
        
        
    }
    
    
    
    
    
    
    
    
}