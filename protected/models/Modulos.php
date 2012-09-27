<?php

class Modulos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Modulos';
	}

	public function rules()
	{
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>45),
			array('id, nombre', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'movimientoses' => array(self::HAS_MANY, 'Movimientos', 'idModulos'),
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
			'nombre' => Yii::t('app', 'Nombre'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
