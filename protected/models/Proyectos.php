<?php

class Proyectos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Proyectos';
	}

	public function rules()
	{
		return array(
			array('nombre, sector, dependencia, objetivo, programa, subPrograma, numero', 'required'),
			array('sector, dependencia, objetivo, programa, subPrograma, numero', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>145),
			array('id, nombre, sector, dependencia, objetivo, programa, subPrograma, numero', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'direcciones' => array(self::HAS_MANY, 'Direcciones', 'idProyectos'),
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
			'sector' => Yii::t('app', 'Sector'),
			'dependencia' => Yii::t('app', 'Dependencia'),
			'objetivo' => Yii::t('app', 'Objetivo'),
			'programa' => Yii::t('app', 'Programa'),
			'subPrograma' => Yii::t('app', 'Sub Programa'),
			'numero' => Yii::t('app', 'Numero'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('sector',$this->sector);

		$criteria->compare('dependencia',$this->dependencia);

		$criteria->compare('objetivo',$this->objetivo);

		$criteria->compare('programa',$this->programa);

		$criteria->compare('subPrograma',$this->subPrograma);

		$criteria->compare('numero',$this->numero);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
