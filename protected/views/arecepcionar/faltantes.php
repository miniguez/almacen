<?php

$this->breadcrumbs=array(
	Yii::t('app','Products to receive')=>array('recepcionar'),
        Yii::t('app','standby'),
);

$this->widget('bootstrap.widgets.BootAlert');
$this->widget('Flashes');

?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'recepcionar-form',
	'enableAjaxValidation'=>false,
      
)); 

?>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'productos-grid',
        'type'=>'striped bordered condensed',
	'dataProvider'=>$model->searchEntrega(),
	'filter'=>$model,
	'columns'=>array(		
                array(
                    'name' => 'idOrdenCompra',
                    'value' =>'$data->idDetalleRecepciones0->idRecepciones0->idOrdenCompra',
                    'htmlOptions' => array('style'=>'text-align:right'),
                ),
                array(
                    'name'=>'direccion',
                    'value'=>'$data->idDetalleRecepciones0->direccion',
                ),  
                array(
                    'name'=>'producto',
                    'value'=>'$data->idDetalleRecepciones0->idIOProductos0->idProductos0->nombre',
                ),  
                array(
                    'name'=>'unidad',
                    'value'=>'$data->idDetalleRecepciones0->idIOProductos0->idProductos0->idUnidades0->nombre',
                ),
                array(
                    'name'=>'cantidad',
                    'value'=>'$data->idDetalleRecepciones0->cantidad',
                ),
                array(
                    'name'=>'proveedor',
                    'value'=>'$data->idDetalleRecepciones0->idRecepciones0->proveedor',
                ),
                array(
                    'class'=>'myCheckBoxColumn',
                    'checked'=>'',
                    'selectableRows'=>2,
                    'value'=>'$data->id'
                ),               
	),
)); ?>

<?php 
    $this->widget('bootstrap.widgets.BootButton', array(
                  'buttonType'=>'submit',
                  'type'=>'primary',
                  'label'=>'Aceptar',
        ));
    
?>
<?php $this->endWidget(); ?>

