<?php

class Faltantes extends CActiveRecord
{
        public $direccion,$idOrdenCompra,$producto,$unidad,$proveedor;
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
			array('cantidad,idOrdenCompra', 'numerical'),                        
			array('estatus, tipo', 'length', 'max'=>9),
                        array('fechaRegistro','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('direccion,producto,unidad,proveedor','length','max'=>120),
			array('id, cantidad, estatus, fechaRegistro, fechaEntrega, tipo, idDetalleVales, idDetalleRecepciones,direccion', 'safe', 'on'=>'search'),
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
                        'direccion'=>Yii::t('app','Dirección'),
                        'idOrdenCompra'=>Yii::t('app','Num. OC'),
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
            $criteria=new CDbCriteria;
            $criteria->with = array('idDetalleRecepciones0.idRecepciones0',
                                    'idDetalleRecepciones0.idIOProductos0.idProductos0.idUnidades0');            
	    $criteria->compare('t.id',$this->id);
            $criteria->compare('idRecepciones0.idOrdenCompra',$this->idOrdenCompra);
	    $criteria->compare('idDetalleRecepciones0.direccion',$this->direccion,true);    	    
	    $criteria->compare('idProductos0.nombre',$this->producto,true);
	    $criteria->compare('idUnidades0.nombre',$this->unidad,true);
	    $criteria->compare('idRecepciones0.proveedor',$this->proveedor,true);          
            $criteria->compare('t.estatus','CREADO');
            return new CActiveDataProvider(get_class($this), array(
                    'criteria'=>$criteria,
            ));        
        }
        /**
         *
         * @param array $detalles 
         */
        public function recepcion($detalles)
        {          
            foreach($detalles as $detalle)
            {
                $model=false;
                $model = Faltantes::model()->findByPk($detalle);
                if($model)
                {
                    $model->estatus = 'ENTREGADO';   
                    $model->fechaEntrega=date("Y-m-d H:i:s");
                    if($model->save())
                    {
                        $objBitacora = new Bitacora();                        
                        $objBitacora->setMovimiento('EDITAR','Faltantes','estatus',$model->id,'CREADO',7);
                        
                        //actualizar almacen, detallerecepcion y recepcion
                        $modelDetalle=$model->idDetalleRecepciones0;
                        $modelDetalle->estatus='ENTREGADO';
                        if($modelDetalle->save())//actualiza detalle
                        {
                           $objBitacora = new Bitacora();                        
                           $objBitacora->setMovimiento('EDITAR','DetalleRecepciones','estatus',$modelDetalle->id,'NOENTREGA',7); 
                            
                           $modelRecepcion=false; 
                           $modelRecepcion= Recepciones::model()->findByPk($modelDetalle->idRecepciones); 
                           if($modelRecepcion)
                           {
                               $modelRecepcion->actualizaEstatus();
                           }
                            
                           $modelpro= new Productos(); 
                           $modelpro->actualizaCantidad($modelDetalle->idIOProductos0->idProductos0->id,$modelDetalle->cantidad,'+');
                        }
                    }
                }
            }
        }
}
