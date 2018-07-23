<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_questions}}".
 *
 * @property int $id
 * @property string $question
 * @property int $choice
 * @property int $deleted
 * @property string $date_entered
 * @property string $date_modified
 */
class Questions extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%tbl_questions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['question', 'choice'], 'required'],
            [['id', 'choice', 'deleted'], 'integer'],
            [['date_entered', 'date_modified', 'id', 'choice', 'deleted', 'question', 'parent_id', 'type'], 'safe'],
            [['question'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'choice' => 'Choice',
            'deleted' => 'Deleted',
            'date_entered' => 'Date Entered',
            'date_modified' => 'Date Modified',
        ];
    }

    public function saveQuestion($val = NULL, $choice = NULL, $type = NULL, $parent_que_id = NULL) {
        if (!empty($val)) {
            $model = new Questions();
            $model->question = $val;
            $model->choice = $choice;
            if (!empty($type)) {
                $model->type = $type;
            }
            if (!empty($parent_que_id)) {
                $model->parent_id = $parent_que_id;
            }
            $model->save(FALSE);
            return $model->id;
        }
    }
    
    public function getQuestionRel() {
        return $this->hasMany(Answers::className(), ['question_id' => 'id']);
    }

}
