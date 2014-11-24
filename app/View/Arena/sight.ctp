<?php
    echo $this->Form->create('Fightermove', array('class' => 'form-group'));
    echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
    echo $this->Form->submit('Move', array('class' => 'btn btn-primary'));
    echo $this->Form->end();

    echo $this->Form->create('FighterAttack', array('class' => 'form-group'));
    echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
    echo $this->Form->submit('Attack', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?> 	
