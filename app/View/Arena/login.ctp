<?php echo $this->Html->script('login.js');?>
<?php echo $this->Html->script('gplus');?>
<div class="col-md-8 col-md-offset-2 panel panel-default top-margin">
    <div class="col-md-6 ">
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
            <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
            </fb:login-button> -->

            <span id="signinButton">
                <span
                    class="g-signin"
                    data-callback="signinCallback"
                    data-clientid="655601395522-65h99la8bvv5ufd6k5ag9vn8rk236kqg.apps.googleusercontent.com"
                    data-cookiepolicy="single_host_origin"
                    data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email"
                    data-approvalprompt="force">
                </span>
            </span>
            <?php echo $this->Html->link(
                $this->Html->image('fb_icon', array('width'=>'25%')), array('controller'=>'arena', 'action'=>'fbLogin'), array('escape' => false));?>
            </div>

        </div>
    </div>

    <div class="col-md-6">
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

    	<h4>Forgot Password?</h4>
    	 <?php echo $this->Form->create('Password_forgotten')?>

            <div class="form-group">
              <?php echo $this->Form->input('Email', array('class' => 'form-control'));?>
            </div>

            <?php echo $this->Form->submit('Send Password', array('class' => 'btn btn-primary'));
            echo $this->Form->end();?>
            
        </div>
    </div>
    </div>
</div>
  
    <?php echo $this->Form->create('GPlusLogin', array('url'=>'gPlusLogin'));
    echo $this->Form->hidden('email');?>
    <div class="hidden">
        <?php echo $this->Form->submit('LogGplusBtn');?>
    </div>
    <?php echo $this->Form->end(); ?>



