<?php
$this->breadcrumbs=array(
	Yii::t('app','Products')=>array('admin'),
	Yii::t('app','Add')
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>