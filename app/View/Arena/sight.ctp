<h1>Board</h1>
<div class="col-md-2">
    <?php echo $this->Form->create('Fightermove', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>

    <div class="form-group">
        <label class="col-sm-5 control-label">Direction</label>
        <div class="col-sm-7"><?php echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east', 'class' => 'form-control'));?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-7">
        <?php echo $this->Form->submit('Move', array('class' => 'btn btn-primary'));?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
        
    <?php echo $this->Form->create('FighterAttack', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
    <div class="form-group">
        <label class="col-sm-5 control-label">Direction</label>
        <div class="col-sm-7"><?php echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east', 'class' => 'form-control'));?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-7">
        <?php echo $this->Form->submit('Attack', array('class' => 'btn btn-primary'));?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<div class="col-md-10">
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Type</th>
                <th>X</th>
                <th>Y</th>
            </tr>
        </thead>
 
 
        <tbody>
            <?php foreach ($result_array as $item) :?>
                <tr>
                    <td><?php echo $item['Surrounding']['id']; ?></td>
                    <td><?php echo $item['Surrounding']['type']; ?></td>
                     <td><?php echo $item['Surrounding']['coordinate_x']; ?></td>
                    <td><?php echo $item['Surrounding']['coordinate_y']; ?></td>
                <tr>

            <?php endforeach;?>
        </tbody>
    </table>
</div>
