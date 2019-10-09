<?php

namespace backend\controllers\apples;

use common\models\Apple;
use \yii\base\Action;
use yii\web\Response;

/**
 * Class CreateAction
 * @package backend\controllers\apples
 */
class CreateAction extends Action
{
    /**
     * @return array
     * @throws \Exception
     */
    public function run(): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $count = mt_rand(1, 10);
        $apples = [];

        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            if ($apple->save()) {
                $apples[] = $apple;
            }
        }

        return ['success' => true, 'apples' => $apples];
    }
}