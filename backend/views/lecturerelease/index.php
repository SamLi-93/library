<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '讲座管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>讲座管理</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
    // 'query' => $query
]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
//    'id' => "waitforcheck",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
//        'id',
//        'projectname',
//        'school',

        [
            'header' => '讲座名',
            'attribute' => 'title',
            'value' => function ($model) {
                return $model['title'];
            }
        ],

        [
            'header' => '描述',
            'attribute' => 'content',
            'value' => function ($model) {
                return $model['content'];
            }
        ],

        [
            'header' => '讲座人',
            'attribute' => 'speaker',
            'value' => function ($model) {
                return $model['speaker'];
            }
        ],

        [
            'header' => '讲座时间',
            'attribute' => 'datetime',
            'value' => function ($model) {
                if (empty($model['datetime'])) {
                    return " ";
                }
                return date("Y-m-d H:i", $model['datetime']);
            }
        ],

        [
            'header' => '讲座地点',
            'attribute' => 'address',
            'value' => function ($model) {
                return $model['address'];
            }
        ],

        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete} {view}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    $options = [
                        'title' => '修改',
                        'class' => 'btn btn-success btn-sm',
                        'id' => 'edit-btn',
                    ];
                    $url = Url::to(['lecturerelease/edit', 'id' => $model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['lecturerelease/delete', 'id' => $model['id']]);
                    return Html::a('删除', $url, ['onclick' => 'return check()', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn']);

                },
                'view' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['lecturerelease/view', 'id' => $model['card_id']]);
                    return Html::a('卡券详情', $url, [ 'class' => 'btn btn-success btn-sm']);

                }
            ],
        ],
    ],
]);

?>
<script>
    function check() {
        if (confirm('您确定要删除吗？')) {
            return true;
        } else {
            return false;
        }
    }

    function changeover(value, id) {
        if (confirm("是否修改")) {
            $.ajax({
                type: "post",
                method: "post",
                dataType: "json",
                data: {"id": id, "value": value,},
                url: "<?= Url::to(['project/changeover']);?>",
                success: function (data) {
                    if (data.flag == 1) {
                        alert('修改成功');
                        window.location.reload()
                    }
                    if (data.flag == 0) {
                        alert('只要管理员或本人才可以修改！');
                        window.location.reload()
                    }
                }
            });
        }
    }

    function changefree(value, id) {
        if (confirm("是否修改")) {
            $.ajax({
                type: "post",
                method: "post",
                dataType: "json",
                data: {"id": id, "value": value,},
                url: "<?= Url::to(['project/changefree']);?>",
                success: function (data) {
                    if (data.flag == 1) {
                        alert('修改成功');
                        window.location.reload()
                    }
                    if (data.flag == 0) {
                        alert('只要管理员或本人才可以修改！');
                        window.location.reload()
                    }
                }
            });
        }
    }
</script>



