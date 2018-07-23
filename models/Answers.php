<?php

namespace app\models;

use Yii;
use app\models\Questions;

/**
 * This is the model class for table "{{%tbl_answers}}".
 *
 * @property int $id
 * @property int $question_id
 * @property string $answer
 * @property int $deleted
 * @property string $date_entered
 * @property string $date_modified
 */
class Answers extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%tbl_answers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['question_id', 'deleted'], 'integer'],
            [['answer'], 'string'],
            [['date_entered', 'date_modified'], 'required'],
            [['date_entered', 'date_modified','type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'answer' => 'Answer',
            'deleted' => 'Deleted',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }

    public function saveAns($parent_que_id = NULL, $ans = NULL) {
        $model = new Answers();
        if (!empty($ans)) {
                $model = new Answers();
                $model->answer = $ans;
                $model->question_id = $parent_que_id;                
                $model->save(false);
        }
    }
    
    

}
