<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SearchForm is the model behind the contact form.
 */
class SearchForm extends Model
{
    public $search;

    /**
     * @return array the validation rules.
     */
    public function rules(){
        return [];
    }

	
    /**
     * Search datas
     * @return bool whether the model passes validation or users data
     */
    public function search(){
        if ($this->validate()) {
			$params = [':fio' => '%'.$_POST['SearchForm']['search'].'%'];
			
			$query = "SELECT * FROM users WHERE fio LIKE :fio";
			
			$users = Yii::$app->db->createCommand($query, $params)->queryAll();
		   
			return $users;
        }
        return false;
    }	
}
