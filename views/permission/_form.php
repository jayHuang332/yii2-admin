<?php

use jackh\admin\components\RouteRule;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model jackh\admin\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */

$rules = array_keys(Yii::$app->getAuthManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
?>

<div class="auth-item-form">
    <?php $form = ActiveForm::begin();?>
    <div class="row">
        <div class="col-sm-6">
            <?=$form->field($model, 'name')->textInput(['maxlength' => 64])?>

            <?=$form->field($model, 'description')->textarea(['rows' => 5])?>
        </div>
        <div class="col-sm-6">
            <?=$form->field($model, 'ruleName')->dropDownList($rules, ['prompt' => ' --select rule'])?>

            <?=$form->field($model, 'data')->textarea(['rows' => 5])?>
        </div>
    </div>
    <div class="form-group">
        <?php
echo Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), [
    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
?>
    </div>

    <?php ActiveForm::end();?>
</div>
