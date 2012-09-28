<?php

class DetalleRecepciones extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'DetalleRecepciones';
	}

	public function rules()
	{
		return array(
			array('estatus, cantidad,idDetalleoc, idIOProductos, idRecepciones', 'required'),
			array('idDetalleoc, idIOProductos, idRecepciones', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical'),
			array('estatus', 'length', 'max'=>9),
                        array('direccion', 'length', 'max'=>120),
                        array('fecha','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id, estatus, cantidad, fecha,idDetalleoc, idIOProductos, idRecepciones,direccion', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idIOProductos0' => array(self::BELONGS_TO, 'IOProductos', 'idIOProductos'),
			'idRecepciones0' => array(self::BELONGS_TO, 'Recepciones', 'idRecepciones'),
			'faltantes' => array(self::HAS_MANY, 'Faltantes', 'idDetalleRecepciones'),
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
			'estatus' => Yii::t('app', 'Estatus'),
			'cantidad' => Yii::t('app', 'Cantidad'),
			'fecha' => Yii::t('app', 'Fecha'),
                        'idDetalleoc' => Yii::t('app', 'Id Detalleoc'),
			'idIOProductos' => Yii::t('app', 'Id Ioproductos'),
			'idRecepciones' => Yii::t('app', 'Id Recepciones'),
                        'direccion' => Yii::t('app', 'Dirección'),
                    
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('estatus',$this->estatus,true);

		$criteria->compare('cantidad',$this->cantidad);

		$criteria->compare('fecha',$this->fecha,true);

                $criteria->compare('idDetalleoc',$this->idDetalleoc);

		$criteria->compare('idIOProductos',$this->idIOProductos);

		$criteria->compare('idRecepciones',$this->idRecepciones);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        /**
         * Funcion para guardar faltantes de detalle recepcion 
         * @return boolean 
         */
        public function registraFaltanteRecepcion()
        {
            $modelFalta = new Faltantes();
            $modelFalta->cantidad= $this->cantidad;
            $modelFalta->estatus='CREADO';
            $modelFalta->tipo='RECEPCION';
            $modelFalta->idDetalleRecepciones=$this->id;
            if($modelFalta->save())
            {
                 $objBitacora = new Bitacora();
                 $objBitacora->setMovimiento('CREAR','Faltantes','',$modelFalta->id,'',6); 
                return true;
            }
            else
            {
                return false;
            }
        }
}
