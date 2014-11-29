<?php echo $this->Html->script('Accueil.js');?>
 
<div class="hero-unit">
    <div class="page-header text-center">    
        <h1><strong>WebArena</strong></h1>
    </div>
    <div class="col-md-8 col-md-offset-2 text-center">
        
        <p><i><big>
            Quanta autem vis amicitiae sit, ex hoc intellegi maxime potest, quod ex infinita societate generis humani, quam conciliavit ipsa natura, ita contracta res est et adducta in angustum ut omnis caritas aut inter duos aut inter paucos iungeretur.</big></i></p>
        
        <p><i><big>Sed tamen haec cum ita tutius observentur, quidam vigore artuum inminuto rogati ad nuptias ubi aurum dextris manibus cavatis offertur, inpigre vel usque Spoletium pergunt. haec nobilium sunt instituta.</big></i></p>

        <p><i><big>Alios autem dicere aiunt multo etiam inhumanius (quem locum breviter paulo ante perstrinxi) praesidii adiumentique causa, non benevolentiae neque caritatis, amicitias esse expetendas; itaque, ut quisque minimum firmitatis haberet minimumque virium, ita amicitias appetere maxime; ex eo fieri ut mulierculae magis amicitiarum praesidia quaerant quam viri et inopes quam opulenti et calamitosi quam ii qui putentur beati.
        </big></i></p>
    <?php echo $this->Form->create('Login') ?>
    
    <?php echo $this->Form->submit('Log In', array('class' => 'btn btn-primary'));
    echo $this->Form->end();?>
            
           
    </div>
    
</div>

<?php if ($this->Session->read('Connected')): ?>
    <div id="myCarousel" class="carousel slide col-md-2 col-md-offset-5 text-center top-margin" data-interval="3000" data-ride="carousel">  
    <!-- Carousel items -->
        <div class="carousel-inner">
            <?php $i=0;?>   
            <?php foreach ($table_fighter2 as $table_fighter) :?>
            
            <?php if ($i==0):
                $i = 4;
                $var = "active item";
            else:
                $var = "item";
            endif;?>
        
            <div class="<?php echo $var?>">
                <?php $a = $table_fighter['Fighter']['id'] . ".jpg"; echo $a;?>
                <?php 
                        if($this->Html->image($a)){
                          echo $this->Html->image($a);      
                        echo $table_fighter['Fighter']['name'];
                        }
                        
                ?>           
            </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif ?>
