<?php

class Accesos extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Accesos';
	}

	public function rules()
	{
		return array(
			array('ip, idUsuarios', 'required'),
			array('registroSalida, idUsuarios', 'numerical', 'integerOnly'=>true),
			array('ip', 'length', 'max'=>15),
			array('navegador', 'length', 'max'=>100),
			array('fechaEntrada', 'safe'),
			array('id, ip, registroSalida, navegador, fechaEntrada, idUsuarios', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idUsuarios0' => array(self::BELONGS_TO, 'Usuarios', 'idUsuarios'),
			'movimientoses' => array(self::HAS_MANY, 'Movimientos', 'idAccesos'),
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
			'ip' => Yii::t('app', 'Ip'),
			'registroSalida' => Yii::t('app', 'Registro Salida'),
			'navegador' => Yii::t('app', 'Navegador'),
			'fechaEntrada' => Yii::t('app', 'Fecha Entrada'),
			'idUsuarios' => Yii::t('app', 'Id Usuarios'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('ip',$this->ip,true);

		$criteria->compare('registroSalida',$this->registroSalida);

		$criteria->compare('navegador',$this->navegador,true);

		$criteria->compare('fechaEntrada',$this->fechaEntrada,true);

		$criteria->compare('idUsuarios',$this->idUsuarios);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
