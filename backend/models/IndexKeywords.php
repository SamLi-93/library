<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "index_keywords".
 *
 * @property integer $id
 * @property string $keyword
 * @property integer $reply_type
 * @property string $content
 * @property string $pic_path
 * @property string $url
 * @property integer $media_id
 */
class IndexKeywords extends \yii\db\ActiveRecord
{
    public $imageFiles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'index_keywords';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reply_type', ], 'integer'],
            [['content','summary','media_id',], 'string'],
            [['keyword', 'pic_path', 'url','title',], 'string', 'max' => 128],
            [['imageFiles'], 'file', ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keyword' => '关键字',
            'reply_type' => '回复类型',
            'content' => '内容',
            'pic_path' => '上传图片',
            'imageFiles' => '上传图片',
            'url' => '链接地址',
            'media_id' => '素材id',
            'title' => '标题',
            'summary' => '简介',
        ];
    }
}
