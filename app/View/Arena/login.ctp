
<div class="col-md-4 col-md-offset-4 panel panel-default">
<h2>Login and Go Fight!</h2>
<div class="panel-body">
  <?php echo $this->Form->create('Login') ?>
    <div class="form-group">
      <?php echo $this->Form->input('Email address', array('class' => 'form-control'));?>
    </div>
    <div class="form-group">
      <?php echo $this->Form->input('Password', array('class' => 'form-control', 'type'=>'password'));?>
    </div>
    
    <?php echo $this->Form->submit('Log In', array('class' => 'btn btn-primary'));
    echo $this->Form->end();?>
</div>
</div>