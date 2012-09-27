<?php

class Movimientos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Movimientos';
	}

	public function rules()
	{
		return array(
			array('accion, idAccesos, idModulos', 'required'),
			array('idTabla, idAccesos, idModulos', 'numerical', 'integerOnly'=>true),
			array('accion', 'length', 'max'=>9),
                        array('fechaRegistro','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('nombreTabla, campoTabla', 'length', 'max'=>45),
			array('contenidoAnterior', 'length', 'max'=>255),
			array('id, fechaRegistro, accion, nombreTabla, campoTabla, idTabla, contenidoAnterior, idAccesos, idModulos', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idAccesos0' => array(self::BELONGS_TO, 'Accesos', 'idAccesos'),
			'idModulos0' => array(self::BELONGS_TO, 'Modulos', 'idModulos'),
		);
	}

	public function behaviors()
	{
		return array('CAdvancedArBehavior',
				array('class' => 'ext.CAdvancedArBehavior')
				);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'fechaRegistro' => Yii::t('app', 'Fecha Registro'),
			'accion' => Yii::t('app', 'Accion'),
			'nombreTabla' => Yii::t('app', 'Nombre Tabla'),
			'campoTabla' => Yii::t('app', 'Campo Tabla'),
			'idTabla' => Yii::t('app', 'Id Tabla'),
			'contenidoAnterior' => Yii::t('app', 'Contenido Anterior'),
			'idAccesos' => Yii::t('app', 'Id Accesos'),
			'idModulos' => Yii::t('app', 'Id Modulos'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);

		$criteria->compare('fechaRegistro',$this->fechaRegistro,true);

		$criteria->compare('accion',$this->accion,true);

		$criteria->compare('nombreTabla',$this->nombreTabla,true);

		$criteria->compare('campoTabla',$this->campoTabla,true);

		$criteria->compare('idTabla',$this->idTabla);

		$criteria->compare('contenidoAnterior',$this->contenidoAnterior,true);

		$criteria->compare('idAccesos',$this->idAccesos);

		$criteria->compare('idModulos',$this->idModulos);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
