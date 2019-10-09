<?php

namespace backend\controllers\apples;

use common\models\Apple;
use \yii\base\Action;
use yii\web\Response;

/**
 * Class EatAction
 * @package backend\controllers\apples
 */
class EatAction extends Action
{
    /**
     * @return array
     * @throws \Throwable
     */
    public function run(): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $appleId = \Yii::$app->request->post('appleId');
            $percent = \Yii::$app->request->post('percent');

            if (!isset($appleId, $percent)) {
                throw new \Exception('POST params not found');
            }

            if (!\is_numeric($percent)) {
                throw new \Exception('percent must be numeric');
            }

            $apple = Apple::findOne($appleId);

            if (!$apple) {
                throw new \Exception('Apple Not Found');
            }

            return ['success' => $apple->eat($percent), 'size' => $apple->size];
        } catch (\Exception $e) {
            return ['success' => false, 'reason' => $e->getMessage()];
        }

    }

}