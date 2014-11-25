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
    <table id="sight_table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Type</th>
                <th>X</th>
                <th>Y</th>
            </tr>
        </thead>
 
        <tbody>
            <?php foreach ($result_sight as $item) :?>
                <tr>
                    <td><?php echo $item['Surrounding']['type']; ?></td>
                     <td><?php echo $item['Surrounding']['coordinate_x']; ?></td>
                    <td><?php echo $item['Surrounding']['coordinate_y']; ?></td>
                </tr>

            <?php endforeach;?>
        </tbody>
    </table>
</div>
<h1>Damier</h1>
<table id="damier">
    <thead>
        <tr>
            <?php for($i=0;$i<15;$i++){
                echo "<th>$i</th>";
            }?>
        </tr>
    </thead>
    <tbody>
        <?php for($i=1;$i<14;$i++){
            echo "<tr>";


            echo "<td>$i</td>";
            for ($j=0; $j < 14; $j++) { 
                $set=false;      
                    foreach ($result_sight as $item) {
                        if($item['Surrounding']['coordinate_y']==$j && $item['Surrounding']['coordinate_x']==$i){
                            $value = $item['Surrounding']['type'];
                            echo "<td><img src=\"../img/$value.png\"></td>";
                            $set=true;
                        }
                    }
                   foreach ($result_tool as $item) {
                        if($item['Tool']['coordinate_y']==$j && $item['Tool']['coordinate_x']==$i){
                            $value = $item['Tool']['type'];
                            echo "<td><img src=\"../img/$value.png\"></td>";
                            
                            $set=true;
                        }
                    }
                    if($me['Fighter']['coordinate_y']==$j && $me['Fighter']['coordinate_x']==$i){
                        echo "<td><img src=\"../img/Warrior.png\"></td>";
                        $set=true;
                    }
                    if($set==false){
                        echo "<td></td>";
                    }
                }
            }
            echo "</tr>";
        ?>

    </tbody>
</table>
