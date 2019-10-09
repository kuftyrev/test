<?php

use common\models\Apple;

/* @var $this yii\web\View */
/* @var $apples \common\models\Apple[] */

$this->title = 'My Yii Application';
$this->registerJs('initApplesPage()', \yii\web\View::POS_READY);

?>
<div class="site-index">
    <div class="apple-cards">
        <?php
        foreach ($apples as $apple) {
            $buttons = '<button class="btn btn-info fall" data-id="' . $apple->id . '" style="' . ($apple->status !== Apple::STATUS_AT_TREE ? 'display: none;' : '') . '">Упасть</button>';
            $buttons .=  '<div class="eat-block" style="' . ($apple->status !== Apple::STATUS_FALL ? 'display: none;' : '') . '">
                            <button class="btn btn-info eat" data-id="' . $apple->id . '">Съесть</button>
                            <input class="form-control percent-val" name="percent" type="text" value="25" data-id="' . $apple->id . '">
                            <label for="percent">%</label>
                         </div>';
            echo '
            <div class="apple-card">
                <div class="info">
                    <div class="color">Цвет: ' . $apple->color . '</div>
                    <div class="status">Статус: ' . $apple->getStatusString() . '</div>
                    <div class="percent-eat">Размер: ' . $apple->size . '</div>
                </div>
                <div class="buttons">' . $buttons . '</div>
            </div>
           ';
        }
        ?>
    </div>
    <button class="btn btn-success add-apples">Добавить случайное кол-во яблок</button>
</div>
