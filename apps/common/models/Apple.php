<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $color
 * @property string $created_at
 * @property string $fall_at
 * @property int $status
 * @property int $percent_eat
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'created_at'], 'required'],
            [['created_at', 'fall_at'], 'safe'],
            [['status', 'percent_eat'], 'integer'],
            [['color'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'created_at' => 'Created At',
            'fall_at' => 'Fall At',
            'status' => 'Status',
            'percent_eat' => 'Percent Eat',
        ];
    }
}
