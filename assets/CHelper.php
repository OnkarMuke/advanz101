<?php

namespace app\assets;

use yii\base\Component;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * CHelper Component
 *
 */
class CHelper extends Component {

    public function init() {
        parent::init();
    }
    
    public static function getChoiceList(){
        $choice = [
            ['id'=>1,'name'=>'Single Choice'],
            ['id'=>2,'name'=>'Multiple Choice'],
            ['id'=>3,'name'=>'Multi-line Text'],
        ];
        $array_choice = ArrayHelper::map($choice, 'id', 'name');
        return $array_choice;
    }

}
