<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\User;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use app\models\DateForm;
use app\models\SearchForm;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$query = Users::find();
 		$model = new SearchForm();
		$searchQuery = '';
		
        if ($model->load(Yii::$app->request->post()) && !empty($_POST['SearchForm']['search'])) {

 			$users = $query->select(['*'])
				->from('users')
				->where(['like', 'fio', $_POST['SearchForm']['search']])
				->all();
				
			$pagination = new Pagination([
				'defaultPageSize' => 10,
				'totalCount' => count($users),
			]);	
			
			$searchQuery = $_POST['SearchForm']['search'];	
			
        }else{
			$pagination = new Pagination([
				'defaultPageSize' => 10,
				'totalCount' => $query->count(),
			]);

			$users = $query->orderBy('id')
				->offset($pagination->offset)
				->limit($pagination->limit)
				->all();
		}	

        return $this->render('index', [
				'model' => $model,
				'users' => $users,
				'pagination' => $pagination,
				'search_query' => $searchQuery
			]);
    }

    /**
     * Displays editpage.
     *
     * @return string
     */
    public function actionEdit()
    {
		$model = new DateForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->edit()) {
            return $this->goBack();
        }
		
		$user_id = !Yii::$app->user->isGuest ? ((isset($_GET['uid']) && !empty($_GET['uid'])) ? $_GET['uid'] : Yii::$app->user->identity->id) : 0;

		if($user_id && (Yii::$app->user->identity->role == "ROLE_ADMIN" || Yii::$app->user->identity->id == $user_id)){
			$user = User::findIdentity($user_id);
			if($user){
				return $this->render('edit', [
					'model' => $model,
					'user' => $user
				]);
			}else{
				return $this->render('not_available', [
					'title' => 'Сотрудник не найден',
					'content' => 'Запрашиваемый сотрудник не существует',
				]);
			}
		}else{
			return $this->render('not_available', [
				'title' => 'Страница не доступна',
				'content' => 'Вам не разрешено просматривать данную страницу',
			]);
		}
    }

	
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
