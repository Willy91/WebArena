<?php echo $this->Html->script('fb'); ?>
<div class="center-block">
<h4>Please Confirm your Facebook Connexion by clicking here:</h4>
    <?php echo $this->Html->link(
                $this->Html->image('fb_icon', array('width'=>'10%')), $fbUrl, array('escape' => false));?>
</div>
