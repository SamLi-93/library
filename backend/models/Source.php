<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wechat_source".
 *
 * @property integer $id
 * @property string $title
 * @property string $thumb_media_id
 * @property string $author
 * @property integer $digest
 * @property integer $show_cover_pic
 * @property string $content
 * @property string $content_source_url
 * @property integer $time
 * @property string $file
 * @property integer $isdeleted
 * @property integer $status
 */
class Source extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'content_source_url'], 'required'],
            [['digest', 'show_cover_pic', 'time', 'isdeleted', 'status'], 'integer'],
            [['content'], 'string'],
            [['title', 'thumb_media_id', 'author', 'content_source_url', 'file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'thumb_media_id' => '图片素材',
            'author' => '作者',
            'digest' => '消息描述',
            'show_cover_pic' => '内容展示缩略图',
            'content' => '内容',
            'content_source_url' => '原文链接',
            'time' => 'Time',
            'file' => '缩略图',
            'isdeleted' => 'Isdeleted',
            'status' => 'Status',
        ];
    }
}
