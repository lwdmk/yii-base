<?php
namespace lwdmk\yii2BaseClasses\base;

use yii\base\Object;

/**
 * Class AjaxResponse
 *
 * @package lwdmk\\yii2BaseClasses
 */
class AjaxResponse extends Object
{
    /**
     * Success status
     */
    const STATUS_SUCCESS = 200;

    /**
     * Validation errors status
     */
    const STATUS_VALIDATION_ERRORS = 422;

    /**
     * Server error status
     */
    const STATUS_SERVER_ERROR = 500;

    /**
     * Response status
     * @var int
     */
    public $status;

    /**
     * Some error set (ex. validation errors)
     * @var array
     */
    public $errors = [];

    /**
     * Some data set
     *
     * @var array
     */
    public $data = [];

    /**
     * Error message for single error
     *
     * @var string
     */
    public $error = '';

    /**
     * Result message
     * @var string
     */
    public $message = '';
}
