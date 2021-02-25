<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class CurrencyController extends Controller
{

    public function actionIndex()
    {

        try {
            $response = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp');
        } catch(\Exception $e) {
            echo "couldn't load currencies.";
            exit();
        }

        $currencies = simplexml_load_string($response);

        foreach ($currencies as $currency) {
            $rates[] = [$currency->Name, str_replace(',','.', $currency->Value)];
        }

        $sql = Yii::$app->db->queryBuilder->batchInsert('currency', ['name', 'rate'],
            $rates
        );

        Yii::$app->db->createCommand($sql . ' ON DUPLICATE KEY UPDATE rate = VALUES(rate)')->execute();

    }

}