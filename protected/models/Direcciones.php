<?php

class Direcciones extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Direcciones';
	}

	public function rules()
	{
		return array(
			array('idDepartamentos, idProyectos', 'required'),
			array('idDepartamentos, idProyectos', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			array('id, nombre, idDepartamentos, idProyectos', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'idDepartamentos0' => array(self::BELONGS_TO, 'Departamentos', 'idDepartamentos'),
			'idProyectos0' => array(self::BELONGS_TO, 'Proyectos', 'idProyectos'),
			'usuarioses' => array(self::HAS_MANY, 'Usuarios', 'idDirecciones'),
			'vales' => array(self::HAS_MANY, 'Vales', 'idDirecciones'),
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
			'idDepartamentos' => Yii::t('app', 'Id Departamentos'),
			'idProyectos' => Yii::t('app', 'Id Proyectos'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

		$criteria->compare('idDepartamentos',$this->idDepartamentos);

		$criteria->compare('idProyectos',$this->idProyectos);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
