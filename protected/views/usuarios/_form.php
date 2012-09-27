<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'usuarios-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'loginName',array('class'=>'span5','maxlength'=>20)); ?>

	<?php 
        if(!$model->id)
        {
            echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>60));
            echo $form->passwordFieldRow($model,'repeat_password',array('class'=>'span5','maxlength'=>60));  
        }
        ?>

	<?php echo $form->textFieldRow($model,'nombreUsuario',array('class'=>'span5','maxlength'=>80)); ?>
	

        <?php echo $form->labelEx($model,'idTipoUsuarios'); ?>
	<?php echo $form->dropDownList($model,'idTipoUsuarios',CHtml::listData(TipoUsuarios::model()->findAll(array('order'=>'nombre')),'id',"nombre"),array('class'=>'span5'));?>

	<?php echo $form->labelEx($model,'idDirecciones'); ?>
	<?php echo $form->dropDownList($model,'idDirecciones',CHtml::listData(Direcciones::model()->findAll(array('order'=>'nombre')),'id',"nombre"),array('class'=>'span5'));?>

	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
