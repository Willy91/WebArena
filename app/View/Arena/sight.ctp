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
    
    <div class="form-group">  
        <div class="text-center">
        <?php echo $this->Form->create('Tool', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?> 
        <?php echo $this->Form->input('Skill',array('type' => 'hidden'));?>
            <?php echo $this->Form->submit('Tool', array('class' => 'btn btn-primary'));?>
        <?php echo $this->Form->end(); ?>
        </div>
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
                
                    <?php if($item['Surrounding']['type']=="Colonne"){
                        echo "<tr><td>";
                        echo $item['Surrounding']['type']; echo "</td><td>";
                    echo $item['Distance']; echo "</td></tr>";} ?>
                
            <?php endforeach;?>
            <?php if($neartrap==true) echo "<tr><td>Brise suspecte</td><td>1</td></tr>" ?>
                <?php if($nearmonster==true) echo "<tr><td>Puanteur</td><td>1</td></tr>" ?>
        <?php foreach ($result_tool as $item2) :?>
            <?php 
                        echo "<tr><td>";
                        echo $item2['Tool']['type']; echo "</td><td>";
                    echo $item2['Distance']; echo "</td></tr>"; ?>
                
            <?php endforeach;?>
          <?php foreach ($result_fighter as $item3) : if ($item3['Fighter']['id']!= $idF){?>
            <?php 
                        echo "<tr><td>";
                        echo $item3['Fighter']['name']; echo "</td><td>";
                    echo $item3['Distance']; echo "</td></tr>"; ?>
                
          <?php }endforeach;?>  
        
        </tbody>
    </table>

</div>
<div class="col-sm-12">        
<h1>Damier</h1>
<table id="damier" class="dataTable">
    <?php for($i=0;$i<Configure::read('Longueur_y');$i++){
    echo "<tr>";
    for ($j=0; $j < Configure::read('Largeur_x'); $j++) {
        $set=false;
        $abs=Configure::read('Longueur_y')-1-$i;
        echo "<td>";
        foreach ($result_fighter as $item) {
            if($item['Fighter']['coordinate_x']==$j && $item['Fighter']['coordinate_y']==($abs)){
                $id=$item['Fighter']['id'].".jpg";
                $name=$item['Fighter']['name'];
                echo $this->Html->image($id,array('width' => "60",'height'=>"57",'data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>"$name" ));
                $set=true;
            }
        }
        foreach ($result_sight as $item) {
            if($item['Surrounding']['coordinate_x']==$j && $item['Surrounding']['coordinate_y']==($abs) && $item['Surrounding']['type']=="Colonne" && $set==false){
                $value = $item['Surrounding']['type'];
                echo "<img src=\"../img/$value.png\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"$value\" href=\"#\">";
                $set=true;
            }
        }
        foreach ($result_tool as $item) {
            if($item['Tool']['coordinate_x']==$j && $item['Tool']['coordinate_y']==($abs) && $set==false){
                $value = $item['Tool']['type'];
                echo "<img src=\"../img/$value.png\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"$value\" href=\"#\">";
                $set=true;
            }
        }
        if($set==false){
            echo "<img src=\"../img/case.png\">";
        }
        echo "</td>";
    }
}
echo "</tr>";
?>
</table>
</div>
    </div>
</div>