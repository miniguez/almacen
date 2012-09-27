<?php

$this->breadcrumbs=array(
	Yii::t('app','Products to receive'),
);

$this->widget('bootstrap.widgets.BootAlert');
$this->widget('Flashes');

?>

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'productos-grid',
        'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Nombre',
                array(
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
                'Razon_Social',
	),
)); ?>
