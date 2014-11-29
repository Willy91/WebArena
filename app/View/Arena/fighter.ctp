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

<?php echo $this->Form->create('UploadPicture',array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false))); ?>
<div class="form-group">
    <label class="col-sm-2 control-label">Change Avatar</label>
    <div class="col-sm-10"><?php echo $this->Form->file('avatar'); ?></div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10"><?php echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php $this->Form->end(); ?>

<div class="col-md-4">
    <table id="guild_table" class="display" cellspacing="0" width="100%">
        <tr>
            <th>Name</th>
            <td><?php echo $table_fighter['Fighter']['name']?></td>
        </tr>
        <tr>
            <th>Position X</th>
            <td><?php echo $table_fighter['Fighter']['coordinate_x']?></td>
        </tr>
        <tr>
            <th>Position Y</th>
            <td><?php echo $table_fighter['Fighter']['coordinate_y']?></td>
        </tr>
        <tr>
            <th>Level</th>
            <td><?php echo $table_fighter['Fighter']['level']?></td>
        </tr>
        <tr>
            <th>Xp</th>
            <td><?php echo $table_fighter['Fighter']['xp']?></td>
        </tr>
        <tr>
            <th>Capacité de vue</th>
            <td><?php echo $table_fighter['Fighter']['skill_sight']?></td>
        </tr>
        <tr>
            <th>Force</th>
            <td><?php echo $table_fighter['Fighter']['skill_strength']?></td>
        </tr>
        <tr>
            <th>Santé totale</th>
            <td><?php echo $table_fighter['Fighter']['skill_health']?></td>
        </tr>
        <tr>
            <th>Santé actuelle</th>
            <td><?php echo $table_fighter['Fighter']['current_health']?></td>
        </tr>
            
        
        
        
    </table>  
    
</div>
    
