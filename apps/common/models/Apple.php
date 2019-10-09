<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $color
 * @property string $created_at
 * @property string $fall_at
 * @property int $status
 * @property int $percent_eat
 * @property float $size
 */
class Apple extends ActiveRecord
{
    public const STATUS_AT_TREE = 0;
    public const STATUS_FALL    = 1;
    public const STATUS_ROTTEN  = 2;

    /**
     * @var $size float
     */
    private $size;

    /**
     * Apple constructor.
     * @param string $color
     * @throws \Exception
     */
    public function __construct($color = null, $config = [])
    {
        if (!$color) {
            $color = $this->getRandomColor();
        }

        $config = [
            'color' => $color,
            'created_at' => $this->randomDateInRange((new \DateTime())->modify('-1 year'), (new \DateTime()))->format('Y-m-d H:i:s'),
            'percent_eat' => 100,
            'status' => self::STATUS_AT_TREE,
        ];


        parent::__construct($config);

    }

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

    /**
     * @return string
     */
    public function getRandomColor(): string
    {
        $colors = [
            'green',
            'yellow',
            'red',
        ];

        $rnd = mt_rand(0, count($colors) - 1);

        return $colors[$rnd];
    }

    /**
     * @param int $percent
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function eat(int $percent): bool
    {
        if ($this->status !== self::STATUS_FALL) {
            throw new \Exception('Apple at tree');
        }

        $fallAt = new \DateTime($this->fall_at);
        $hoursOfFall = $fallAt->diff(new \DateTime())->h;

        if ($hoursOfFall > 5) {
            throw new \Exception('Apple is rotten');
        }

        $this->percent_eat = $this->percent_eat - $percent;

        if ($this->percent_eat <= 0) {
            return $this->delete();
        }

        return $this->save();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function fallToGround(): bool
    {
        $this->status = self::STATUS_FALL;

        $this->fall_at = (new \DateTime())->format('Y-m-d H:i:s');

        return $this->save();
    }

    /**
     * @param float $size
     * @return Apple
     */
    public function setSize(float $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return float|int
     */
    public function getSize()
    {
        return $this->percent_eat / 100;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return \DateTime
     * @throws \Exception
     */
    private function randomDateInRange(\DateTime $start, \DateTime $end): \DateTime {
        $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());

        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);

        return $randomDate;
    }

    /**
     * @return string
     */
    public function getStatusString(): string
    {
        return self::getSettings()['statuses'][$this->status];
    }

    public static function getSettings(): array
    {
        return [
            'statuses' => [
                self::STATUS_AT_TREE => 'На дереве',
                self::STATUS_FALL    => 'Упало',
            ]
        ];
    }
}
