<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = '新书通报';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>新书通报</span>
</div>
<?php echo $this->render('_search', [
    'model' => $searchModel,
    'query' => $query
]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
//    'id' => "waitforcheck",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        [
            'header' => '通报名称',
            'attribute' => 'title',
            'value' => function ($model) {
                return $model['title'];
            }
        ],
        [
            'header' => '通报时间',
            'format' => 'raw',
            'value' => function ($model) {
                return date('Y-m-d',$model['date']);
            }
        ],
        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{delete}',
            'buttons' => [
                
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['notice/view', 'id' => $model['id']]);
                    return Html::a('查看', $url, [ 'class' => 'btn btn-success btn-sm', 'id' => 'delete-btn']);

                },
            ],
        ],
    ],
]);

?>



