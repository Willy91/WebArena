<div class="jumbotron">
    <h1>Welcome to WebArena !</h1>
    <?php if(!$this->Session->read('Connected')): ?>
        <p>Create Now your Fighter and start Fighting for Glory !</p>
        <p><a class="btn btn-primary btn-lg" href="#loginModal" data-toggle="modal" data-target="#loginModal">Log In or Sign Up Now !</a></p>
    <?php else: ?>
        <p>Start Fighting for Glory !</p>
        <p><?php echo $this->Html->link(__('Go to the Battleground!'),array('controller'=>'Arena','action'=>'sight'), array('class'=>'btn btn-primary btn-lg'))?></p>
    <?php endif ?>
</div>