<?php
declare(strict_types=1);

namespace backend\forms;

use yii\base\Model;

/**
 * Class LoginForm
 * @package backend\forms
 */
class LoginForm extends Model
{
    /**
     * @var string $username
     */
    public string $username = '';

    /**
     * @var string $password
     */
    public string $password = '';

    /**
     * @var bool $rememberMe
     */
    public bool $rememberMe = true;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            [['rememberMe'], 'boolean'],
        ];
    }
}
