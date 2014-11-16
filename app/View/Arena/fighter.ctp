<?php
    echo $this->Form->create('CreateFighter', array('class' => 'form-horizontal'));
    echo $this->Form->input('name');
    echo $this->Form->submit('Create New Fighter', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
  

   echo $this->Form->create('PassLvl');
    echo $this->Form->input('Choose a skill to upgrade',array('options' => array('sight'=>'sight+1','strength'=>'strength		+1','health'=>'health+3'), 'default' => 'sight+1'));
    echo $this->Form->end('Upgrade');

?>
