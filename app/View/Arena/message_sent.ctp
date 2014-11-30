<?php echo $this->Html->script('email.js');?>

<div class="panel panel-primary">
    
    <div class="panel-heading text-center"><h1>Emails Sent</h1></div>
    
    <div class="panel-body">
        
        <div class="col-sm-2">
            <div >
        <?php echo $this->Form->create('SendEmail', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?> 
        <?php echo $this->Form->input('Skill',array('type' => 'hidden'));?>
            <?php echo $this->Form->submit('New Email', array('class' => 'btn btn-primary'));?>
        <?php echo $this->Form->end(); ?>
        </div>    
        </div> 
        <div class="col-sm-2">
            <div >
        <?php echo $this->Form->create('EmailSent', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?> 
        <?php echo $this->Form->input('Skill',array('type' => 'hidden'));?>
            <?php echo $this->Form->submit('Emails Sent', array('class' => 'btn btn-primary'));?>
        <?php echo $this->Form->end(); ?>
        </div>    
        </div> 
        <div class="col-sm-2">
            <div >
        <?php echo $this->Form->create('EmailBox', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?> 
        <?php echo $this->Form->input('Skill',array('type' => 'hidden'));?>
            <?php echo $this->Form->submit('Email Box', array('class' => 'btn btn-primary'));?>
        <?php echo $this->Form->end(); ?>
        </div>    
        </div> 
        
        <div class="col-sm-12 top-margin">
            

            <table id="message_table" class="display table table-striped table-bordered" cellspacing="0" style="table-layout:fixed;" width="100%">
        <tr>
            <th style="width: 10%;">Date</th>
            <th style="width: 20%;">To</th>
            <th style="width: 20%;">Object</th>
            <th>Message</th>
        </tr>
        <?php foreach($message_table as $data):?>
        <tr>
            <td><?php echo $data['Message']['date']; ?></td>
            <td><?php echo $data['Fighter']['name'];?></td>
            <td><?php echo $data['Message']['title'];?></td>
            <td style="word-wrap: break-word;"><?php echo $data['Message']['message'];?>
                
                
                
                
            </td>
        </tr>
        <?php endforeach;?>

    </table>  
            
  
                
                
                
            </div>
            
            
            
            
            
        </div>
      
        
        
        
        
        
        
        
        
        
    </div>
    
