<?php

class Departamentos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Departamentos';
	}

	public function rules()
	{
		return array(
			array('nombre, idDependencias', 'required'),
			array('idDependencias', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>150),
			array('id, nombre, idDependencias', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idDependencias0' => array(self::BELONGS_TO, 'Dependencias', 'idDependencias'),
			'direcciones' => array(self::HAS_MANY, 'Direcciones', 'idDepartamentos'),
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
			'idDependencias' => Yii::t('app', 'Id Dependencias'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('idDependencias',$this->idDependencias);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
