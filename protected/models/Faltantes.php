<?php

class Faltantes extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Faltantes';
	}

	public function rules()
	{
		return array(
			array('cantidad, estatus, tipo', 'required'),
			array('idDetalleVales, idDetalleRecepciones', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical'),
			array('estatus, tipo', 'length', 'max'=>9),
                        array('fechaRegistro','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id, cantidad, estatus, fechaRegistro, fechaEntrega, tipo, idDetalleVales, idDetalleRecepciones', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idDetalleVales0' => array(self::BELONGS_TO, 'DetalleVales', 'idDetalleVales'),
			'idDetalleRecepciones0' => array(self::BELONGS_TO, 'DetalleRecepciones', 'idDetalleRecepciones'),
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
			'cantidad' => Yii::t('app', 'Cantidad'),
			'estatus' => Yii::t('app', 'Estatus'),
			'fechaRegistro' => Yii::t('app', 'Fecha Registro'),
			'fechaEntrega' => Yii::t('app', 'Fecha Entrega'),
			'tipo' => Yii::t('app', 'Tipo'),
			'idDetalleVales' => Yii::t('app', 'Id Detalle Vales'),
			'idDetalleRecepciones' => Yii::t('app', 'Id Detalle Recepciones'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('cantidad',$this->cantidad);

		$criteria->compare('estatus',$this->estatus,true);

		$criteria->compare('fechaRegistro',$this->fechaRegistro,true);

		$criteria->compare('fechaEntrega',$this->fechaEntrega,true);

		$criteria->compare('tipo',$this->tipo,true);

		$criteria->compare('idDetalleVales',$this->idDetalleVales);

		$criteria->compare('idDetalleRecepciones',$this->idDetalleRecepciones);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        public function searchEntrega()
        {
            $criteria->with = array('idDetalleRecepciones0.idRecepciones0',
                                    'idDetalleRecepciones0.idIOProductos0.idProductos0');
            $criteria=new CDbCriteria;
	    $criteria->compare('id',$this->id);
	    $criteria->compare('cantidad',$this->cantidad);
    	    $criteria->compare('estatus',$this->estatus,true);
	    $criteria->compare('fechaRegistro',$this->fechaRegistro,true);
	    $criteria->compare('fechaEntrega',$this->fechaEntrega,true);
	    $criteria->compare('tipo',$this->tipo,true);
            $criteria->compare('idDetalleVales',$this->idDetalleVales);
            $criteria->compare('idDetalleRecepciones',$this->idDetalleRecepciones);

            return new CActiveDataProvider(get_class($this), array(
                    'criteria'=>$criteria,
            ));        
        }
}
