<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '通报新书详情';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>通报新书详情</span>
</div>
<div class="widget-box widget_tableDiv">
    <div id="filter_show" class="widget-body">
        <div class="widget-main">
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                             <?= Html::a('返回', ['index'], ['class' => 'btn btn-sm btn-success'])?>                     
                             </div>
                        </td>
                    </tr>
                </tbody>
            </table>
                  
        </div>
    </div>
</div>
<div id="w2" class="grid-view">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>序号</th>
                <th>书名</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($list as $key => $value){?>
                <tr data-key="<?=$key?>">
                    <td><?=$key+1?></td>
                    <td><?=$value['name']?></td>
                </tr>
            <?}?>
            <?if(count($list)==0){?>
                <tr><td colspan="12"><?=$error?></td></tr>
            <?}?>
        </tbody>
    </table>
</div>