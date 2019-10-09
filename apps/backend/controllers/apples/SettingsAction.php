<?php

namespace backend\controllers\apples;

use common\models\Apple;
use yii\base\Action;
use yii\web\Response;

/**
 * Class SettingsAction
 * @package backend\controllers\apples
 */
class SettingsAction extends Action
{
    /**
     * @return array
     */
    public function run():array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return Apple::getSettings();
    }


}