<?php

namespace lwdmk\yii2BaseClasses\services;

use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Class CrudService
 * @package lwdmk\yii2BaseClasses\services
 */
abstract class CrudService extends BaseService
{
    /**
     * @param ActiveRecord $model
     *
     * @return bool
     */
    public function saveModel($model)
    {
        try {
            $result = $model->save();
            $this->flashMessagesManager->setByOperation('save', $result);
            if ($result) {
                $this->_lastInsertId = $model->id;
                $this->_lastInsertModel = $model;
            } else {

                $this->_lastActionErrors = $model->getErrors();
            }
        } catch (Exception $e) {
            $this->_lastActionErrors = [$e->getMessage()];
            $this->flashMessagesManager->setFlashByCode(($this->flashMessagesManager)::FLASH_TYPE_ERROR, $e->getMessage());
            $result = false;
        }
        return $result;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function deleteModel($id)
    {
        try {
            $result = $this->getModel($id)->delete();
            $this->flashMessagesManager->setByOperation('delete', $result);
        } catch (Exception $e) {
            $this->_lastActionErrors = [$e->getMessage()];
            $this->flashMessagesManager->setFlashByCode(($this->flashMessagesManager)::FLASH_TYPE_ERROR, $e->getMessage());
            $result = false;
        }

        return $result;
    }
}
