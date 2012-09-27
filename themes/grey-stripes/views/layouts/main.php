<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="language" content="en" />
 
   <!--[if lt IE 8]>
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
   <![endif]-->

   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl;?>/css/style.css" />
   <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/script.js'); ?>
   <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="wrapper">

    <header id="header" class="clearfix" role="banner">

        <hgroup>
       
            <table >
                <tr>
                    <td> <img src="images/logos_gobzac.png"></img></td>
                    <td><h1 id="site-title"><a href="#"><?php echo "almacén"; ?></a></h1></td>
                </tr>
            </table>

            
<!--            <h2 id="site-description">YII Test App!</h2>-->
        </hgroup
    
    </header> <!-- #header -->

<div id="main" class="clearfix">

	<!-- Navigation -->
    <nav id="menu" class="clearfix" role="navigation">
       
        
        <div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Catalogos', 'url'=>array('/site/catalogos')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
    </nav> <!-- #nav -->
    
    <!-- Show a "Please Upgrade" box to both IE7 and IE6 users (Edit to IE 6 if you just want to show it to IE6 users) - jQuery will load the content from js/ie.html into the div -->
    
    <!--[if lte IE 7]>
        <div class="ie warning"></div>
    <![endif]-->
     <div>
                        <?php if (isset($this->breadcrumbs)): ?>
                            <?php
                            $this->widget('zii.widgets.CBreadcrumbs', array(
                                'links' => $this->breadcrumbs,
                            ));
                            ?><!-- breadcrumbs -->
<?php endif ?>
                    </div>
    
    <div id="content" role="main">
    <?php echo $content; ?>

        <hr /> <!-- Post seperator - Not the most optimal solution -->
        
        <article class="post">
       
    </div> <!-- #content -->
    
    <aside id="sidebar" role="complementary">
    
        <aside class="widget">
          
           
        </aside>  
        

    
</div> <!-- #main -->
<footer id="footer">
        <!-- You're free to remove the credit link to Jayj.dk in the footer, but please, please leave it there :) -->
        <p>
            Copyright &copy; 2012 <a href="#">OMG</a>
            <span class="sep">|</span>
            Design by <a href="http://jayj.dk" title="Design by Jayj.dk">Coordinación de sistemas</a>
        </p>
    </footer> <!-- #footer -->
    
    <div class="clear"></div>

<!--[if IE]><?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/excanvas.js'); ?><![endif]-->   
<?php //Yii::app()->clientScript->registerCoreScript('jquery'); ?>




    


</body>
</html>