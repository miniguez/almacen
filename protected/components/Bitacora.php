<?php

class Bitacora {
	/**
	 * @Objetivo: funcion que retorna la ip del visitante
	 * @return: string ip
	 */
	public function getIp()
	{
		if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			return isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : 0;
		}else{
			return isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : 0;
		}
	}
	/**
	 * @Objetivo: funcion que retorna el nombre del navegador del visitante
         * @param string $u_agent parametro que contiene la cadena del 
         *                        explorador formada por la variable $_SERVER['HTTP_USER_AGENT']
	 * @return : string bname
	 */
	public function getExplorador($u_agent)
	{
		$bname= false;
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Internet Explorer';
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
		}
		return $bname;
	}
	/**
	 * @objetivo: funcion para guardar un registro en la tabla de movimiento
	 * @param string $accion: opciones 'CREAR','EDITAR','ELIMINAR','CONSULTAR'
	 * @param string $nTabla: nombre de la tabla 
	 * @param string $cTabla: nombre del campo de la tabla en caso de EDITAR
	 * @param int $idTabla: llave primaria del registro que se afecta
	 * @param string $contenidoAnt: contenido anterior del campo de la tabla en caso de EDITAR
	 * @param int $idModulo: llame primaria del modulo desde el que se realiza la accion 
	 * @return boolean
	 */
	public function setMovimiento($accion,$nTabla='',$cTabla='',$idTabla=0,$contenidoAnt='',$idModulo)
	{
		try
		{
			$idAcceso= Yii::app()->user->getState("idAcceso");		
			$objMovimiento = new Movimientos();
			$objMovimiento->accion= $accion;
			$objMovimiento->nombreTabla= $nTabla;
			$objMovimiento->campoTabla = $cTabla;
			$objMovimiento->idTabla= $idTabla;
			$objMovimiento->contenidoAnterior=$contenidoAnt;
			$objMovimiento->idAccesos= $idAcceso;
			$objMovimiento->idModulos= $idModulo;
			if($objMovimiento->save())
				return 1; 
			else 
				return 0;               
		}
		catch (Exception $e)
		{
			return 0;
		}
	}
        /**
         * @objetivo: funcion que gaurda el acceso de un usuario
         * @param int $idUsuario : llave primaria del usuario         
         */
        public function setAcceso($idUsuario)
        {            
          //  try
            //{
                $objBitacora = new Bitacora();
                $objAcceso = new Accesos();
                $objAcceso->ip = $objBitacora->getIp();
                $objAcceso->registroSalida=0;
                $objAcceso->navegador= $objBitacora->getExplorador($_SERVER['HTTP_USER_AGENT']);
                $objAcceso->fechaEntrada=date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("y")));  
                $objAcceso->idUsuarios= $idUsuario;
                $objAcceso->save();
                Yii::app()->user->setState('idAcceso',$objAcceso->id);                    
                
                //se guarda movimiento de logueo
                $objBitacora->setMovimiento('LOGIN','Usuarios','',$idUsuario,'',1);
                return 1;
          /* }
           catch(Exception $e)
           {                                 
               return 0;
           }   */
        }
        /**
         * @objetivo: cambiar el registro de salida del acceso
         * @return: valor boolean
         */
        public function setRegistroSalida()
        {
            try 
            {
                if(Yii::app()->user->getState("idAcceso"))
                {
                    $objAcceso = Accesos::model()->findByPk(Yii::app()->user->getState("idAcceso"));
                    $objAcceso->registroSalida=1;
                    $objAcceso->save(); 
                    return 1;
                }
                else
                {
                    return 0;
                }
                
            } catch (Exception $exc) {
                return 0;
            }            
        }         
}

?>