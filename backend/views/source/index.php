<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = '图文消息管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="center subject_name">
    <span>图文消息管理</span>
</div>
<!--div style="width:70%;padding-left:15%;">
    <a href="<?=Url::to(['source/create'])?>" class="btn btn-primary">添加消息</a>
    <a href="<?=Url::to(['source/create2'])?>" class="btn btn-primary">发送图文消息</a>
    <div  class="btn btn-primary" onclick="send()">发送消息</div>
</div-->
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
            'attribute'=>'title',
            'format' => 'raw',
            'header' => '选择',
            'value'=>function($model){return Html::input('checkbox','id[]',$model['id']); }
        ],

        [
            'header' => '标题',
            'attribute' => 'title',
            'value' => function ($model) {
                return $model['title'];
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
            'header' => '消息描述',
            'attribute' => 'digest',
            'value' => function ($model) {
                if ($model['digest'] == 0) {
                    return '否';
                }
                if ($model['digest'] == 1) {
                    return '是';
                }
                return $model['digest'];
            }
        ],
        [
            'header' => '是否内容展示封面',
            'attribute' => 'show_cover_pic',
            'value' => function ($model) {
                if ($model['show_cover_pic'] == 0) {
                    return '否';
                }
                if ($model['show_cover_pic'] == 1) {
                    return '是';
                }
                return $model['show_cover_pic'];
            }
        ],
        [
            'header' => '原文链接',
            'attribute' => 'content_source_url',
            'value' => function ($model) {
                return $model['content_source_url'];
            }
        ],
        [
            'header' => '是否发送',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['status'] == 0) {
                    return '未发送';
                }
                if ($model['status'] == 1) {
                    return Html::label('发送过','', ['style' => 'color:red']); 
                }
                    
            }
        ],
        [
            'header' => '创建时间',
            'attribute' => 'time',
            'value' => function ($model) {
                return date('Y-m-d',$model['time']);
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
                    $url = Url::to(['source/delete', 'id' => $model['id']]);
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
            check_val = [];
            for(k in id){
                if(id[k].checked)
                    check_val.push(id[k].value);
            }
            if(check_val.length==0){
                alert('请至少选择一条');
                return false;
            }else{
                if(confirm('您确定要发送吗？')){
                    $.ajax({
                        type: "post",
                        method: "post",
                        dataType: "json",
                        data: {"id": check_val},
                        url: "<?= Url::to(['source/sendmessage']);?>",
                        success: function (data) {
                            console.log(data);

                        }
                    });
                }else{
                    return false;
                }
            }
    }
</script>



