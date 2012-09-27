<?php

class IOProductos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'IOProductos';
	}

	public function rules()
	{
		return array(
			array('cantidad, tipo, idProductos', 'required'),
			array('idProductos', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical'),
			array('tipo', 'length', 'max'=>7),
			array('estatus', 'length', 'max'=>9),
                        array('fecha','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id, cantidad, fecha, tipo, estatus, idProductos', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'detalleRecepciones' => array(self::HAS_MANY, 'DetalleRecepciones', 'idIOProductos'),
			'detalleVales' => array(self::HAS_MANY, 'DetalleVales', 'idIOProductos'),
			'faltantes' => array(self::HAS_MANY, 'Faltantes', 'idIOProductos'),
			'idProductos0' => array(self::BELONGS_TO, 'Productos', 'idProductos'),
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
			'cantidad' => Yii::t('app', 'Cantida'),
			'fecha' => Yii::t('app', 'Fecha'),
			'tipo' => Yii::t('app', 'Tipo'),
			'estatus' => Yii::t('app', 'Estatus'),
			'idProductos' => Yii::t('app', 'Id Productos'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('cantidad',$this->cantida);

		$criteria->compare('fecha',$this->fecha,true);

		$criteria->compare('tipo',$this->tipo,true);

		$criteria->compare('estatus',$this->estatus,true);

		$criteria->compare('idProductos',$this->idProductos);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}        
}
