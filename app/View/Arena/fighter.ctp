<?php
    echo $this->Form->create('CreateFighter', array('class' => 'form-group'));
    echo $this->Form->input('name',array('class'=>'form-control'));
    echo $this->Form->submit('Create New Fighter', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
  

   echo $this->Form->create('PassLvl', array('class'=>'form-group'));
    echo $this->Form->input('Choose a skill to upgrade : ',array('options' => array('sight'=>'sight+1','strength'=>'strength		+1','health'=>'health+3'), 'default' => 'sight+1'));
        echo $this->Form->submit('Upgrade', array('class' => 'btn btn-success'));
    echo $this->Form->end();

?>
