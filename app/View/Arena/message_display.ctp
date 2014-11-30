<div class="panel panel-primary">
    
    <div class="panel-heading text-center"><h1>New Email</h1></div>
    
    <div class="panel-body">
        
        
        <div class="col-sm-5">
            <div >
        <?php echo $this->Form->create('Back', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?> 
        <?php echo $this->Form->input('Skill',array('type' => 'hidden'));?>
            <?php echo $this->Form->submit('Back to mail box', array('class' => 'btn btn-primary'));?>
        <?php echo $this->Form->end(); ?>
        </div>    
        </div> 
        

                    <div class="col-sm-12 top-margin">
                
               
                
                
      <div class="col-sm-12">
        <div class="well well-sm">
          <form class="form-horizontal" action="" method="post">
          <fieldset>
            <legend class="text-center">Email</legend>
    <?php echo $this->Form->create('CreateMessage', array('class' => 'form-horizontal', 'inputDefaults'=>array('label'=>false)));?>
   
            <!-- Name input-->
            <div class="form-group">
                           <label class="col-md-3 control-label" for="name">To</label>
              <div class="col-md-9">
                <?php
                echo $this->Form->input('to', array('options' => array($fighter_option), 'default' => $fighter_defaut));?>
              </div>
            </div>
    
            <!-- Email input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="email">Object</label>
              <div class="col-md-9">
                <?php echo $this->Form->input('object', array('class' => 'form-control'));?>
              </div>
            </div>
    
            <!-- Message body -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="message">Message</label>
              <div class="col-md-9">
                <?php echo $this->Form->input('message', array('type' => 'textarea', 'style' => 'width:100%;resize: none;'));?>
              </div>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <?php echo $this->Form->submit('Send', array('class' => 'btn btn-primary'));?>
        </div>
        <?php echo $this->Form->end(); ?>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
</div>
              
        
    </div>
    
</div>