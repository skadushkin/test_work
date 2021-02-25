<?php
namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

/**
 * Currency controller
 */
class CurrencyController extends ActiveController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }

    public $modelClass = 'common\models\Currency';

}