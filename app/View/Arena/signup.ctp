<div class="col-md-4 col-md-offset-4 panel panel-default">
    <h2>Join the Battle !</h2>
    <div class="panel-body">
        <?php echo $this->Form->create('Signup') ?>
        <div class="form-group">
          <?php echo $this->Form->input('Email address', array('class' => 'form-control'));?>
        </div>
        <div class="form-group">
          <?php echo $this->Form->input('Password', array('class' => 'form-control', 'type' => 'password'));?>
        </div>
        <div class="form-group">
          <?php echo $this->Form->input('Confirm Password', array('class' => 'form-control', 'type' => 'password'));?>
        </div>
        
        <?php echo $this->Form->submit('Sign Up', array('class' => 'btn btn-primary'));
        echo $this->Form->end();?>
    </div>
</div>