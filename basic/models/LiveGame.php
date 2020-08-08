<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "live_game".
 *
 * @property int $id
 * @property int $a_id
 * @property int $b_id
 * @property int $a_score
 * @property int $b_score
 * @property string $narrator
 * @property string $image
 * @property int $start_time
 * @property int $status
 * @property int $create_time
 * @property int $update_time
 */
class LiveGame extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'live_game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['a_id', 'b_id', 'a_score', 'b_score', 'start_time', 'status', 'create_time', 'update_time'], 'integer'],
            [['narrator', 'image'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'a_id' => Yii::t('app', 'A ID'),
            'b_id' => Yii::t('app', 'B ID'),
            'a_score' => Yii::t('app', 'A Score'),
            'b_score' => Yii::t('app', 'B Score'),
            'narrator' => Yii::t('app', 'Narrator'),
            'image' => Yii::t('app', 'Image'),
            'start_time' => Yii::t('app', 'Start Time'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LiveGameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LiveGameQuery(get_called_class());
    }
}
