<?php

namespace app\controllers;

use Yii;
use app\models\Questions;
use app\models\QuestionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Response;
use yii\widgets\ActiveForm;
use app\components\Model;
use app\models\Answers;

/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class QuestionsController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Questions models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new QuestionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Questions model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $main_ans = Questions::find()
                ->joinWith(['questionRel'])
                ->andWhere(['tbl_answers.question_id' => $id])
                ->andWhere(['tbl_answers.deleted' => 0])
                ->all();
        
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'main_ans'=>$main_ans,
        ]);
    }

    /**
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Questions();
        $modelAns = new Answers();
        $data = Yii::$app->request->post();
        if (isset($data['question']) && isset($data['choice'])) {
            $i = 1;
            foreach ($data['question'] as $key => $value) {
                $parent_que_id = $model->saveQuestion($value, $data['choice'][$key]);
                if (isset($_POST['ans'][$i])) ;
                foreach ($_POST['ans'][$i] as $ans_key => $ans) {
                    $modelAns->saveAns($parent_que_id, $ans);
                    if (isset($_POST['sub_que'][$i][$ans_key])) ;
                    $sub_que_id = $model->saveQuestion($_POST['sub_que'][$i][$ans_key], $_POST['sub_choice'][$i][$ans_key], $type = 'sub_que', $parent_que_id);
                    if (isset($_POST['sub_que_ans'][$i][$ans_key])) 
                        foreach ($_POST['sub_que_ans'][$i][$ans_key] as $sub_ans_key => $sub_ans) {
                            $modelAns->saveAns($sub_que_id, $sub_ans);
                        }
                }
                $i++;
            }
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
                    'model' => $model
        ]);
    }

    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Questions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
