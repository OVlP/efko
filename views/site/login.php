<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->label('Имя пользователя')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->label('Пароль')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-11">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="" style="color:#999;">
        Вы можете войти в систему под именами: <strong>admin</strong>, <strong>user1</strong>, <strong>user2</strong>, ..., <strong>user15</strong><br>
        <strong>Пароль</strong> совпадает с именем пользователя
    </div>
</div>
