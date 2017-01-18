<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '人员管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>人员管理</span>
</div>

<div class="test">
    <?php if (Yii::$app->user->identity->orgid==2) {
        echo Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-success']);
    } ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'id' => "person-w1",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],

        [
            'header' => '用户名',
            'attribute' => 'username',
            'value' => function ($model) {
                if ($model['username'] == null ){
                    return '';
                }
                return $model['username'];
            }
        ],

        [
            'header' => '密码',
            'attribute' => 'password',
            'value' => function ($model) {
                if ($model['password'] == null ){
                    return '';
                }
                return $model['password'];
            }
        ],

        [
            'header' => '角色',
            'attribute' => 'orgid',
            'value' => function ($model) {
                if ($model['orgid'] == 0 ){
                    return '用户';
                } else if ($model['orgid'] == 1 ){
                    return '审核';
                } else if ($model['orgid'] == 2 ){
                    return '管理员';
                }
                return $model['orgid'];
            }
        ],

        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    $options = [
                        'title' => '修改',
                        'class' =>'btn btn-success btn-sm',
                        'id' => 'edit-btn',
                    ];
                    $url = Url::to(['account/edit','id'=>$model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    if (Yii::$app->user->identity->orgid == 2 ){
                        $url = Url::to(['account/delete','id'=>$model['id']]);
                        return Html::a('删除', $url, ['onclick'=> 'return check()', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn' ]);
                    }


                },
            ],
        ],
    ],
]);

?>
<script>
    function check() {
        if(confirm('您确定要删除吗？')){
            return true;
        }else{
            return false;
        }
    }
</script>



