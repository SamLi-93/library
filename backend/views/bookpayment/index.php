<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>项目管理</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
    'pro_projectname' => $pro_projectname,
    'pro_school' => $pro_school,
    'pro_teacher' => $pro_teacher,
    'pro_over' => $pro_over,
    'query' => $query
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
            'header' => '项目名称',
            'attribute' => 'projectname',
            'value' => function ($model) {
                return $model['projectname'];
            }
        ],

        [
            'header' => '学校',
            'attribute' => 'school',
            'value' => function ($model) {
                return $model['school'];
            }
        ],

        [
            'header' => '课程类型',
            'attribute' => 'is_neibu',
            'value' => function ($model) {
                if ($model['is_neibu'] == 0) {
                    return '外部';
                }
                if ($model['is_neibu'] == 1) {
                    return '内部';
                }
                return $model['is_neibu'];
            }
        ],

        [
            'header' => '是否结束',
            'attribute' => 'over',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::dropDownList('over', $model['over'], ['0' => '否', '1' => '是'],
                    ['onchange' => "changeover(this.options[this.options.selectedIndex].value," . $model['id'] . ")",]);
            }
        ],

        [
            'header' => '费用结算',
            'attribute' => 'free',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::dropDownList('free', $model['free'], ['0' => '否', '1' => '是'],
                    ['onchange' => "changefree(this.options[this.options.selectedIndex].value," . $model['id'] . ")",]);
            }
        ],

        [
            'header' => '项目联系人',
            'attribute' => 'teacher',
            'value' => function ($model) {
                if ($model['teacher'] == null) {
                    return '';
                }
                return $model['teacher'];
            }
        ],

        [
            'header' => '开始日期	',
            'attribute' => 'time',
            'value' => function ($model) {
                if ($model['time'] == null) {
                    return '';
                } elseif ($model['time'] == 0) {
                    return '';
                }
                return date('Y-m-d', $model['time']);
            }
        ],

        [
            'header' => '结束时间',
            'attribute' => 'endtime',
            'value' => function ($model) {
                if ($model['endtime'] == null) {
                    return '';
                } elseif ($model['endtime'] == 0) {
                    return '';
                }
                return date('Y-m-d', $model['endtime']);
            }
        ],

        [
            'header' => '上传路径',
            'attribute' => 'making_path',
            'value' => function ($model) {
                if ($model['making_path'] == null) {
                    return '';
                }
                return $model['making_path'];
            }
        ],

        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    $options = [
                        'title' => '修改',
                        'class' => 'btn btn-success btn-sm',
                        'id' => 'edit-btn',
                    ];
                    $url = Url::to(['project/edit', 'id' => $model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['project/delete', 'id' => $model['id']]);
                    return Html::a('删除', $url, ['onclick' => 'return check()', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn']);

                },
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



