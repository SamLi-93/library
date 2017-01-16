<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课程管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>课程管理</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
    'pro_projectname' => $pro_projectname,
    'pro_school' => $pro_school,
    'course_list' => $course_list,
    'person_list' => $person_list,
    'query' => $query,
]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,

    'summary' => '',
    'id' => "grid",
//    'options' => ['id'=>'grid'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
//        'id',
//        'projectname',
//        'school',

        [
            'class' => 'yii\grid\CheckboxColumn',
//            'name'=>'id',
            'checkboxOptions' => function ($model, $key, $index, $column) {
                return ['value' => $model['id'], 'id' => $model['id']];
            },
        ],

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
            'header' => '课程名称',
            'attribute' => 'courcename',
            'value' => function ($model) {
                if ($model['courcename'] == null) {
                    return '';
                }
                return $model['courcename'];
            }
        ],

        [
            'header' => '有无字幕',
            'attribute' => 'subtitle',
            'value' => function ($model) {
                if ($model['subtitle'] == 0) {
                    return '无';
                } elseif ($model['subtitle'] == 1) {
                    return '有';
                }
                return $model['subtitle'];
            }
        ],

        [
            'header' => '费用结算',
            'attribute' => 'free',
            'value' => function ($model) {
                if ($model['free'] == 0) {
                    return '否';
                } elseif ($model['free'] == 1) {
                    return '是';
                } elseif ($model['free'] == '') {
                    return '';
                }
                return $model['subtitle'];
            }
        ],

        [
            'header' => '主讲人',
            'attribute' => 'teacher',
            'value' => function ($model) {
                if ($model['teacher'] == '') {
                    return '';
                }
                return $model['teacher'];
            }
        ],

        [
            'header' => '上传人',
            'attribute' => 'makingname',
            'value' => function ($model) {
                if ($model['makingname'] == '') {
                    return '';
                }
                return $model['makingname'];
            }
        ],

        [
            'header' => '审核',
            'attribute' => 'status',
            'value' => function ($model) {
                if ($model['status'] == 0) {
                    return '未审核';
                } elseif ($model['status'] == 1) {
                    return '一级审核中';
                } elseif ($model['status'] == 2) {
                    return '一级通过';
                } elseif ($model['status'] == 3) {
                    return '一级驳回';
                } elseif ($model['status'] == 4) {
                    return '二级通过';
                } elseif ($model['status'] == 5) {
                    return '二级驳回';
                } elseif ($model['status'] == 6) {
                    return '二级审核中';
                }
                return '';
            }
        ],

        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete} {reject}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    $test = Yii::$app->user->identity->name;
                    $options = [
                        'title' => '修改',
                        'class' => 'btn btn-success btn-sm',
                        'id' => 'edit-btn',
                        'onclick' => 'return checkedit(' . $model['status'] . ',"' . $model['makingname'] . '"' . ')',
                    ];
                    $url = Url::to(['videomaking/edit', 'id' => $model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['videomaking/delete', 'id' => $model['id']]);
                    return Html::a('删除', $url, ['onclick' => ' return check(' . $model['status'] . ',"' . $model['makingname'] . '"' . ')', 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn']);

                },
                'reject' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    if ($model['status'] == 1 || $model['status'] == 6) {
                        $url = Url::to(['videomaking/reject', 'id' => $model['id']]);
//                        return Html::a('驳回', '', ['class' => 'btn btn-success btn-sm gridviewreject']);
                        return Html::a('驳回', $url, ['onclick' => 'return reject(' . $model['status'] . ')', 'class' => 'btn btn-success btn-sm', 'id' => 'reject-btn']);
                    }
                },
            ],
        ],

        [
            'label' => '图片',
            'format' => 'raw',
            'value' => function ($model) {
                $url = Url::to(['pic/makingpic', 'id' => $model['id']]);
                return Html::a('图片', $url, ['title' => '图片', 'target'=>'_blank']);
            }
        ],
    ],
]);
?>

<script>
    function check(status, makingname) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        var current_user = "<?= Yii::$app->user->identity->name?>";
        var is_oneself;
        if (makingname.indexOf(current_user) >= 0) {
            is_oneself = 1;
        } else {
            is_oneself = 0;
        }
        if (status == 4 || status == 2) {
            alert('一级、二级通过不能删除!')
            return false
        }
        if (status == 0 || status == 3) {
            if (orgid == 2 || is_oneself == 1) {
                return confirm('确定删除吗？');
            } else {
                alert('只有管理员和本人可以修改!')
                return false
            }
        }
        if (status == 1 || status == 5 || status == 6) {
            if (orgid == 2) {
                return confirm('确定删除吗？');
            } else {
                alert("该记录一级审核中，不允许删除");
                return false;
            }
        }
    }

    function checkedit(status, makingname) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        var current_user = "<?= Yii::$app->user->identity->name?>";
        var is_oneself;
        if (makingname.indexOf(current_user) >= 0) {
            is_oneself = 1;
        } else {
            is_oneself = 0;
        }
        if (status == 4) {
            alert('二级通过不能修改!')
            return false
        }
        if (status == 0 || status == 3 || status == 5 || status == 2) {
            if (orgid == 2 || is_oneself == 1) {
                return true
            } else {
                alert('只有本人和管理员可以修改!')
                return false
            }
        }
        if (status == 1 || status == 6) {
            alert('审核中不能修改!')
            return false
        }
    }
</script>
<script>
    $(".gridviewverified").on("click", function () {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        if (orgid == 0) {
            alert("只有管理员或审核人可以审核！");
            return false
        } else {
            if (confirm('您确定要批量审核吗？')) {
                var ids = $("#grid").yiiGridView("getSelectedId");
                $.ajax({
                    type: "post",
                    method: "post",
                    dataType: "json",
                    data: {"ids": ids},
                    url: "<?= Url::to(['videomaking/verified']);?>",
                    success: function (data) {

                    }
                });
            } else {
                return false
            }
        }
    });

    function reject(status) {
        var orgid = <?= Yii::$app->user->identity->orgid?>;
        if (status == 1 && orgid == 1 || orgid == 2) {
            if (confirm('您确定要驳回吗？')) {
                return true;
            } else {
                return false;
            }
        } else if (status == 1 && orgid == 0) {
            alert('只有管理员和审核人有权限驳回');
            return false
        } else if (status == 6 && orgid == 2) {
            if (confirm('您确定要驳回吗？')) {
                return true;
            } else {
                return false;
            }
        } else {
            alert('只有管理员可以驳回');
            return false
        }
    }
</script>


