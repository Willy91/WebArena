<?php
    echo $this->Form->create('CreateFighter', array('class' => 'form-horizontal'));
    echo $this->Form->input('name');
    echo $this->Form->submit('Create New Fighter', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>