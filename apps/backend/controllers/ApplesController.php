<?php


namespace backend\controllers;

use backend\controllers\apples\CreateAction;
use backend\controllers\apples\EatAction;
use backend\controllers\apples\FallAction;
use backend\controllers\apples\SettingsAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ApplesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['eat', 'fall', 'create', 'settings'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action): bool
    {
        if ($action instanceof SettingsAction) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => yii\web\ErrorAction::class,
            ],
            'eat' => [
                'class' => EatAction::class,
            ],
            'fall' => [
                'class' => FallAction::class,
            ],
            'create' => [
                'class' => CreateAction::class,
            ],
            'settings' => [
                'class' => SettingsAction::class,
            ]
        ];
    }

}