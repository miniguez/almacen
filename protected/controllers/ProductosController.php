<?php

class ProductosController extends Controller
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
				'actions'=>array('index','create','update','admin','delete','view','ocpendientes'),
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
		$model=new Productos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productos']))
		{
			$model->attributes=$_POST['Productos'];
                        $model->precioUnitario=str_replace(",","",$model->precioUnitario);
			$model->precioUnitario=str_replace("$","",$model->precioUnitario);                       
			if($model->save())
                        {
                            $objBitacora = new Bitacora();
                            $objBitacora->setMovimiento('CREAR','Productos','',$model->id,'',4);
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

		if(isset($_POST['Productos']))
		{
			$model->attributes=$_POST['Productos'];
                        $modelOld= Productos::model()->findByPK($model->id);
			if($model->save() )
                        {
                            $objBitacora = new Bitacora();
                            ($modelOld->nombre != $model->nombre) ? $objBitacora->setMovimiento('EDITAR','Productos','nombre',$model->id,$modelOld->nombre,4) : false;
                            ($modelOld->cantidadInicial != $model->cantidadInicial) ? $objBitacora->setMovimiento('EDITAR','Productos','cantidadInicial',$model->id,$modelOld->cantidadInicial,4) : false;
                            ($modelOld->existencias != $model->existencias) ? $objBitacora->setMovimiento('EDITAR','Productos','existencias',$model->id,$modelOld->existencias,4) : false;
                            ($modelOld->caducidad != $model->caducidad) ? $objBitacora->setMovimiento('EDITAR','Productos','caducidad',$model->id,$modelOld->caducidad,4) : false;
                            ($modelOld->precioUnitario != $model->precioUnitario) ? $objBitacora->setMovimiento('EDITAR','Productos','precioUnitario',$model->id,$modelOld->precioUnitario,4) : false;
                            ($modelOld->idUnidades != $model->idUnidades) ? $objBitacora->setMovimiento('EDITAR','Productos','idUnidades',$model->id,$modelOld->idUnidades,4) : false;
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
                Productos::model()->deleteByPk($id);
                $objBitacora = new Bitacora();
                $objBitacora->setMovimiento('ELIMINAR','Productos','',$id,'',4);
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
		$dataProvider=new CActiveDataProvider('Productos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Productos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productos']))
			$model->attributes=$_GET['Productos'];

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
		$model=Productos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
