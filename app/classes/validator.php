<?php
namespace App\Classes;

use App\Orm\Mysql\UserTable;

class Validator
{
    private array $data = [];
    public function __construct(array $validate_data)
    {
        $this->data = $validate_data;
    }
    public function getEmailErrors() : array
    {
        $errors = [];

        if (empty($this->data['EMAIL']))
        {
            $errors[] = 'Поле не может быть пустым!';
        }
        else if (!filter_var($this->data['EMAIL'], FILTER_VALIDATE_EMAIL))
        {
            $errors[] = 'Email введен некорректно!';
        }
        else if (count(UserTable::getByEmail($this->data['EMAIL'])) > 0)
        {
            $errors[] = 'Пользователь с таким email уже существует!';
        }

        return $errors;
    }
    public function getLoginErrors() : array
    {
        $errors = [];

        if (empty($this->data['LOGIN']))
        {
            $errors[] = 'Поле не может быть пустым!';
        }
        else if (strlen($this->data['LOGIN']) < 4 || strlen($this->data['LOGIN']) > 16)
        {
            $errors[] = 'Логин должен содержать от 4 и до 16 символов!';
        }
        else if (!preg_match('/^[A-Za-z0-9]/', $this->data['LOGIN']))
        {
            $errors[] = 'Логин может содержать только латинские буквы и цифры!';
        }
        else if (empty(UserTable::getByLogin($this->data['LOGIN'])) === false)
        {
            $errors[] = 'Пользователь с таким логином уже существует!';
        }

        return $errors;
    }
    public function getPasswordErrors() : array
    {
        $errors = [];

        if (empty($this->data['PASSWORD']))
        {
            $errors[] = 'Поле не может быть пустым!';
        }
        else
        {
            $len = strlen($this->data['PASSWORD']);
            if ($len < 8 || $len > 20)
            {
                $errors[] = 'Пароль должен содержать от 8 и до 20 символов!';
            }

            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[_]).*$/', $this->data['PASSWORD']))
            {
                $errors[] = 'Пароль должен включать знак нижнего подчеркивания, латинские символы в 
                верхнем и нижнем регистре а также цифры!';
            }
        }

        return $errors;
    }
    public function getPasswordRepeatErrors() : array
    {
        $errors = [];

        if ($this->data['PASSWORD'] !== $this->data['PASSWORD_REPEAT'])
        {
            $errors[] = 'Пароль и повторный пароль должны быть одинаковыми!';
        }

        return $errors;
    }
}