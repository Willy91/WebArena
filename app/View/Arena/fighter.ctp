<div class="col-sm-12 text-center">
    <div id="myCarousel" class="carousel slide panel panel-primary col-sm-6" data-interval="false" data-ride="carousel">

    
    <div class="carousel-inner">
     <?php $i=0;?>   
    <?php foreach ($table_fighter2 as $table_fighter) :?>
        
        <?php if ($i==0):
            $i = 1;
            $var = "active item";
        else:
            $var = "item";
        endif;?>
        
        
       
<div class="<?php echo $var?>">
        
    <h3><div class="car"><?php echo $table_fighter['Fighter']['name']?></div></h3>
        
    
    
    
<div class="panel-body">

<div class="col-sm-6 ">
    <table id="guild_table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
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
            <th>Sight Skill</th>
            <td><?php echo $table_fighter['Fighter']['skill_sight']?></td>
        </tr>
        <tr>
            <th>Strenght</th>
            <td><?php echo $table_fighter['Fighter']['skill_strength']?></td>
        </tr>
        <tr>
            <th>Health</th>
            <td><?php echo $table_fighter['Fighter']['skill_health']?></td>
        </tr>
        <tr>
            <th>Current Health</th>
            <td><?php echo $table_fighter['Fighter']['current_health']?></td>
        </tr>
            
        
        
        
    </table>  
    
           
</div>
    
    <div class="col-md-6">
        <div class="text-center ">
        <?php $a = $table_fighter['Fighter']['id'].".jpg";
        echo $this->Html->image($a, array('alt' => 'CakePHP', 'width' => '200', 'height' => '200'));?>
        
        </div>
</div>
</div>
</div>
        <?php endforeach;?>
</div>
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">

        <span class="glyphicon glyphicon-chevron-left"></span>

    </a>

    <a class="carousel-control right" href="#myCarousel" data-slide="next">

        <span class="glyphicon glyphicon-chevron-right"></span>

    </a>
    
    
    </div>

<!-- -->
<div class="col-md-6" >
       
        
    
    
    <div class="col-md-12">
        
        <div class="panel panel-default">
  <div class="panel-heading text-center"><?php foreach($table_fighter2 as $table_fighter){
      if ($table_fighter['Fighter']['id'] == $fighter){
          echo $table_fighter['Fighter']['name'];
      }
  }?>
 </div>
  <div class="panel-body">
      
       <?php echo $this->Form->create('Upload',array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false))); ?>
<div class="form-group">

    <div class="col-md-10"><?php echo $this->Form->file('avatar'); ?></div>
</div>
<div class="form-group">
    <div class="col-md-12 text-center"><?php echo $this->Form->submit('Upload Avatar', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php $this->Form->end(); ?>
      
      
    <?php
echo $this->Form->create('PassLvl', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
<div class="form-group">
    
    <div class="col-md-12 text-center">
        <?php echo $this->Form->input('Skill',array('options' => array('sight'=>'sight','strength'=>'strength        ','health'=>'health'), 'default' => 'sight', 'class' => 'form-control'));?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-12 text-center">
        <br>
        <?php echo $this->Form->submit('Upgrade Level', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
  </div>
          
            <?php
echo $this->Form->create('ReviveFighter', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
       <?php echo $this->Form->input('Skill',array('type' => 'hidden'));?>

    
<div class="form-group">
    <div class="col-md-12 text-center">
        <?php $a = 'Revive'; ?>
        <?php echo $this->Form->submit($a, array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
  
            
            
</div>
    </div>
</div>
</div>
<div class="col-sm-12">
<div class="panel panel-default">
  <div class="panel-heading">Change Fighter</div>
  <div class="panel-body">
      
       <?php
echo $this->Form->create('ChangeFighter', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>   
     <div class="form-group col-md-8">
      <div class="input-group ">
  <span class="input-group-addon">Name</span>
  <?php echo $this->Form->input('OtherName', array('class' => 'form-control'));?>
</div>
     </div>

    
<div class="form-group col-md-4">
    <div class="text-center">
        <?php $a = 'Choose'; ?>
        <?php echo $this->Form->submit($a, array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
  </div>
      
          
      
</div>
</div>  
        
   
<div class=" col-sm-12">
<div class="panel panel-primary">
    
    <div class="panel-heading">New Fighter</div>
    
<div class="panel-body">
<?php echo $this->Form->create('CreateFighter', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>

    
    <div class="form-group">
    <label class="col-md-2 control-label">Name</label>
    <div class="col-md-10"><?php echo $this->Form->input('name', array('class' => 'form-control'));?></div>
</div>
<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
    <?php echo $this->Form->submit('Create New Fighter', array('class' => 'btn btn-primary'));?>
    </div>
</div>
<?php echo $this->Form->end();?>
    </div>
</div>
</div>    
    