<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "live_outs".
 *
 * @property int $id
 * @property int $game_id
 * @property int $team_id
 * @property string $content
 * @property string $image
 * @property int $type
 * @property int $status
 * @property int $create_time
 */
class LiveOuts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_outs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'team_id', 'type', 'status', 'create_time'], 'integer'],
            [['content'], 'string', 'max' => 200],
            [['image'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'game_id' => Yii::t('app', 'Game ID'),
            'team_id' => Yii::t('app', 'Team ID'),
            'content' => Yii::t('app', 'Content'),
            'image' => Yii::t('app', 'Image'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
