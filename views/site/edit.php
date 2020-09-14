<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'My Yii Application';

$is_disabled = (Yii::$app->user->identity->role != 'ROLE_ADMIN' && $user->approved);
?>

<div class="site-index">

    <div class="jumbotron">
        <p class="lead"><?= $user->fio; ?></p>
    </div>

    <div class="body-content">
<?php
			echo $is_disabled ? '<p class="warning">Вы не можете редактировать даты после их утверждения</p>' : '';
			
			$form = ActiveForm::begin(['id' => 'date-form']);

			echo $form->field($model, 'date_start')->label('Дата начала отпуска')->input('date', ['value' => $user->date_start, 'autofocus' => true, 'disabled' => $is_disabled]);

			echo $form->field($model, 'date_end')->label('Дата окончания отпуска')->input('date', ['value' => $user->date_end, 'disabled' => $is_disabled]);

			if(!Yii::$app->user->isGuest && (Yii::$app->user->identity->role == 'ROLE_ADMIN')){
				echo $form->field($model, 'approved')->label('Утверждено')->checkbox([
					'template' => "{input} {label}\n{error}",
					'checked' => $user->approved ? true : false
				]);
			}
			
			echo $form->field($model, 'user_id')->input('hidden', ['value' => $user->id])->label('');
?>
			<div style="clear: both"></div>
			
			<div class="form-group">
				<?php if(!$is_disabled) echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'contact-button']); ?>
				<a href="/" class="btn btn-primary">Отмена</a>
			</div>

		<?php ActiveForm::end(); ?>		
    </div>
</div>
