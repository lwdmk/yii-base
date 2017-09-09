<?php
namespace lwdmk\yii2BaseClasses\components;

use lwdmk\yii2BaseClasses\interfaces\FlashMessagesInterface;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class FlashMessagesManager
 * @package lwdmk\yii2BaseClasses\components
 */
class FlashMessagesManager extends Object implements FlashMessagesInterface
{
    /**
     * Success flash type
     */
    const FLASH_TYPE_SUCCESS = 'success';

    /**
     * Error flash type
     */
    const FLASH_TYPE_ERROR = 'danger';

    /**
     * Info flash type
     */
    const FLASH_TYPE_INFO = 'info';

    /**
     * Success operation message key
     */
    const OPERATION_SUCCESS = 'operation_success';

    /**
     * Failed operation message key
     */
    const OPERATION_FAILED = 'operation_failed';

    /**
     * Success deleting message key
     */
    const DELETE_SUCCESS = 'delete_success';

    /**
     * Failed deleting message key
     */
    const DELETE_FAILED = 'delete_failed';

    /**
     * Success saving message key
     */
    const SAVING_SUCCESS = 'saving_success';

    /**
     * Failed saving message key
     */
    const SAVING_FAILED = 'saving_failed';

    /**
     * Flash messages array
     *
     * @var array
     */
    private $_messages = [
        self::OPERATION_SUCCESS => 'Операцию успешно выполнена',
        self::OPERATION_FAILED  => 'Не удалось заверщить операцию по неизвестной причине',
        self::DELETE_SUCCESS    => 'Запись успешно удалена',
        self::DELETE_FAILED     => 'Запись не была удалена',
        self::SAVING_SUCCESS    => 'Запись успешно сохранена',
        self::SAVING_FAILED     => 'Запись не удалось сохранить',
    ];

    /**
     * @inheritdoc
     */
    public function getByCode($code)
    {
        return ArrayHelper::getValue($this->_messages, $code, '');
    }

    /**
     * @inheritdoc
     */
    public function setFlashByCode($type, $code)
    {
        $this->setFlash($type, $this->getByCode($code));
    }

    /**
     * @inheritdoc
     */
    public function setByOperation($type = null, $success = false)
    {
        $flashType = ($success) ? self::FLASH_TYPE_SUCCESS : self::FLASH_TYPE_ERROR;
        switch ($type) {
            case 'save' :
                $this->setFlashByCode($flashType, ($success) ? self::SAVING_SUCCESS : self::SAVING_FAILED);
                break;
            case 'delete' :
                $this->setFlashByCode($flashType, ($success) ? self::DELETE_SUCCESS : self::DELETE_FAILED);
                break;
            default :
                $this->setFlashByCode($flashType, ($success) ? self::OPERATION_SUCCESS : self::OPERATION_FAILED);
        }
    }

    /**
     * @inheritdoc
     */
    public function setFlash($type, $message)
    {
        \Yii::$app->session->setFlash($type, $message);
    }
}
