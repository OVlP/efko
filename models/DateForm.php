<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * DateForm is the model behind the date form.
 */
class DateForm extends Model
{
    public $date_start;
    public $date_end;
    public $approved;
    public $user_id;


    /**
     * @return array the validation rules.
     */
    public function rules(){
        return [
		    // date_start and date_end are both required
            [['date_start', 'date_end'], 'required'],
			// approved must be a boolean value
            ['approved', 'boolean'],
        ];
    }

	
    /**
     * Edit datas
     * @return bool whether the model passes validation
     */
    public function edit(){
        if ($this->validate()) {
			$POST = $_POST['DateForm'];
			$params = [':id' => $POST['user_id'], ':date_start' => $POST['date_start'], ':date_end' => $POST['date_end']];
			
			if(isset($POST['approved'])){
				$params['approved'] = $POST['approved'];
				$sql_approved = ', approved=:approved';
			}else{
				$sql_approved = '';
			}	
			
			$query = 'UPDATE users set date_start=:date_start, date_end=:date_end'.$sql_approved.' WHERE id=:id';
			
			$post = Yii::$app->db->createCommand($query, $params)->execute();
		   
			return true;
        }
        return false;
    }	
}
