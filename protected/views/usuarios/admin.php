<?php

$this->breadcrumbs=array(
	Yii::t('app','Users'),
        Yii::t('app','New user')=>array('create'),
);

$this->widget('bootstrap.widgets.BootAlert');
$this->widget('Flashes');

?>
<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'usuarios-grid',
        'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'loginName',
		'nombreUsuario',
                array(
                    'name' => 'idTipoUsuarios',
                    'value' => '$data->idTipoUsuarios0->nombre',
                ),
		array(
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}{pass}{active}{inactive}',
                         'afterDelete'=>'function(link,notice,data){$("#statusMsg").html(data);
                        }',
                        'buttons'=>
                    array(
                        'update'=>array(
                          'url'=>'Yii::app()->createUrl("usuarios/update",array("id"=>$data->id))',
                          'label'=>Yii::t('app','Update'),
                        ),
                        'pass'=>array(
                          'url'=>'Yii::app()->createUrl("usuarios/pass",array("id"=>$data->id))',
                          'label'=>Yii::t('app','Pass'),
                        ),
                        'active'=>array(
                          'url'=>'Yii::app()->createUrl("usuarios/active",array("id"=>$data->id))',
                          'label'=>Yii::t('app','active'),
                          'visible'=>'$data->estatusUsuario==0',
                        ),
                        'inactive'=>array(
                          'url'=>'Yii::app()->createUrl("usuarios/inactive",array("id"=>$data->id))',
                          'label'=>Yii::t('app','inactive'),
                          'visible'=>'$data->estatusUsuario==1',
                        ),
                    ),
		),
	)
    ));
?>