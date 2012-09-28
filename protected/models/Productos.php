<?php

class Productos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Productos';
	}

	public function rules()
	{
		return array(
			array('nombre, cantidadInicial, idUnidades', 'required'),
			array('idUnidades', 'numerical', 'integerOnly'=>true),
			array('cantidadInicial, existencias, precioUnitario', 'numerical'),
			array('nombre', 'length', 'max'=>145),
			array('claveAdq', 'length', 'max'=>45),
			array('caducidad', 'safe'),
			array('id, nombre, cantidadInicial, existencias, caducidad, precioUnitario, claveAdq, idUnidades', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'iOProductoses' => array(self::HAS_MANY, 'IOProductos', 'idProductos'),
			'idUnidades0' => array(self::BELONGS_TO, 'Unidades', 'idUnidades'),
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
			'cantidadInicial' => Yii::t('app', 'Cantidad Inicial'),
			'existencias' => Yii::t('app', 'Existencias'),
			'caducidad' => Yii::t('app', 'Caducidad'),
			'precioUnitario' => Yii::t('app', 'Precio Unitario'),
			'claveAdq' => Yii::t('app', 'Clave Adq'),
			'idUnidades' => Yii::t('app', 'Id Unidades'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('cantidadInicial',$this->cantidadInicial);

		$criteria->compare('existencias',$this->existencias);

		$criteria->compare('caducidad',$this->caducidad,true);

		$criteria->compare('precioUnitario',$this->precioUnitario);

		$criteria->compare('claveAdq',$this->claveAdq,true);

		$criteria->compare('idUnidades',$this->idUnidades);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        /**
         * funcion para actualizar la cantidad de existencias
         * @param int $idProducto PK
         * @param double $cantidad
         * @param string $op ('+' o '-')
         * @return boolean
         */
        public function actualizaCantidad($idProducto,$cantidad,$op)
        {
            $model = false;
            $model = Productos::model()->findByPk($idProducto);
            if($model)
            {
                $cantidadActual=$model->existencias;
                if($op=='+')
                {
                    $model->existencias += $cantidad;                    
                }
                else if ($op == '-')
                {
                    $model->existencias -= $cantidad;
                }
                if($model->save())
                {
                    $objBitacora = new Bitacora();                        
                    $objBitacora->setMovimiento('EDITAR','Productos','existencias',$model->id,$cantidadActual,7);
                    return true;
                }    
                else
                    return false;
            }
            else
            {
                return false;
            }    
        }
}
