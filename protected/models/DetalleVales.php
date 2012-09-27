<?php

class DetalleVales extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'DetalleVales';
	}

	public function rules()
	{
		return array(
			array('estatus, cantidad, fecha, idVales, idIOProductos', 'required'),
			array('idVales, idIOProductos', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical'),
			array('justificacion, especificaciones', 'length', 'max'=>255),
			array('estatus', 'length', 'max'=>9),
			array('id, justificacion, especificaciones, estatus, cantidad, fecha, idVales, idIOProductos', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idVales0' => array(self::BELONGS_TO, 'Vales', 'idVales'),
			'idIOProductos0' => array(self::BELONGS_TO, 'IOProductos', 'idIOProductos'),
			'faltantes' => array(self::HAS_MANY, 'Faltantes', 'idDetalleVales'),
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
			'justificacion' => Yii::t('app', 'Justificacion'),
			'especificaciones' => Yii::t('app', 'Especificaciones'),
			'estatus' => Yii::t('app', 'Estatus'),
			'cantidad' => Yii::t('app', 'Cantidad'),
			'fecha' => Yii::t('app', 'Fecha'),
			'idVales' => Yii::t('app', 'Id Vales'),
			'idIOProductos' => Yii::t('app', 'Id Ioproductos'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('justificacion',$this->justificacion,true);

		$criteria->compare('especificaciones',$this->especificaciones,true);

		$criteria->compare('estatus',$this->estatus,true);

		$criteria->compare('cantidad',$this->cantidad);

		$criteria->compare('fecha',$this->fecha,true);

		$criteria->compare('idVales',$this->idVales);

		$criteria->compare('idIOProductos',$this->idIOProductos);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
