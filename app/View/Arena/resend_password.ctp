 <?php echo $this->Form->create('Password_forgotten')?>

        <div class="form-group">
          <?php echo $this->Form->input('Email', array('class' => 'form-control'));?>
        </div>

        <?php echo $this->Form->submit('Send Password', array('class' => 'btn btn-primary'));
        echo $this->Form->end();?>