<?php

class Usuarios extends CActiveRecord
{
        public $repeat_password;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Usuarios';
	}

	public function rules()
	{
		return array(
			array('loginName, password, nombreUsuario, estatusUsuario, idTipoUsuarios, idDirecciones', 'required'),
			array('estatusUsuario, idTipoUsuarios, idDirecciones', 'numerical', 'integerOnly'=>true),
			array('loginName', 'length', 'max'=>20),			
			array('nombreUsuario', 'length', 'max'=>80),
                        array('password, repeat_password', 'required','on'=>'insert'),                        
                        array('password, repeat_password', 'length', 'min'=>6, 'max'=>40),
                        array('password', 'compare', 'compareAttribute'=>'repeat_password','on'=>'insert'),
			array('id, loginName, password, nombreUsuario, estatusUsuario, idTipoUsuarios, idDirecciones', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'accesoses' => array(self::HAS_MANY, 'Accesos', 'idUsuarios'),
			'idDirecciones0' => array(self::BELONGS_TO, 'Direcciones', 'idDirecciones'),
			'idTipoUsuarios0' => array(self::BELONGS_TO, 'TipoUsuarios', 'idTipoUsuarios'),
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
			'loginName' => Yii::t('app', 'Login Name'),
			'password' => Yii::t('app', 'Password'),
			'nombreUsuario' => Yii::t('app', 'Nombre Usuario'),
			'estatusUsuario' => Yii::t('app', 'Estatus Usuario'),
			'idTipoUsuarios' => Yii::t('app', 'Id Tipo Usuarios'),
			'idDirecciones' => Yii::t('app', 'Id Direcciones'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('loginName',$this->loginName,true);

		$criteria->compare('password',$this->password,true);

		$criteria->compare('nombreUsuario',$this->nombreUsuario,true);

		$criteria->compare('estatusUsuario',$this->estatusUsuario);

		$criteria->compare('idTipoUsuarios',$this->idTipoUsuarios);

		$criteria->compare('idDirecciones',$this->idDirecciones);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
