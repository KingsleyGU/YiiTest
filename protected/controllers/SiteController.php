<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	public function actionRegister()
	{
		$inputError = null;
		$username = null;
		$password = null;
		if(isset($_POST['username'])&&isset($_POST['password']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$item = TblUser::model()->findBySql('select * from tbl_user where username="'.$username.'"');
			if(!$item)
			{			
				$model = new TblUser;
				$model->username = $username;
				$model->password = $password;
				$model->email="123@mail.com";
	            $model->save();
				$this->redirect(array('index'));
			}
			else
			{
               $inputError = "username already exist";		
			}
		}
		$this->render('register',array('username'=>$username,'password'=>$password,'error'=>$inputError,));
	}
	public function actionDetail()
	{	
	     	
		if(isset($_GET['_id']))
		{
			$id = $_GET['_id'];
		}
		else if(isset($_id))
			 $id = $_id;

		$commentJson =[];
		$currentCommentModel = Comments::model()->findAll("refer_id=:refer_id",array(":refer_id"=>$id));  
		foreach ($currentCommentModel as $num)
		{   
			$JSONCom = json_encode(array('content'=>$num->content,'author'=>$num->author));
			array_push($commentJson, $JSONCom);
		}
		$JSONObject= json_encode($commentJson);
		$item = WebData::model()->findBySql('select * from webData where id= '.intval($id));
		if($id!="")
		{
			$this->render('detail',array(
			'imageName'=>($item->imageName),'content'=>($item->content),'date'=>($item->postTime),'commentJson'=>($JSONObject),
		));
		}
	}
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
    public function accessRules()
	{
		 return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','register'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create'),
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$currentModel = WebData::model()->findAll();
        // $this->redirect(array('view',array('model'=>$currentModel)));
        $modelJson =[];
         // $this->redirect(array('view','model'=>$modelJson));
		foreach ($currentModel as $value) {
			$commentJson =[];
			$currentCommentModel = Comments::model()->findAll("refer_id=:refer_id",array(":refer_id"=>$value->id));  
			foreach ($currentCommentModel as $num)
			{
				$JSONCom = json_encode($num->content);
				array_push($commentJson, $JSONCom);
			}
			$arr = array ('postTime'=>$value->postTime,'content'=>$value->content,'imageName'=>$value->imageName, 'id'=>$value->id,'commentJson'=>$commentJson);
				
				$JSONObject= json_encode($arr);
				// echo $JSONObject;
				  array_push($modelJson, $JSONObject);
		}
			// echo json_encode($modelJson);
		$this->render('index',array(
			'model'=>$modelJson,
		));
	}
	public function actionComment()
	{
		$model=new Comments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
       
		if(isset($_POST['content'])&&isset($_POST['id']))
		{
			$currentTime = date('Y-m-d H:i:s');
	   		$model->time = $currentTime;
			$model->content=$_POST['content'];
			$model->refer_id = intval($_POST['id']);
			$model->author = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('detail','_id'=>$_POST['id']));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
    public function actionShowResult()
    {
    	$connection = Yii::app()->db;
    	$sql = "select * from Comments order by id";
    	$command  = $connection->createCommand($sql);
    	$result = $command->queryAll();
    	echo json_encode($result);
    }
	 public function actionDelete()
	{
		// $this->loadModel($id)->delete();
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
		}
		$this->loadModel(intval($id))->delete();
		$this->redirect(array('index'));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		// if(!isset($_GET['ajax']))
		// 	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionCreate()
	{
		$model=new WebData;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WebData']))
		{
			$currentTime = date('Y-m-d H:i:s');
			$_POST['WebData']['postTime'] = $currentTime;
			$model->attributes=$_POST['WebData'];
			$model->image=CUploadedFile::getInstance($model,'image');
			// $_POST['WebData']['imageName'] = $model->image->getName();
			$model->imageName=$model->image->getName();
			$model->author = Yii::app()->user->id;
			$currentImageName = $model->imageName;
			$nameLength = strlen($currentImageName);
			$imageType = substr($currentImageName,-4);
			
			// $imageType = '.jpg';
			
			if($model->save())
			{	
				
				$model->image->saveAs(Yii::getPathOfAlias('webroot').'/images/upload/'.'upImage'.$model->id.$imageType);
				// Yii::app()->user->setFlash('image','/images/upload/'.$model->image->getName());
				 // $this->redirect(array('view','id'=>$model->id));
				$tmpmodel = WebData::model()->findByPk($model->id);
				$tmpmodel->imageName = 'upImage'.$model->id.$imageType;
				$tmpmodel->save();
                $currentModel = WebData::model()->findAll();
                // $this->redirect(array('view',array('model'=>$currentModel)));
                $modelJson =[];
                 // $this->redirect(array('view','model'=>$modelJson));
				foreach ($currentModel as $value) {
					$arr = array ('postTime'=>$value->postTime,'content'=>$value->content,'imageName'=>$value->imageName);
						
						$JSONObject= json_encode($arr);
						// echo $JSONObject;
						  array_push($modelJson, $JSONObject);
						}
					// echo json_encode($modelJson);	
				  $this->redirect(array('index'));
			}
		}

		$this->render('/webData/create',array(
			'model'=>$model,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	public function loadModel($id)
	{
		$model=WebData::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}