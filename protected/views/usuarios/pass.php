<?php
$this->breadcrumbs=array(
	Yii::t('app','Users')=>array('admin'),
	Yii::t('app','Change password of')." ".$model->nombreUsuario
);

?>
<?php
$this->widget('bootstrap.widgets.BootAlert');
$this->widget('Flashes');

$form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'usuarios-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>60));  ?>
        <?php echo $form->passwordFieldRow($model,'repeat_password',array('class'=>'span5','maxlength'=>60));  ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
