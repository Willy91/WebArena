<?php

App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');


class Player extends AppModel {

	function createNew($mail,$pass){

		$nb = $this->find('count', array('conditions' => array('email =' => $mail)));
	    echo $nb;
	    if ($nb != 0)
		return false;
		$crypass =Security::hash($pass);
		echo $crypass;
		$data=$this->create();
		$data['Player']['email']=$mail;
	    $data['Player']['password']=$crypass;
		return $this->save($data);

	}

	function resetPassword($email){
		$user=$this->find('first',array('conditions' => array('email =' => $email)));
		if($user==false)return false;
		$length = 10;
		$psw=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		$user['Player']['password']=Security::hash($psw);
		$this->save($user);
		return $psw;
	}
	function checkLogin($login,$passwd){
	
	$data = $this->find('first', array('conditions' => array('email =' => $login)));
	
    if ($data == false)
	return false;
	$crypass =Security::hash($passwd);
	if($data['Player']['password']==$crypass)
	return true;
	else 
	return false;
	}


	function getidPlayer($mail)
	{
	
		$data=$this->find('first', array('conditions' => array('email =' => $mail), 'fields' => array('id')));
		return $data['Player']['id'] ;


	}
        
        function getIdFighter($mail){
            $data = $this->find('first', array('conditions' => array('email' => $mail)));
            return $data['Player']['id'];
            
        }
        
        
         public function send_email($dest=null){
         	$pswd=$this->resetPassword($dest);
                $Email = new CakeEmail('gmail');
                $Email->to($dest);/*
                $Email->subject('Automagically generated email');
                $Email->replyTo('matthieu.blais@live.fr');
                $Email->from ('matthieu.blais1@gmail.com');
                $Email->message("dfsdf");
                $Email->send();
        return $this->redirect(array('action' => 'index'));
*/
                $Email->emailFormat('html');
                $Email->template('forgotten_password','email');
                $Email->to($dest);
                $Email->viewVars(array('value' => $pswd));
                $Email->subject('Automagically generated email');
                $Email->from ('abruneau@ece.fr');
                $Email->send();
                
}
        
}

	
