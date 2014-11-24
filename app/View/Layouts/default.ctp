<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css('webarena.css');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">WebArena</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><?php echo $this->Html->link(__('Fighter'),array('controller'=>'Arena','action'=>'fighter'))?></li>
                    <li><?php echo $this->Html->link(__('Sight'),array('controller'=>'Arena','action'=>'sight'))?></li>
                    <li><?php echo $this->Html->link(__('Avatar'), array('controller'=>'Arena','action'=>'avatar'))?></li>
                    <li><?php echo $this->Html->link(__('Diary'), array('controller'=>'Arena','action'=>'diary'))?></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><?php echo $this->Html->link(__('Login'), array('controller'=>'Arena','action'=>'Login'))?></li>
                </ul> 
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div id="container">
        <div class="container-fluid" id="content">
            <div class="row">

                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
        <div class="row" id="footer">
            <div class="col-md-6">
                <ul>
                    <li>Group: SI4-05</li>
                    <li>Matthieu BLAIS - Alexandre BRUNEAU - William MARQUES - Victor Tassy</li>
                    <li>Options: Chat + Bootstrap (BF)</li>
                </ul>
            </div>
            <div class="col-md-6 text-right">
                <ul>
                    <li>Find this project on <?php echo $this->Html->link("GitHub", "https://github.com/Willy91/WebArena");?></li>
                    <li><?php echo $this->Html->link(
                    $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
                    'http://www.cakephp.org/',
                    array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
                );
                ?></li>
                
                <li><?php echo $cakeVersion; ?></li>
                </ul>
            </div>
            
        </div>
    </div>
    <?php echo $this->element('sql_dump'); ?>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <?php echo $this->Html->script('bootstrap.min'); ?>
</body>
</html>
