<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
            $record=Usuarios::model()->findByAttributes(array('loginName'=>$this->username));
            if($record===null)
                $this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($record->password!==md5($this->password))
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($record->estatusUsuario==1)//si el usuario esta activo
		{
                    $this->setState('idTipoUsuario',$record->idTipoUsuarios0->id);//se agrega la variable tipo a $_SESSION
		    $this->setState('id',$record->id);//se agrega la variable idUsuario a $_SESSION
                    $this->errorCode=self::ERROR_NONE;
                    $objBitacora = new Bitacora();
                    $objBitacora->setAcceso($record->id);
		}
            return !$this->errorCode;
	}
}