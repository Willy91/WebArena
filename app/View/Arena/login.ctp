<?php echo $this->Html->script('login.js');?>
<?php echo $this->Html->script('fb');?>
<?php echo $this->Html->script('gplus');?>
<div class="col-md-8 col-md-offset-2 panel panel-default top-margin">
    <div class="col-md-6 panel panel-default">
    <h2>Join the Battle !</h2>
    <div class="panel-body">
        <?php echo $this->Form->create('Signup');?>
        <div class="form-group">
          <?php echo $this->Form->input('Email address', array('class' => 'form-control'));?>
        </div>
        <div class="form-group">
          <?php echo $this->Form->input('Password', array('class' => 'form-control', 'type' => 'password'));?>
        </div>
        <div class="form-group">
          <?php echo $this->Form->input('Confirm Password', array('class' => 'form-control', 'type' => 'password'));?>
        </div>
        <div class="text-center">
        <?php echo $this->Form->submit('Sign Up', array('class' => 'btn btn-primary'));
        echo $this->Form->end();?>
        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
        </fb:login-button>

        <span id="signinButton">
            <span
                class="g-signin"
                data-callback="signinCallback"
                data-clientid="655601395522-65h99la8bvv5ufd6k5ag9vn8rk236kqg.apps.googleusercontent.com"
                data-cookiepolicy="single_host_origin"
                data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email">
            </span>
        </span>
        </div>

    </div>
</div>

<div class="col-md-6  panel panel-default">
<h2>Login and Go Fight!</h2>
<div class="panel-body">
  <?php echo $this->Form->create('Login');?>
    <div class="form-group">
      <?php echo $this->Form->input('Email address', array('class' => 'form-control'));?>
    </div>
    <div class="form-group">
      <?php echo $this->Form->input('Password', array('class' => 'form-control', 'type'=>'password'));?>
    </div>
    <div class="text-center">
    <?php echo $this->Form->submit('Log In', array('class' => 'btn btn-primary'));
    echo $this->Form->end();?>

	<h2>Ask for a new password</h2>
	 <?php echo $this->Form->create('Password_forgotten')?>

        <div class="form-group">
          <?php echo $this->Form->input('Email', array('class' => 'form-control'));?>
        </div>

        <?php echo $this->Form->submit('Send Password', array('class' => 'btn btn-primary'));
        echo $this->Form->end();?>
    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>
    </div>
  </div>
  <div id="status">
</div>

</div>
</div>
  

</div>
</div>

<div class="col-md-4 col-md-offset-4 panel panel-default">

</div>

