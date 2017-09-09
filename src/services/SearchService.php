<?php

namespace lwdmk\yii2BaseClasses\services;

use yii\helpers\ArrayHelper;

/**
 * Class SearchService
 * @package lwdmk\yii2BaseClasses\services
 */
abstract class SearchService extends BaseService
{
    /**
     * Получение поисковой модели отсервиса
     *
     * @param array $postData Данные POST запроса
     * @return mixed
     */
    public function getSearchModel($postData = [])
    {
        $model = $this->createModel();
        if (!empty($postData)) {
            $model->load($postData);
        }

        return $model;
    }

    /**
     * Получение списка значений модели
     *
     * @param string|\Closure $from Параметр $from для ArrayHelper::map
     * @param string|\Closure $to Параметр $to для ArrayHelper::map
     * @param string|array $where Условия если необходима не стандартная выборка
     *
     * @return array
     */
    public function getList($from, $to, $where = '')
    {
        return ArrayHelper::map($this->createModel()->find()->where($where)->all(), $from, $to);
    }
}
