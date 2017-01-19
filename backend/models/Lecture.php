<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lecture".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $speaker
 * @property integer $datetime
 * @property string $address
 */
class Lecture extends \yii\db\ActiveRecord
{
    public $logo_url;
    public $brand_name;
    public $notice;
    public $service_phone;
    public $description;
    public $begin_timestamp;
    public $end_timestamp;
    public $quantity;
    public $custom_url_name;
    public $custom_url;
    public $custom_url_sub_title;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','card_id'], 'string'],
            [['datetime'], 'required'],
            [['title', 'address'], 'string', 'max' => 255],
            [['speaker'], 'string', 'max' => 64],
            [['notice'], 'string', 'max' => 32],
            [['service_phone'], 'integer'],
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
            'content' => '描述',
            'speaker' => '讲座人',
            'datetime' => '讲座时间',
            'address' => '讲座地点',
            'card_id' => '卡券',
            'logo_url' => '缩略图',
            'brand_name' => '讲座名字',
            'notice' => '卡券使用提醒',
            'service_phone' => '联系电话',
            'description' => '卡券使用说明',
            'begin_timestamp' => '起用时间',
            'end_timestamp' => '结束时间',
            'quantity' => '卡券库存数量',
            'custom_url_name' => '自定义跳转外链的入口名字',
            'custom_url' => '自定义跳转URL',
            'custom_url_sub_title' => '显示在入口右侧的提示语',

        ];
    }


    public function getlectureName()
    {
        $list = self::findBySql('select id, title from lecture')->all();
        $pro_list = [];
        foreach ($list as $k => $v) {
//            array_push($pro_list, $v['projectname']);
            $key = $v['title'];
            $pro_list[$v['id']] = $v['title'] ;
        }
        return $pro_list;
    }
}
