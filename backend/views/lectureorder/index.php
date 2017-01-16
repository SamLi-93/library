<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '讲座预定管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>讲座预定管理</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
//    'query' => $query
]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        [
            'header' => '讲座id',
            'attribute' => 'lecture_id',
            'value' => function ($model) {
                return $model['lecture_id'];
            }
        ],

        [
            'header' => '预定人的读者证',
            'attribute' => 'readercode',
            'value' => function ($model) {
                return $model['readercode'];
            }
        ],

        [
            'header' => '预定时间',
            'attribute' => 'datetime',
            'value' => function ($model) {
                if ($model['datetime'] == null) {
                    return '';
                } elseif ($model['datetime'] == 0) {
                    return '';
                }
                return date('Y-m-d', $model['datetime']);
            }
        ],

//        ['class' => 'yii\grid\ActionColumn',
//            'header' => '操作',
//            'template' => '{edit} {delete}',
//            'buttons' => [
//                'edit' => function ($url, $model, $key) {
//                    $options = [
//                        'title' => '修改',
//                        'class' => 'btn btn-success btn-sm',
//                        'id' => 'edit-btn',
//                    ];
//                    $url = Url::to(['lectureorder/edit', 'id' => $model['id']]);
//                    return Html::a('修改', $url, $options);
//                },
//                'delete' => function ($url, $model, $key) {
//                    $options = [
//                        'class' => 'btn btn-success',
//                    ];
//                    $url = Url::to(['lectureorder/delete', 'id' => $model['id']]);
//                    return Html::a('删除', $url, ['onclick' => 'return check()', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn']);
//
//                },
//            ],
//        ],
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


</script>



