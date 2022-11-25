<?php
declare(strict_types=1);

namespace backend\services;

use backend\forms\LoginForm;
use common\interfaces\ExecutableInterface;
use common\models\User;
use Yii;

/**
 * Class LoginService
 * @package backend\services
 */
class LoginService implements ExecutableInterface
{
    /**
     * @var LoginForm $form
     */
    private LoginForm $form;

    /**
     * @var User|null $user
     */
    private ?User $user = null;

    /**
     * @param LoginForm $form
     */
    public function __construct(LoginForm $form)
    {
        $this->form = $form;
    }

    public function execute():bool
    {
        if (!$this->form->validate()) {
            return false;
        }

        if (!$this->validatePassword()) {
            return false;
        }

        return Yii::$app->user->login(
            $this->getUser(),
            $this->form->rememberMe ? 3600 * 24 * 30 : 0
        );
    }

    /**
     * @return bool
     */
    private function validatePassword(): bool
    {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->form->password)) {
            $this->form->addError('password', 'Incorrect username or password.');
            return false;
        }
        return true;
    }

    /**
     * @return User|null
     */
    private function getUser(): ?User
    {
        if (null === $this->user) {
            $this->user = User::findOne(['username' => $this->form->username]);
        }

        return $this->user;
    }
}