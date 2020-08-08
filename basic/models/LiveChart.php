<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "live_chart".
 *
 * @property int $id
 * @property int $game_id
 * @property int $user_id
 * @property string $content
 * @property int $status
 * @property int $create_time
 */
class LiveChart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_chart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'status', 'create_time'], 'integer'],
            [['content'], 'string', 'max' => 200],
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
            'user_id' => Yii::t('app', 'User ID'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
