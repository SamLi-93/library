<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '讲座卡券详情';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>讲座卡券详情（当天数据无法查看，最早提前一天）</span>
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
                <th>日期信息</th>
                <th>浏览次数</th>
                <th>浏览人数</th>
                <th>领取次数</th>
                <th>领取人数</th>
                <th>使用次数</th>
                <th>使用人数</th>
                <th>转赠次数</th>
                <th>转赠人数</th>
                <th>过期次数</th>
                <th>过期人数</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($list as $key => $value){?>
                <tr data-key="<?=$key?>">
                    <td><?=$key+1?></td>
                    <td><span class="not-set"><?=date('Y-m-d',$value['ref_date'])?></span></td>
                    <td><?=$value['view_cnt']?></td>
                    <td><?=$value['view_user']?></td>
                    <td><?=$value['receive_cnt']?></td>
                    <td><?=$value['receive_user']?></td>
                    <td><?=$value['verify_cnt']?></td>
                    <td><?=$value['verify_user']?></td>
                    <td><?=$value['given_cnt']?></td>
                    <td><?=$value['given_user']?></td>
                    <td><?=$value['expire_cnt']?></td>
                    <td><?=$value['expire_user']?></td>
                </tr>
            <?}?>
            <?if(count($list)==0){?>
                <tr><td colspan="12"><?=$error?></td></tr>
            <?}?>
        </tbody>
    </table>
</div>