<h1>Guild</h1>
<div class="col-md-4">
<?php echo $this->Form->create('CreateGuild', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
<div class="form-group">
    <label class="col-sm-2 control-label">Guild's Name</label>
    <div class="col-sm-10"><?php echo $this->Form->input('name', array('class' => 'form-control'));?></div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <?php echo $this->Form->submit('Create New Guild', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end();?>


<?php echo $this->Form->create('JoinGuild', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
<div class="form-group">
    <label class="col-sm-2 control-label">Guild's Name</label>
    <div class="col-sm-10"><?php echo $this->Form->input('name', array('class' => 'form-control'));?></div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <?php echo $this->Form->submit('Join Guild', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end();?>
</div>
<div class="col-md-8">
    <h3>Your Guild : <?php echo $name_guild ?></h3>
    <table id="guild_table" class="display" cellspacing="0" width="100%">
    <thead>
            <tr>
                <th>Name</th>
                <th>Number of members</th>
            </tr>
        </thead>
    <tbody>
            <?php foreach ($result_guild as $item) :?>
                <tr>
                    <td><?php echo $item['Guild']['name']; ?></td>
                     <td><?php echo $item['Nb']; ?></td>
                </tr>

            <?php endforeach;?>
    </tbody>
    </table>
</div>