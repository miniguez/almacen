<?php

/**
 * This is the model class for table "ocRecepcionaromg".
 *
 * The followings are the available columns in table 'ocRecepcionaromg':
 * @property string $Nombre
 * @property string $id
 * @property string $Fecha
 * @property integer $TiempoEntrega
 * @property string $producto
 * @property double $Cantidad
 * @property string $Razon_Social
 * @property string $idProveedor
 * @property string $idDetalleoc
 * @property string $productoNombre
 * @property string $productoPresentacion
 * @property string $idProducto
 * @property string $unidadNombre
 * @property double $precioUnitario
 */
class OcRecepcionaromg extends AltActiveRecord
{
        public $estatus,$observaciones;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OcRecepcionaromg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
        return Yii::app()->dbAdq;
    }
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ocRecepcionaromg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, TiempoEntrega, Cantidad, Razon_Social', 'required'),
			array('TiempoEntrega', 'numerical', 'integerOnly'=>true),
			array('Cantidad', 'numerical'),
			array('Nombre,productoNombre, productoPresentacion,unidadNombre', 'length', 'max'=>255),
			array('id,idProveedor,idDetalleoc', 'length', 'max'=>20),
                        array('estatus', 'length', 'max'=>10),
                        array('observaciones', 'length', 'max'=>255),
			array('producto', 'length', 'max'=>511),
                        array('precioUnitario', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Nombre, id, Fecha, TiempoEntrega, producto, Cantidad, Razon_Social,idProveedor,unidadNombre', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Nombre' => 'Dirección',
			'id' => 'Num. OC',
			'Fecha' => 'Fecha',
			'TiempoEntrega' => 'Entrega',
			'producto' => 'Producto',
			'Cantidad' => 'Cantidad',
			'Razon_Social' => 'Proveedor',
                        'idProveedor'=>'Id Proveedor',
                        'idDetalleoc' => 'Id Detalleoc',
			'productoNombre' => 'Producto Nombre',
			'productoPresentacion' => 'Producto Presentacion',
			'idProducto' => 'Id Producto',
                        'unidadNombre'=>'Unidad',
                        'precioUnitario'=>'Precio',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Nombre',$this->Nombre,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('TiempoEntrega',$this->TiempoEntrega);
		$criteria->compare('producto',$this->producto,true);
		$criteria->compare('Cantidad',$this->Cantidad);
		$criteria->compare('Razon_Social',$this->Razon_Social,true);
                $criteria->order='id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchEntrega()
        {
            // Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Nombre',$this->Nombre,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('TiempoEntrega',$this->TiempoEntrega);
		$criteria->compare('producto',$this->producto,true);
		$criteria->compare('Cantidad',$this->Cantidad);
                $criteria->order='id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}