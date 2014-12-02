<?php echo $this->Html->script('Accueil.js');?>
 
<div class="hero-unit">
    <div class="page-header text-center">    
        <h1><strong>WebArena</strong></h1>
    </div>
    <div class="panel col-md-8 col-md-offset-2 text-center" style="background-color:#333366;
	border-color:white; padding:15px;" id="accueillant">
        
        <h3><i><big>
            Welcome in the WebArena!! Create your fighter, join a guild and try to survive !</big></i></h3>
        
        <h3 class='top-margin'><i><big>Only one rule : Do not die ! </big></i></h3>
        
        <h3><i><big>Do not wait more. Join the WebArena !!
        </big></i></h3>

            
           
    </div>
    
</div>

    <div id="myCarousel" class="carousel slide col-md-4 col-md-offset-4 text-center top-margin" data-interval="3000" data-ride="carousel">  
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
                <?php $a = $table_fighter['Fighter']['id'] . ".jpg";?>
                <?php 
                        if($this->Html->image($a)){
                          echo $this->Html->image($a,array('height' => "6000",'width'=>"6000" ));      
                          $name=$table_fighter['Fighter']['name'];
                            echo "<h1>$name</h1>";
                                                   
                        }
                        
                ?>           
            </div>
            <?php endforeach;?>
        </div>
    </div>
