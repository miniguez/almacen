<?php

class Dependencias extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Dependencias';
	}

	public function rules()
	{
		return array(
			array('nombre, numero', 'required'),
			array('numero', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>145),
			array('id, nombre, numero', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'departamentoses' => array(self::HAS_MANY, 'Departamentos', 'idDependencias'),
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
			'numero' => Yii::t('app', 'Numero'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('numero',$this->numero);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
