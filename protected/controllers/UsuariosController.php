<?php

class UsuariosController extends Controller
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
				'actions'=>array('pass','create','update','admin','active','inactive'),
				'expression'=>'Yii::app()->user->getState("idTipoUsuario")==1',
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Usuarios;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuarios']))
		{
			$model->attributes=$_POST['Usuarios'];
                        $model->password=md5($model->password);
                        $model->repeat_password=md5($model->repeat_password);
                        $model->estatusUsuario=1;
			if($model->save())
                        {
                            $objBitacora = new Bitacora();
                            $objBitacora->setMovimiento('CREAR','Usuarios','',$model->id,'',5);
                            Yii::app()->user->setFlash('success',Yii::t('app','Item successfully added'));
                            $this->redirect(array('admin'));
                        }    				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuarios']))
		{
			$model->attributes=$_POST['Usuarios']; 
                        $modelOld= Usuarios::model()->findByPK($model->id);
			if($model->save())
                        {
                            $objBitacora = new Bitacora();
                            ($modelOld->loginName != $model->loginName) ? $objBitacora->setMovimiento('EDITAR','Usuarios','loginName',$model->id,$modelOld->loginName,5) : false;
                            ($modelOld->nombreUsuario != $model->nombreUsuario) ? $objBitacora->setMovimiento('EDITAR','Usuarios','nombreUsuario',$model->id,$modelOld->nombreUsuario,5) : false;
                            ($modelOld->idTipoUsuarios != $model->idTipoUsuarios) ? $objBitacora->setMovimiento('EDITAR','Usuarios','idTipoUsuarios',$model->id,$modelOld->idTipoUsuarios,5) : false;
                            ($modelOld->idDirecciones != $model->idDirecciones) ? $objBitacora->setMovimiento('EDITAR','Usuarios','idDirecciones',$model->id,$modelOld->idDirecciones,5) : false;                            
                            Yii::app()->user->setFlash('success',Yii::t('app','Item successfully update'));
                            $this->redirect(array('admin'));
                        }				
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Usuarios');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
       /**
        * accion para desactivar usuarios
        * @param integer $id
        */
	public function actionInactive($id)
	{            
		$model=$this->loadModel($id);
		$model->estatusUsuario=0;                
		if($model->update())
                {       
                    Yii::app()->user->setFlash('success',Yii::t('app','Item successfully update'));
                    $this->redirect(array('admin'));		
                }
                    
	}
        /**
         * funcion para activar usuarios
         * @param integer $id
         */
        public function actionActive($id)
	{
		$model=$this->loadModel($id);
		$model->estatusUsuario=1;
		if($model->update())
                {
                    Yii::app()->user->setFlash('success',Yii::t('app','Item successfully update'));
                     $this->redirect(array('admin'));
                }
	}
        /**
         * funcion para activar usuarios
         * @param integer $id
         */
        public function actionPass($id)
	{
		$model=$this->loadModel($id);                
		if(isset($_POST['Usuarios']))
		{
                    $model->attributes=$_POST['Usuarios'];
                    $model->password=md5($model->password);
                    $model->repeat_password=md5($model->repeat_password);
                    if(($model->repeat_password and $model->password) and ($model->repeat_password == $model->password))
                    {
                        if($model->save())
                        {
                            Yii::app()->user->setFlash('susses',Yii::t('app','the password was changed'));
                            $this->redirect(array('admin'));
                        }
                    }
                    else
                    {
                        Yii::app()->user->setFlash('error',Yii::t('app','the password no match'));                        
                    }
                  
		}
                $model->password = null;
		$this->render('pass',array(
			'model'=>$model,
		));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Usuarios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuarios']))
			$model->attributes=$_GET['Usuarios'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Usuarios::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
