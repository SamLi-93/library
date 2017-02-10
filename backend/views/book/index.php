<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = '新书管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>新书管理</span>
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
            'attribute'=>'name',
            'format' => 'raw',
            'header' => '选择',
            'value'=>function($model){return Html::input('checkbox','id[]',$model['id']); }
        ],
        [
            'header' => '书名',
            'attribute' => 'name',
            'value' => function ($model) {
                return $model['name'];
            }
        ],
        [
            'header' => '作者',
            'attribute' => 'author',
            'value' => function ($model) {
                return $model['author'];
            }
        ],
        [
            'header' => '条码号',
            'attribute' => 'barcode',
            'value' => function ($model) {
                return $model['barcode'];
            }
        ],
        [
            'header' => '上架日期',
            'attribute' => 'date',
            'value' => function ($model) {
                return date('Y-m-d',$model['date']);
            }
        ],
        /*[
            'header' => '获取日期',
            'attribute' => 'time',
            'value' => function ($model) {
                return date('Y-m-d',$model['time']);
            }
        ],*/
        [
            'header' => '通报情况',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['status'] == 0) {
                    return '未通报';
                }
                if ($model['status'] == 1) {
                    return Html::label('通报成功','', ['style' => 'color:red']); 
                }
                    
            }
        ],
        ['class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{edit} {delete}',
            'buttons' => [
                
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'class' => 'btn btn-success',
                    ];
                    $url = Url::to(['book/delete', 'id' => $model['id']]);
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
    function send() {
        var id = document.getElementsByName("id[]");
            check_str = '0';
            check_arr = [];
            for(k in id){
                if(id[k].checked){
                    check_str += ','+id[k].value;
                    check_arr.push(id[k].value);
                }
            }
            if(check_arr.length==0){
                alert('请至少选择一本书籍');
                return false;
            }
            
            if(check_arr.length>=8){
                alert('一次最多选择8本书籍');
                return false;
            }
            location.href="push?id="+check_str;
    }
</script>



