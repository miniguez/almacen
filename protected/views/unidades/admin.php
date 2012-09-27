<?php


$this->breadcrumbs=array(
	Yii::t('app','Units'),
        Yii::t('app','New unit')=>array('create'),
);

$this->widget('bootstrap.widgets.BootAlert');
$this->widget('Flashes');

?>

            <?php
$this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'unidades-grid',
        'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}{delete}',
                         'afterDelete'=>'function(link,notice,data){$("#statusMsg").html(data);
                        }',
                        'buttons'=>
                    array(
                        'update'=>array(
                          'url'=>'Yii::app()->createUrl("unidades/update",array("id"=>$data->id))',
                          'label'=>Yii::t('app','Update'),

                        ),
                        'delete'=>array(
                          'url'=>'Yii::app()->createUrl("unidades/delete",array("id"=>$data->id))',
                          'label'=>Yii::t('app','Delete'),
                        ),                      
                    ),
		),
	),
)); ?>
 
