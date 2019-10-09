<?php

namespace backend\controllers\apples;

use common\models\Apple;
use \yii\base\Action;
use yii\web\Response;

/**
 * Class FallAction
 * @package backend\controllers\apples
 */
class FallAction extends Action
{
    /**
     * @return array
     */
    public function run(): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $appleId = \Yii::$app->request->post('appleId');

            if (!$appleId) {
                throw new \Exception('POST param `id` not found');
            }

            $apple = Apple::findOne($appleId);

            if ($apple->status !== Apple::STATUS_AT_TREE) {
                throw new \Exception('Aplle must be at tree');
            }

            $apple->status = Apple::STATUS_FALL;

            return ['success' => $apple->save()];
        } catch (\Exception $e) {
            return ['success' => false, 'reason' => $e->getMessage()];
        }

    }
}