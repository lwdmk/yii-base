<?php
namespace lwdmk\yii2BaseClasses\interfaces;


/**
 * Interface FlashMessagesInterface
 * @package lwdmk\yii2BaseClasses\interfaces
 */
interface FlashMessagesInterface
{
    /**
     * Получение сообщения по коду
     *
     * @param $code
     * @return mixed
     */
    public function getByCode($code);

    /**
     * Установка flash указанного типа по коду
     * @param $type
     * @param $code
     * @return void
     */
    public function setFlashByCode($type, $code);

    /**
     * Установка произвольного flash сообщения
     *
     * @param $type
     * @param $message
     * @return mixed
     */
    public function setFlash($type, $message);

    /**
     * Вывод сообщения по типу операции и коду
     *
     * @param string $type
     * @param bool $success
     * @return void
     */
    public function setByOperation($type = null, $success = false);
}
