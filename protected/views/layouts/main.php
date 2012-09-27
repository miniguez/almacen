<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

        <?php
        $this->widget('bootstrap.widgets.BootNavbar', array(
    
    'fixed'=>false,    
    'brand'=>'',
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.BootMenu',            
            'items'=>array(
                array('label'=>Yii::t('app', 'Catalogs'),
                    'url'=>'',
                    'visible'=>Yii::app()->user->getState("idTipoUsuario")==1,
                    'items'=>array(
	                    array('label'=>Yii::t('app', 'Unit'),'url'=>array('unidades/admin'),
	                          'visible'=>Yii::app()->user->getState("idTipoUsuario")==1
	                      ),
                           array('label'=>Yii::t('app', 'Products'),'url'=>array('productos/admin'),
	                          'visible'=>Yii::app()->user->getState("idTipoUsuario")==1
	                      ),
                           array('label'=>Yii::t('app', 'Usuarios'),'url'=>array('usuarios/admin'),
	                          'visible'=>Yii::app()->user->getState("idTipoUsuario")==1
	                      ),
                      )
                ),
                array('label'=>Yii::t('app', 'Merchandise'),
                    'url'=>'',
                    'visible'=>Yii::app()->user->getState("idTipoUsuario")==1,
                    'items'=>array(
	                    array('label'=>Yii::t('app', 'Products to receive'),'url'=>array('arecepcionar/ocpendientes'),
	                          'visible'=>Yii::app()->user->getState("idTipoUsuario")==1
	                      ),
                            array('label'=>Yii::t('app', 'Receive products'),'url'=>array('arecepcionar/recepcionar'),
	                          'visible'=>Yii::app()->user->getState("idTipoUsuario")==1
	                      ),
                      )
                ),
                array('label'=>'Iniciar sesion', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Salir ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Link', 'url'=>'#'),
                array('label'=>'Dropdown', 'url'=>'#', 'items'=>array(
                    array('label'=>'Action', 'url'=>'#'),
                    array('label'=>'Another action', 'url'=>'#'),
                    array('label'=>'Something else here', 'url'=>'#'),
                    '---',
                    array('label'=>'NAV HEADER'),
                    array('label'=>'Separated link', 'url'=>'#'),
                    array('label'=>'One more separated link', 'url'=>'#'),
                )),
            ),
        ),     
    ),
));
      /*array('label'=>Yii::t('app', 'Employees'),'url'=>array('empleados/admin'),
	                          'visible'=>Yii::app()->user->getState("idTipoUsuario")==1
	                      ),*/
        ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif ?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
