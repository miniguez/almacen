<?php

class Recepciones extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Recepciones';
	}

	public function rules()
	{
		return array(
			array('proveedor, estatus, idOrdenCompra', 'required'),
			array('idOrdenCompra', 'numerical', 'integerOnly'=>true),
			array('proveedor', 'length', 'max'=>185),
			array('estatus', 'length', 'max'=>20),
                        array('observaciones', 'length', 'max'=>255),
                        array('fecha','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('idOrdenCompra','unique','message'=>'La orden de compra '.Yii::t('app','already exist')),
			array('id, proveedor, fecha, estatus, Observaciones, idOrdenCompra', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'detalleRecepciones' => array(self::HAS_MANY, 'DetalleRecepciones', 'idRecepciones'),
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
			'proveedor' => Yii::t('app', 'Proveedor'),			
			'fecha' => Yii::t('app', 'Fecha'),
			'estatus' => Yii::t('app', 'Estatus'),
			'observaciones' => Yii::t('app', 'Observaciones'),
			'idOrdenCompra' => Yii::t('app', 'Id Orden Compra'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('proveedor',$this->proveedor,true);		

		$criteria->compare('fecha',$this->fecha,true);

		$criteria->compare('estatus',$this->estatus,true);

		$criteria->compare('observaciones',$this->observaciones,true);

		$criteria->compare('idOrdenCompra',$this->idOrdenCompra);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        /**
         * funcion para guardar los detalles de recepcion
         * @param int $idOc
         * @param int $idRecepcion
         * @return boolean
         */
        public function setDetallesRecepcionCompleta($idOc,$idRecepcion)
        {
            $modelVista=false;
            $modelVista= OcRecepcionaromg::model()->findAll('id=:parent_id',array(':parent_id'=>$idOc));
            if($modelVista)
            {
                $ingresaDetalles= 1;
                foreach ($modelVista as $detalle)
                {                    
                    $idIoproducto=$this->setIoproducto($detalle);                                   
                    $modelDetalleRecepcion= new DetalleRecepciones();
                    $modelDetalleRecepcion->estatus='ENTREGADO';
                    $modelDetalleRecepcion->cantidad=$detalle->Cantidad;
                    $modelDetalleRecepcion->idDetalleoc=$detalle->idDetalleoc;
                    $modelDetalleRecepcion->idIOProductos=$idIoproducto;
                    $modelDetalleRecepcion->idRecepciones=$idRecepcion;  
                    $modelDetalleRecepcion->direccion=$detalle->Nombre;
                    if($modelDetalleRecepcion->save())
                    {
                        //se actualiza la entrada 
                        $objIo= new Productos();
                        $objIo->actualizaCantidad($modelDetalleRecepcion->idIOProductos0->idProductos0->id,$modelDetalleRecepcion->cantidad,'+');
                        $objBitacora = new Bitacora();
                        $objBitacora->setMovimiento('CREAR','DetalleRecepciones','',$modelDetalleRecepcion->id,'',6);                        
                    } 
                    else
                    {
                        $ingresaDetalles=0; 
                    }
                }
                if($ingresaDetalles)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        /**
         * Funcion para buscar un producto por la clave de adq
         * @param string $claveAdq
         * @return int
         */
        public function getIoproducto($claveAdq)
        {
            $modelProducto=false;
            $modelIo=false;
            $modelProducto = Productos::model()->find('claveAdq=:parent_id',array(':parent_id'=>$claveAdq));
            if($modelProducto)
            {
                $modelIo= IOProductos::model()->find('idProductos=:parent_id',array(':parent_id'=>$modelProducto->id));
                if($modelIo)
                {
                    return $modelIo->id;
                }
                else
                {
                    return 0;
                }
                
            }
            else
            {
                return 0;
            }
        }
        /**
         * funcion para agregar una entrada de producto
         * @param modelo $detalle
         * @return int
         */
        public function setIoproducto($detalle,$estatus=null)
        {
            $idProducto=  $this->setProducto($detalle);
            $modelIo= new IOProductos();            
            $modelIo->cantidad=$detalle->Cantidad;
            if($estatus=='NOENTREGA')
            {
                $modelIo->tipo="ESPERA";
            }
            else
            {
                $modelIo->tipo="ENTRADA";
            }            
            $modelIo->estatus="CREADO";
            $modelIo->idProductos=$idProducto;
            if($modelIo->save())
            {
                $objBitacora = new Bitacora();
                $objBitacora->setMovimiento('CREAR','IOProductos','',$modelIo->id,'',6);
                return $modelIo->id;
            }
            else
            {
                return 0;
            }
        }

        /**
         * uncion para buscar una producto, en caso de que no existe se crea una nuevo
         * @param modelo $detalle
         * @return id de producto
         */
        public function setProducto($detalle)
        {
            $modelProducto=false;
            $modelProducto = Productos::model()->find('claveAdq=:parent_id',array(':parent_id'=>$detalle->idProducto));
            if($modelProducto)
            {
                return $modelProducto->id;
            }
            else
            {
                $modelProducto= new Productos();
                $idUnidad= false;
                $idUnidad= $this->setUnidad($detalle->unidadNombre);
                $modelProducto->nombre = $detalle->productoNombre;
                $modelProducto->cantidadInicial=$detalle->Cantidad;
                $modelProducto->existencias=$detalle->Cantidad;
                $modelProducto->precioUnitario= $detalle->precioUnitario;
                $modelProducto->claveAdq= $detalle->idProducto;
                $modelProducto->idUnidades = $idUnidad;
                if($modelProducto->save())
                {
                    $objBitacora = new Bitacora();
                    $objBitacora->setMovimiento('CREAR','Productos','',$modelProducto->id,'',6);
                    return $modelProducto->id;
                }
                else
                {
                    return 0;
                }
            }
            
        }

        /** 
         * funcion para buscar una unidad, en caso de que no existe se crea una nueva
         * @param string $nomUnidad
         * @return int idUnidad
         */
        public function setUnidad($nomUnidad)
        {
            $modelUndiad=false;
            $modelUndiad= Unidades::model()->find('nombre=:parent_id',array(':parent_id'=>$nomUnidad));
            if($modelUndiad)
            {
                return  $modelUndiad->id;
            }
            else
            {
                $modelUndiad= new Unidades();
                $modelUndiad->nombre=$nomUnidad;
                if($modelUndiad->save())
                {
                    $objBitacora = new Bitacora();
                    $objBitacora->setMovimiento('CREAR','Unidades','',$modelUndiad->id,'',6);
                    return $modelUndiad->id;
                }
                else
                {
                    return 0;
                }
            }
        }
        /**
         * funcion para guardar detalles de una recepcion incompleta
         * @param int $idOc
         * @param int $idRecepcion
         * @param array $seleccionados
         * @return boolean
         */
        public function setDetalleRecepcionIncompleto($idOc,$idRecepcion,$seleccionados)
        {           
            $modelVista=false;
            $modelVista= OcRecepcionaromg::model()->findAll('id=:parent_id',array(':parent_id'=>$idOc));
            if($modelVista)
            {
                $ingresaDetalles= 1;
                foreach ($modelVista as $detalle)
                {
                    //se revisa que el detalle aya sido seleccionado    
                    if(in_array($detalle->idDetalleoc, $seleccionados)) 
                    {
                        $estatus="ENTREGADO";
                    }
                    else
                    {
                        $estatus="NOENTREGA";
                    }
                    $idIoproducto=$this->setIoproducto($detalle,$estatus);                                                                                                             
                    $modelDetalleRecepcion= new DetalleRecepciones();
                    $modelDetalleRecepcion->estatus=$estatus;
                    $modelDetalleRecepcion->cantidad=$detalle->Cantidad;
                    $modelDetalleRecepcion->idDetalleoc=$detalle->idDetalleoc;
                    $modelDetalleRecepcion->idIOProductos=$idIoproducto;
                    $modelDetalleRecepcion->idRecepciones=$idRecepcion;  
                    $modelDetalleRecepcion->direccion=$detalle->Nombre;
                    if($modelDetalleRecepcion->save())
                    {
                        if($modelDetalleRecepcion->estatus == 'ENTREGADO')
                        {
                            $objIo= new Productos();
                            $objIo->actualizaCantidad($modelDetalleRecepcion->idIOProductos0->idProductos0->id,$modelDetalleRecepcion->cantidad,'+');
                        } 
                        elseif ($modelDetalleRecepcion->estatus == 'NOENTREGA') //se crea un registro de flatantes
                        {
                            $modelDetalleRecepcion->registraFaltanteRecepcion();
                        }
                        $objBitacora = new Bitacora();
                        $objBitacora->setMovimiento('CREAR','DetalleRecepciones','',$modelDetalleRecepcion->id,'',6);                                                
                    }   
                    else
                    {
                        $ingresaDetalles=0;
                    }
                }
                if($ingresaDetalles)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }        
        
}
