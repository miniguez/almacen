<?php

class Unidades extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Unidades';
	}

	public function rules()
	{
		return array(
			array('nombre', 'required'),
                        array('nombre','unique','message'=>'La unidad '.Yii::t('app','already exist')),
			array('nombre', 'length', 'max'=>80),
			array('id, nombre', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'productoses' => array(self::HAS_MANY, 'Productos', 'idUnidades'),
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
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('nombre',$this->nombre,true);

                $criteria->order='id DESC';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
