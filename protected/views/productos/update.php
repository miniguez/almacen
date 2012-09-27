<?php
$this->breadcrumbs=array(
	Yii::t('app','Products')=>array('admin'),
        $model->nombre,
	Yii::t('app','Update'),
);

?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>