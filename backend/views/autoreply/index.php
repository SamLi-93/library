<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '自动回复';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>自动回复</span>
</div>

<?php echo $this->render('_search', [
    'model' => $searchModel,
//    'query' => $query
]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
//    'id' => "waitforcheck",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
//        'id',

        [
            'header' => '关键字',
            'attribute' => 'keyword',
            'value' => function ($model) {
                return $model['keyword'];
            }
        ],

        [
            'header' => '回复类型',
            'attribute' => 'reply_type',
            'value' => function ($model) {
                if ($model['reply_type'] == 1) {
                    return "文本";
                } elseif($model['reply_type'] ==2 ) {
                    return "图片";
                } elseif($model['reply_type'] == 3) {
                    return "图文";
                }
            }
        ],

        [
            'header' => '回复内容',
            'attribute' => 'content',
            'value' => function ($model) {
                return $model['content'];
            }
        ],

        [
            'header' => '标题',
            'attribute' => 'title',
            'value' => function ($model) {
                return $model['title'];
            }
        ],

        [
            'header' => '简介',
            'attribute' => 'summary',
            'value' => function ($model) {
                return $model['summary'];
            }
        ],
     
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '图片地址',
            //'attribute' => 'pic_path',
            'template' => '{link}',
            'buttons' => [
                'link' => function ($url, $model, $key) {
                    $options = [
                        'title' => '查看',
                        'id' => 'edit-btn',
                        'target' => '_blank'
                    ];
                    $url = $model['pic_path'];
                    $text = "";
                    if(!empty($model['pic_path'])){
                        $text = mb_substr($model['pic_path'] , 0 , 25).'...'; 
                    }
                    return Html::a($text, $url, $options);
                }
            ]
        ],
        [
            'header' => '链接地址',
            'attribute' => 'url',
            'value' => function ($model) {
                return $model['url'];
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
                    $url = Url::to(['autoreply/edit', 'id' => $model['id']]);
                    return Html::a('修改', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['autoreply/delete', 'id' => $model['id']]);
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

</script>



