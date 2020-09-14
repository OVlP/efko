<?php
//namespace app\models;

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

?>

<?php
	$page_title = !empty($search_query) ? 'Результаты поиска по запросу: «'.$search_query.'»' : 'График отпусков сотрудников';
	echo '<h1>'.$page_title.'</h1>';

	
	$form = ActiveForm::begin([
        'id' => 'search-form',
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-3\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]);
	echo $form->field($model, 'search')->label('')->textInput(['value' => $search_query, 'placeholder' => 'Поиск по имени', 'autofocus' => true]);
?>
	<div class="form-group">
<?php
		echo Html::submitButton('Найти', ['class' => 'btn btn-primary', 'name' => 'contact-button']);
		if(!empty($search_query)) echo ' <a href="/" class="btn btn-primary">Сбросить</a>';
?>			
	</div>

<?php ActiveForm::end(); ?>	
		
<table class="table_users">
<thead>
	<td>id</td><td>Имя</td><td>Login</td><td>Начало отпуска</td><td>Конец отпуска</td><td>Статус</td><td></td>
</thead>

<?php foreach ($users as $user): ?>

    <tr class="<?= $user->approved ? 'approved' : 'panding' ?>">
<?php
		$user_date_start = Yii::$app->formatter->asDate($user->date_start, 'dd.MM.yyyy');
		$user_date_end = Yii::$app->formatter->asDate($user->date_end, 'dd.MM.yyyy');
		
		$status = $user->approved ? 'Утвержден' : '';
		$html = "<td>{$user->id}</td><td>{$user->fio}</td><td>{$user->username}</td><td>{$user_date_start}</td><td>{$user_date_end}</td><td>{$status}</td>";

		$action = '';
		
		if(!Yii::$app->user->isGuest && (Yii::$app->user->identity->role == 'ROLE_ADMIN' || (Yii::$app->user->identity->id == $user->id && !Yii::$app->user->identity->approved)))
			$action .= '<a href="/index.php?r=site%2Fedit&uid='.$user->id.'">Редактировать</a>';
		
		$html .= '<td>'.$action.'</td>';

		echo $html;
?>
    </tr>
	
<?php endforeach; ?>

</table>

<?= LinkPager::widget(['pagination' => $pagination]) ?>

