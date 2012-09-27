<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'productos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('app','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app','are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>145)); ?>

	<?php echo $form->textFieldRow($model,'cantidadInicial',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'existencias',array('class'=>'span5')); ?>


        <?php
        $this->widget('application.extensions.moneymask.MMask',array(
                      'element'=>'#Productos_precioUnitario',
                      'currency'=>'PHP',
                      'config'=>array(
                                'symbolStay'=>true,
                                'showSymbol'=>true,
                                'symbol'=>"$",
                                )
                ));
        ?>
	<?php echo $form->textFieldRow($model,'precioUnitario',array('class'=>'span5')); ?>

        <?php echo $form->labelEx($model,'caducidad'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                        array(
                                'model'=>'$model',
				'name'=>'Productos[caducidad]',
				'language'=>'es',
				'value'=>$model->caducidad,
				'htmlOptions'=>array('size'=>10, 'style'=>'width:90px !important','class'=>'span5'),
				'options'=>array(
                                    'showButtonPanel'=>true,
                                    'changeYear'=>true,
                                    'changeYear'=>true,
				    'dateFormat'=>'yy-mm-dd',
				),
                            )
			);
        ?>

      
	<?php echo $form->labelEx($model,'idUnidades'); ?>
	<?php echo $form->dropDownList($model,'idUnidades',CHtml::listData(Unidades::model()->findAll(array('order'=>'nombre')),'id',"nombre"),array('class'=>'span5'));?>



       
	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
