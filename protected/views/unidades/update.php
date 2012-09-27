<?php
$this->breadcrumbs=array(
	Yii::t('app','Units')=>array('admin'),
        $model->nombre,
	Yii::t('app','Update'),
);

?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>