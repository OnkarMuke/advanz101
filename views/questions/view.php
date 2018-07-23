<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questions */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-view">

   <section>
    <div class="row heading-bottom-border">
        <div class="col-sm-12">
            <h2 class="heading list-heading pull-left">Call</h2>
        </div>        
    </div>
    <?php
                //\common\components\CHelper::debug($model->scenario);
                $form = ActiveForm::begin([
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'horizontalCssClasses' => [
                                    'label' => 'col-sm-4',
                                    'wrapper' => 'col-sm-4 field-wrapper',
                                ],
                            ],
                            'id' => 'form-question',
                ]);
                ?>
                <div class="row form-wrapper-adjust ">
                    <div class="col-lg-12 ">
                        <div class="col-lg-10">Question:
                            <?php echo $model->question ?>
                        </div>
                        <div class="col-lg-10">Answer:
                            <?php
                            foreach ($main_ans[0]->questionRel as $key=>$ans) {
                                ?>
                            <p>
                                <?php echo ($ans->answer);?>
                            </p>
                            
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
</section>
</div>
