<div class="panel panel-primary">
    
    <div class="panel-heading text-center"><h1>Board</h1></div>

    <div class="panel-body">
        <div class="col-sm-5">
<div class="panel panel-default">
     <div class="panel-heading">Actions</div>
  <div class="panel-body">
      <div class="col-sm-10 col-sm-offset-1">
    <?php echo $this->Form->create('Fightermove', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>

    <div class="form-group">
        <label class="control-label">Direction</label>
        <div class="text-center"><?php echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east', 'class' => 'form-control'));?>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
        <?php echo $this->Form->submit('Move', array('class' => 'btn btn-primary'));?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
        
    <?php echo $this->Form->create('FighterAttack', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
    <div class="form-group">
        <label class="control-label">Direction</label>
        <div class="text-center"><?php echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east', 'class' => 'form-control'));?>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
        <?php echo $this->Form->submit('Attack', array('class' => 'btn btn-primary'));?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    
    <?php echo $this->Form->create('Scream', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
    <div class="form-group">
        <label class="control-label">Scream</label>
        <div class="text-center"><?php echo $this->Form->input('name', array('class' => 'form-control'));?>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
        <?php echo $this->Form->submit('Scream', array('class' => 'btn btn-primary'));?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    </div>
  </div>
</div>
</div>

<div class="col-sm-7">
    <table id="sight_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Type</th>
                <th>Distance</th>
            </tr>
        </thead>
 
        <tbody>
            <?php foreach ($result_sight as $item) :?>
                <tr>
                    <td><?php echo $item['Surrounding']['type']; ?></td>
                     <td><?php echo $item['Distance']; ?></td>
                    
                </tr>

            <?php endforeach;?>
        </tbody>
    </table>
</div>
<div class="col-sm-12">        
<h1>Damier</h1>
<table id="damier" class="dataTable">
    
        <?php for($i=0;$i<10;$i++){
            echo "<tr>";


            for ($j=0; $j < 14; $j++) { 
                $set=false;      
                $abs=9-$i;

                    foreach ($result_sight as $item) {
                        if($item['Surrounding']['coordinate_y']==$j && $item['Surrounding']['coordinate_x']==($abs)){
                            $value = $item['Surrounding']['type'];
                            echo "<td>$abs $j <img src=\"../img/$value.png\"></td>";
                            $set=true;
                        }
                    }
                   foreach ($result_tool as $item) {
                        if($item['Tool']['coordinate_y']==$j && $item['Tool']['coordinate_x']==($abs)){
                            $value = $item['Tool']['type'];
                            echo "<td>$abs $j<img src=\"../img/$value.png\"></td>";
                            
                            $set=true;
                        }
                    }
                    foreach ($result_fighter as $item) {
                        if($item['Fighter']['coordinate_y']==$j && $item['Fighter']['coordinate_x']==($abs)){
                            $id=$item['Fighter']['id'].".jpg";
                            echo "<td>$abs $j";
                            echo $this->Html->image($id,array('width' => "60",'height'=>"57" ));
                            echo "</td>";
                            $set=true;
                        }
                    }
  
                    if($set==false){
                        echo "<td>$abs $j<img src=\"../img/case.png\"></td>";
                    }
                }
            }
            echo "</tr>";
        ?>

    
</table>
</div>
    </div>
</div>