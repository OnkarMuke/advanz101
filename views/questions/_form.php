<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = 'Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(['id' => 'question-form','validateOnSubmit' => true,]); ?>
    <div class="row toAddNewDiv" id="toAddNewDiv-1">
        <div class="col-lg-7">            
            <?= $form->field($model, 'question')->textInput(['autofocus' => true,"name"=>"question[]", "class"=>"form-control chk", "id"=>"questions-question-1"]) ?>
        </div>
        <div class="col-lg-2">
            <?php
            $choicelist = app\assets\CHelper::getChoiceList();
            echo $form->field($model, 'choice')
                    ->dropDownList($choicelist, ['prompt' => 'Select Plan', "name"=>"choice[]",'class' => 'form-control sel', "id"=>"questions-choice-1"]);
            ?>
        </div>
    </div>
    <div class="toAddAns" id="toAddAns-1"></div>
    <div class="row">
        <div class="col-lg-6">

        </div>
        <div class="col-lg-5 col-lg-offset-7">
            <?= Html::a('<span class="btn-label">+ ADD NEW QUESTION </span>', '#', ['id' => 'add-new-question']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
<?php  
$this->registerJsFile('https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js',['depends' => [\yii\web\JqueryAsset::className()]]);
   $this->registerJs('
       var global_docs_count = 2;

    // To clone question and choice combo   
       $("#add-new-question").click(function (e)
       {
       e.preventDefault();
        //var target = $(".toAddNewDiv:last");
        //target.clone(true, true).insertAfter(target);
        
        $(".toAddNewDiv:lt(1)").clone().find("input, select").each(function() {
            var enameArr = $(this).attr("id").split("-");
            var input_name = enameArr[0]+"-"+enameArr[1]
                $(this).val("").attr("id", function(_, id) {
                    return input_name + "-" + global_docs_count;
                });
        }).end().insertAfter(".toAddAns:last").attr("id","toAddNewDiv-"+global_docs_count);
        $(".toAddAns:lt(1)").clone().insertAfter("#toAddNewDiv-"+global_docs_count).attr("id","toAddAns-"+global_docs_count);
        $("#toAddAns-"+global_docs_count).empty();
        global_docs_count++;
       });
//END  

//To add ans box on choice 

$(document).on("change", ".sel", function() {
    var id_val = $(this).attr("id");
    var indexVal = id_val.split("-");
    var choice = $(this).val();
    var num = 0;
    if(choice==1) num=1; 
    if(choice==2) num=5;
    var result = \'\';
    for(var i=0;i<num;i++)
    { result += "<div class=\'col-lg-7\'>Answer: <input type=\'text\' name=\'ans["+indexVal[2]+"][]\' class=\'form-control\' id = \'"+indexVal[2]+"-"+i+"\'></div><div class=\'col-lg-2 aClass\'><button class=\'subQue\' id=\'"+indexVal[2]+"-"+i+"\'>+Add Sub Quetion</button></div><br>"; }
    //$(result).insertAfter("#toAddNewDiv-"+indexVal[2]);
    $("#toAddAns-"+indexVal[2]).html(result);
});

//END

//To add Sub question to every answer

var docs_count = 1;
$(document).on("click", ".subQue", function() {

   var parent = $(this).parent().prev();
   var id_val = $(this).attr("id");
   var indexVal = id_val.split("-");
   
   $(\'<div class="col-lg-8 sub_ques"><label>Sub-Question:</label><input type="text" class="form-control txt_sub" name="sub_que[\'+indexVal[0]+\'][]"></div><div class="col-lg-3"><label>Choice:</label><select class="form-control sel_2" name="sub_choice[\'+indexVal[0]+\'][]" id ="sub_sel-\'+docs_count+\'"><option>Select</option></select></div><div class="toAddSubAns" id="toAddSubAns-\'+docs_count+\'"></div>\').insertAfter($(parent.children()));
   
var choiceOptions = {
    1 : "Single Choice",
    2 : "Multiple Choice",
    3 : "Multi-line Text"
};
var choiceSelect = $("#sub_sel-"+docs_count);
$.each(choiceOptions, function(val, text) {
    choiceSelect.append(
        $("<option></option>").val(val).html(text)
    );
});

    $(this).attr("disabled","disabled");
    docs_count++;
});
//END

//To add sub questions answer boxes

$(document).on("change", ".sel_2", function() {
    var id_val = $(this).attr("id");
    var indexVal = id_val.split("-");
    var parentEleId = $(this).parent().prev().prev().attr("id");
    var parentIndex = parentEleId.split("-");
   var choice = $(this).val();
   var num = 0;
   if(choice==1) num=1; 
   if(choice==2) num=5; 
   var result = \'\';
   for(var i=0;i<num;i++)
    { result += "<div class=\'col-lg-12\'>Sub Question Answer: <input type=\'text\' name=\'sub_que_ans["+parentIndex[0]+"]["+parentIndex[1]+"][]\' class=\'form-control\' id = \'ghghgh\'></div><br>"; }
//    $(result).appendTo(".sub_ques");
    $("#toAddSubAns-"+indexVal[1]).html(result);
});

//END

//$("form#question-form").on("submit", function(event) {
//$(".txt_sub").each(function() {
//        $(this).rules("add", 
//            {
//                required: true,
//                messages: {
//                    required: "Email is required",
//                  }
//            });
//    });
//    });
//$("#question-form").validate();
    ');      
?>