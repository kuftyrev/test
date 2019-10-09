<?php

namespace console\controllers;

use \common\models\User;
use \yii\console\Controller;

class AdminController extends Controller
{

    public function actionList(): void
    {
        /** @var UserModel[] $users */
        $users = User::findAll([
            'status'   => User::STATUS_ADMIN,
        ]);

        if (empty($users)) {
            echo 'Список администраторов пуст' . PHP_EOL;

            return;
        }

        foreach ($users as $user) {
            echo sprintf('%d - %s - %s', $user->getId(), $user->username, $user->email) . PHP_EOL;
        }
    }

    /**
     * @param int $id
     */
    public function actionAdd(int $id): void
    {
        $user = User::findIdentity($id);

        if (!$user instanceof User) {
            echo 'Пользователь не найден' . PHP_EOL;

            return;
        }

        if ($user->status === User::STATUS_ADMIN) {
            echo 'Пользовател уже является администратором' . PHP_EOL;

            return;
        }

        $user->status = User::STATUS_ADMIN;

        if (!$user->save()) {
            echo 'Произошла ошибка при сохранении' . PHP_EOL;

            return;
        }

        echo 'Успешно' . PHP_EOL;
    }

    /**
     * @param int $id
     * @param string $email
     */
    public function actionSetEmail(int $id, string $email): void
    {
        $user = User::findIdentity($id);

        if (!$user instanceof User) {
            echo 'Пользователь не найден' . PHP_EOL;

            return;
        }

        $user->email = $email;

        if (!$user->save()) {
            echo 'Произошла ошибка при сохранении' . PHP_EOL;

            return;
        }

        echo 'Успешно' . PHP_EOL;
    }

    /**
     * @param int $id
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function actionSetPassword(int $id, string $password): void
    {
        $user = User::findIdentity($id);

        if (!$user instanceof User) {
            echo 'Пользователь не найден' . PHP_EOL;

            return;
        }

        if (!$user->setPassword($password) || !$user->save()) {
            echo 'Произошла ошибка при сохранении' . PHP_EOL;

            return;
        }

        echo 'Успешно' . PHP_EOL;
    }
}