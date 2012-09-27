<?php

class ArecepcionarController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			array(
	                          'application.Filters.YXssFilter',
	                          'clean'   => '*',
	                          'tags'    => 'strict',
	                          'actions' => 'all'
	                    ), 'accessControl',
		);
	}

	public function accessRules()
	{
                return array(
			array('allow',
				'actions'=>array('ocpendientes','recepcionar','desplegarOc'),
				'expression'=>'Yii::app()->user->getState("idTipoUsuario")==1',
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	
        public function actionOcpendientes()
        {
            $model=new OcRecepcionaromg('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['OcRecepcionaromg']))
                $model->attributes=$_GET['OcRecepcionaromg'];

            $this->render('ocpendientes',array(
			  'model'=>$model,
            ));
        }

        public function actionRecepcionar()
        {            
            $model=new OcRecepcionaromg();            
            $recepcionado=false;
            $mRecepcion= new Recepciones();
            if(isset($_POST['OcRecepcionaromg']))
            {                
                $model->attributes=$_POST['OcRecepcionaromg'];              
            }
            else
            {
                $model->estatus='COMPLETO';
            }
            $mRec=false;
            if(isset($_POST['yt0']))
            {                 
                $mRec= Recepciones::model()->find('idOrdenCompra=:parent_id',array(':parent_id'=>(int) $_POST['OcRecepcionaromg']['id']));
                if($mRec)//si la orden de compra ya fue recepcionada
                {
                     $mRec=true;                    
                }
            }
            //se guarda la recepcion si todo esta completo
            if(isset($_POST['yt1']))
            {                
                $modelRecepcion= new Recepciones();              
                $mOc=false;
                $mOc= OcRecepcionaromg::model()->find('id=:parent_id',array(':parent_id'=>(int) $_POST['OcRecepcionaromg']['id']));
                if($mOc)
                {                    
                    $recepcionado = Recepciones::model()->find('idOrdenCompra=:parent_id',array(':parent_id'=>(int) $_POST['OcRecepcionaromg']['id']));
                    $estatus="INCOMPLETO";
                    if(isset($_POST['oc-grid_c6_all']))//si la recepcion esta completa
                    {
                        $estatus="COMPLETO";
                    }
                    if(!$recepcionado) // si no ha sido recepcionado
                    {
                        $recepcionado= new Recepciones();
                        $recepcionado->proveedor=$mOc->Razon_Social;
                        $recepcionado->estatus= $estatus;
                        $recepcionado->observaciones=$_POST['OcRecepcionaromg']['observaciones'];
                        $recepcionado->idOrdenCompra=$mOc->id;
                    }                  
                    if($recepcionado->save())
                    {
                        $objBitacora = new Bitacora();
                        $objBitacora->setMovimiento('CREAR','Recepciones','',$recepcionado->id,'',6);
                        if($recepcionado->estatus=="COMPLETO")
                        {
                            $recepcionado->setDetallesRecepcionCompleta($mOc->id,$recepcionado->id);
                        }
                        else
                        {
                            if(isset($_POST['oc-grid_c6']))
                            {
                                $detalles= $_POST['oc-grid_c6'];
                                $recepcionado->setDetalleRecepcionIncompleto($mOc->id,$recepcionado->id,$detalles);                                
                            }                            
                        }
                        
                    }
                    Yii::app()->user->setFlash('success',Yii::t('app','Item successfully added')); 
                    $this->redirect(array('recepcionar'));
                }
                else//si no existe orden de compra 
                {
                   Yii::app()->user->setFlash('error',Yii::t('app','Item not found')); 
                }
                
            }
            $this->render('recepcionar',array(
			  'model'=>$model,
                          'mRecepcion'=>$mRecepcion,
                          'mRec'=>$mRec,
            ));
        }

        public function actionDesplegarOc()
        {
            $data = OcRecepcionaromg::model()->findAll('idProveedor=:parent_id',array(':parent_id'=>(int) $_POST['OcRecepcionaromg']['Razon_Social']));
            $data = CHtml::listData($data,'id','id');
            echo CHtml::tag('option',array('value' => ''),Yii::t('app','Select a Oc...'),true);
                foreach($data as $id => $value)
                {
                    echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
                }
       }
	
}

