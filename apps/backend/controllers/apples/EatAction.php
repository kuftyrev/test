<?php

namespace backend\controllers\apples;

use \yii\base\Action;
use yii\web\Response;

class EatAction extends Action
{
    public function run()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

    }

}