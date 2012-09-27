<?php
$this->breadcrumbs=array(
	Yii::t('app','Users')=>array('admin'),
        $model->loginName,
	Yii::t('app','Update'),
);

?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>