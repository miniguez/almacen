<?php

class UnidadesController extends Controller
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
				'actions'=>array('index','create','update','admin','delete'),
				'expression'=>'Yii::app()->user->getState("idTipoUsuario")==1',
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Unidades;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Unidades']))
		{
			$model->attributes=$_POST['Unidades'];
			if($model->save())
                        {
                            $objBitacora = new Bitacora();
                            $objBitacora->setMovimiento('CREAR','Unidades','',$model->id,'',3);
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
	 * @param integer $id the ID of the model to be updated CSI-TEMP-2012
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Unidades']))
		{
			$model->attributes=$_POST['Unidades'];
                        $modelOld= Unidades::model()->findByPK($model->id);                        
			if($model->save() )
                        {
                            if($modelOld->nombre != $model->nombre)
                            {
                                $objBitacora = new Bitacora();
                                $objBitacora->setMovimiento('EDITAR','Unidades','nombre',$model->id,$modelOld->nombre,3);
                            }
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
            try
            {
                Unidades::model()->deleteByPk($id);
                $objBitacora = new Bitacora();
                $objBitacora->setMovimiento('ELIMINAR','Unidades','',$id,'',3);
                echo "<div class='alert alert-block alert-success fade in'><a class='close' data-dismiss='alert'>×</a>".Yii::t('app', 'Item successfully delete')."</div>";
            }
            catch(Exception $e)
            {
                echo "<div class='alert alert-block alert-error fade in'><a class='close' data-dismiss='alert'>×</a>".Yii::t('app', 'Item can\'t delete')."</div>";                
            }                
            
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Unidades('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Unidades']))
			$model->attributes=$_GET['Unidades'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Unidades('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Unidades']))
			$model->attributes=$_GET['Unidades'];

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
		$model=Unidades::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='unidades-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
