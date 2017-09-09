<?php
namespace lwdmk\yii2BaseClasses\services;

use lwdmk\yii2BaseClasses\components\FlashMessagesManager;
use lwdmk\yii2BaseClasses\interfaces\FlashMessagesInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\log\Logger;
use yii\web\Application;
use yii\web\NotFoundHttpException;

/**
 * Class BaseService
 * @package lwdmk\yii2BaseClasses\services
 */
abstract class BaseService extends Component
{
    /**
     * @var Application
     */
    protected $app = null;

    /**
     * @var Connection
     */
    protected $db = null;

    /**
     * @var Logger
     */
    protected $logger = null;

    /**
     * @var string
     */
    protected $flashMessagesManagerClass = null;

    /**
     * @var FlashMessagesInterface
     */
    protected $flashMessagesManager = null;

    /**
     * @var string
     */
    protected $modelClass = null;

    /**
     * @var string
     */
    protected $modelQuery = null;

    /**
     * @var \yii\web\User
     */
    protected $currentUser = null;

    /**
     * @var User
     */
    protected $currentUserIdentity = null;

    /**
     * @var array
     */
    protected $errorsSet = [];

    /**
     * @var int
     */
    protected $lastId = null;

    /**
     * @var ActiveRecord
     */
    protected $lastModel = null;

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        $this->currentUser = \Yii::$app->user;
        $this->currentUserIdentity = \Yii::$app->user->identity;
        $this->db = \Yii::$app->db;
        $this->app = \Yii::$app;
        $this->logger = \Yii::getLogger();

        parent::__construct($config);

        if (null !== $this->modelQuery) {
            $modelQuery = $this->modelQuery;
            $this->modelQuery = new $modelQuery((new $this->modelClass));
        }
        $this->flashMessagesManager = (null !== $this->flashMessagesManagerClass)
            ? new $this->flashMessagesManagerClass
            : new FlashMessagesManager();
    }

    /**
     * @return array
     */
    public function getLastErrors()
    {
        return $this->_lastActionErrors;
    }

    /**
     * @return mixed|string
     */
    public function getLastError()
    {
        return !empty($this->_lastActionErrors) ? array_pop($this->_lastActionErrors) : '';
    }

    /**
     * @return int
     */
    public function getLastInsertId()
    {
        return $this->_lastInsertId;
    }

    /**
     * @return ActiveRecord
     */
    public function getLastInsertModel()
    {
        return $this->_lastInsertModel;
    }

    /**
     * @return null|\yii\web\IdentityInterface
     */
    public function getCurrentUser()
    {
        return $this->currentUser->identity;
    }

    /**
     * @param $value
     */
    public function setModelClass($value)
    {
        $this->modelClass = $value;
    }

    /**
     * @param $value
     */
    public function setModelQuery($value)
    {
        $this->modelQuery = $value;
    }

    /**
     * Поиск модели по ее id.
     *
     * @param $id
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function getModel($id)
    {
        if ($model = $this->createModel()->findOne((int) $id)) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Создание новой модели.
     *
     * @param array $config
     * @param string $modelClass
     *
     * @return object
     * @throws InvalidConfigException;
     */
    public function createModel($config = [], $modelClass = null)
    {
        $modelClass = $modelClass ?? $this->modelClass;
        if(! class_exists($modelClass)) {
            throw new InvalidConfigException();
        }
        return \Yii::createObject($modelClass, $config);
    }
}
