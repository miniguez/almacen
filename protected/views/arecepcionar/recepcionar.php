 <?php    
        $this->widget('bootstrap.widgets.BootAlert');
        $this->widget('Flashes');
    ?>
<?php
$this->breadcrumbs=array(
	Yii::t('app','Receive products'),
        Yii::t('app','standby')=>array('faltantes'),
);
?>
<?php
if($mRec==true)
{
     echo "<div class='row alert alert-block alert-warning fade in'><a class='close' data-dismiss='alert'>×</a>".Yii::t('app', 'The oc was entered')."</div>";                     
}
?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'recepcionar-form',
	'enableAjaxValidation'=>false,
      
)); 

?>


<?php echo $form->errorSummary($mRecepcion); ?>

<?php echo $form->labelEx($model,'Razon_Social'); ?>
<?php echo $form->dropDownList($model,'Razon_Social',CHtml::listData(OcRecepcionaromg::model()->findAll("Razon_Social is not null GROUP BY Razon_Social"),'idProveedor',"Razon_Social"),
                               array(
                                        'class'=>'span5',
                                        'ajax' =>
                                            array(
                                                    'type' => 'POST',
                                                    'url' => CController::createUrl('Arecepcionar/desplegarOc'),
                                                    'update' =>'#OcRecepcionaromg_id',
                                                 ),
                                        'prompt' => 'Seleccione un proveedor(a)...',
                                    )
                              );
?>
<?php
    echo $form->labelEx($model,'id');    
    if(isset($_POST['OcRecepcionaromg']['Razon_Social']))
    {
        $data = OcRecepcionaromg::model()->findAll('idProveedor=:parent_id',array(':parent_id'=>(int) $_POST['OcRecepcionaromg']['Razon_Social']));
        echo $form->dropDownList($model,'id',
                               CHtml::listData($data,'id','id'),
                               array(
                                         'class'=>'span5',
                                        'prompt' =>'Seleccione una orden de compra...'
                                    )
                              );
    }
    else
    {
         echo $form->dropDownList($model,'id',
                               array(),
                               array(
                                         'class'=>'span5',
                                        'prompt' =>'Seleccione una orden de compra...'
                                    )
                              );
    }

?>
<br />
<?php $this->widget('bootstrap.widgets.BootButton', array(
                    'buttonType'=>'submit',
                    'type'=>'action',
			'label'=>'Search',
		)); ?>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'oc-grid',
        'type'=>'striped bordered condensed',
	'dataProvider'=>$model->searchEntrega(),	
	'columns'=>array(
		'Nombre',
                array(
                    'id'=>'OcRecepcionaromg_id',
                    'name' => 'id',
                    'value' =>'$data->id',
                    'htmlOptions' => array('style'=>'text-align:right'),
                ),
                'Fecha',
                array(
                    'name' => 'TiempoEntrega',
                    'value' =>'$data->TiempoEntrega',
                    'htmlOptions' => array('style'=>'text-align:right'),
                ),
                'producto',
                array(
                    'name' => 'Cantidad',
                    'value' =>'$data->Cantidad',
                    'htmlOptions' => array('style'=>'text-align:right'),
                ),
                array(
                    'class'=>'myCheckBoxColumn',
                    'checked'=>'',
                    'selectableRows'=>2,
                    'value'=>'$data->idDetalleoc'
                ),
	),
)); ?>

<br />
<?php echo $form->textAreaRow($model,'observaciones',array('class'=>'span5')); ?>

<br />


<?php 
    if(isset($_POST['OcRecepcionaromg']['Razon_Social']) and isset($_POST['OcRecepcionaromg']['id']) and $mRec==false)
    {
        $this->widget('bootstrap.widgets.BootButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Aceptar',
        ));
    }
?>
<?php $this->endWidget(); ?>