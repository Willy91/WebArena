<?php echo $this->Form->create('CreateFighter', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
<div class="form-group">
    <label class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10"><?php echo $this->Form->input('name', array('class' => 'form-control'));?></div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <?php echo $this->Form->submit('Create New Fighter', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end();

echo $this->Form->create('PassLvl', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
<div class="form-group">
    <label class="col-sm-2 control-label">Choose Skill</label>
    <div class="col-sm-10">
        <?php echo $this->Form->input('Choose a skill to upgrade',array('options' => array('sight'=>'sight+1','strength'=>'strength        +1','health'=>'health+3'), 'default' => 'sight+1', 'class' => 'form-control'));?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo $this->Form->submit('Upgrade', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
