<?php

$this->breadcrumbs=array(
	Yii::t('app','Products'),
        Yii::t('app','New product')=>array('create'),
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
		'nombre',		
		'existencias',
		'caducidad',
                array(
                    'name' => 'precioUnitario',
                    'value' => '"$ " . number_format($data->precioUnitario, 2)',
                    'htmlOptions' => array('style'=>'text-align:right'),
                ),
                array(                    
                    'name' => 'idUnidades',
                    'value' => '$data->idUnidades0->nombre',
                ),
		array(
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}{delete}',
                         'afterDelete'=>'function(link,notice,data){$("#statusMsg").html(data);
                        }',
                        'buttons'=>
                    array(
                        'update'=>array(
                          'url'=>'Yii::app()->createUrl("productos/update",array("id"=>$data->id))',
                          'label'=>Yii::t('app','Update'),

                        ),
                        'delete'=>array(
                          'url'=>'Yii::app()->createUrl("productos/delete",array("id"=>$data->id))',
                          'label'=>Yii::t('app','Delete'),
                        ),                      
                    ),
		),
	),
)); ?>
