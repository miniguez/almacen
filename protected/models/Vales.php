<?php

class Vales extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Vales';
	}

	public function rules()
	{
		return array(
			array('numero, fecha, tipo, idDirecciones', 'required'),
			array('numero, idDirecciones', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>10),
			array('tipo', 'length', 'max'=>45),
			array('id, numero, fecha, estatus, tipo, idDirecciones', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'detalleVales' => array(self::HAS_MANY, 'DetalleVales', 'idVales'),
			'idDirecciones0' => array(self::BELONGS_TO, 'Direcciones', 'idDirecciones'),
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
			'numero' => Yii::t('app', 'Numero'),
			'fecha' => Yii::t('app', 'Fecha'),
			'estatus' => Yii::t('app', 'Estatus'),
			'tipo' => Yii::t('app', 'Tipo'),
			'idDirecciones' => Yii::t('app', 'Id Direcciones'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('numero',$this->numero);

		$criteria->compare('fecha',$this->fecha,true);

		$criteria->compare('estatus',$this->estatus,true);

		$criteria->compare('tipo',$this->tipo,true);

		$criteria->compare('idDirecciones',$this->idDirecciones);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
