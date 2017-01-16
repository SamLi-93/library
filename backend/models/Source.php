<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $projectname
 * @property string $school
 * @property integer $over
 * @property integer $free
 * @property string $teacher
 * @property integer $time
 * @property integer $is_neibu
 * @property integer $endtime
 * @property string $original_path
 * @property string $making_path
 * @property string $uploadname
 * @property integer $pid
 */
class Source extends \yii\db\ActiveRecord
{
    public $title;
    public $author;
    public $thumb_media_id;
    public $digest;
    public $show_cover_pic;
    public $content;
    public $content_source_url;
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
            [['digest', 'show_cover_pic','time'], 'integer'],
            [['title', 'author','thumb_media_id','content_source_url'], 'string', 'max' => 255],
            [['content'], 'filter','filter' => function($value) {
                return ($value);
            }  ],
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
            'author' => '作者',
            'thumb_media_id' => '图片素材',
            'digest' => '消息描述',
            'show_cover_pic' => '内容展示缩略图',
            'content' => '内容',
            'content_source_url' => '原文链接',
            'file' => '缩略图'
        ];
    }

}
