<?php
use App\Core\Model;
use App\Orm\Mysql\UserTable;

class Model_User extends Model
{
    public function getListData() : array
    {
        $data = [];
        $data['USER_LIST'] = UserTable::getList();
        return $data;
    }

    public function getCreateUserData() : array
    {
        $data = [];

        if (isset($_POST['create-user']))
        {
            $userData = [
                'EMAIL' => htmlspecialchars(trim($_POST['user-email'])),
                'LOGIN' => htmlspecialchars(trim($_POST['user-login'])),
                'PASSWORD' => htmlspecialchars(trim($_POST['user-password'])),
                'PASSWORD_REPEAT' => htmlspecialchars(trim($_POST['user-password-repeat'])),
            ];

            $data['ERRORS'] = $this->getUserCreateDataErrors($userData);

            if (empty($data['ERRORS']))
            {
                UserTable::create([
                    'LOGIN' => $userData['LOGIN'],
                    'EMAIL' => $userData['EMAIL'],
                    'PASSWORD' => password_hash($userData['PASSWORD'], PASSWORD_DEFAULT),
                ]);
            }

            $data['USER'] = [
                'LOGIN' => $userData['LOGIN'],
                'EMAIL' => $userData['EMAIL'],
            ];
        }

        return $data;
    }

    public function getUserCreateDataErrors(array $data) : array
    {
        $errors = [];

        if (empty($data['EMAIL']))
        {
            $errors['EMAIL'][] = 'Поле не может быть пустым!';
        }
        else if (!filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL))
        {
            $errors['EMAIL'][] = 'Email введен некорректно!';
        }

        if (empty($data['LOGIN']))
        {
            $errors['LOGIN'][] = 'Поле не может быть пустым!';
        }
        else
        {
            $len = strlen($data['LOGIN']);
            if ($len < 4 || $len > 16)
            {
                $errors['LOGIN'][] = 'Логин должен содержать от 4 и до 16 символов!';
            }

            if (!preg_match('/^[A-Za-z0-9]/', $data['LOGIN']))
            {
                $errors['LOGIN'][] = 'Логин может содержать только латинские буквы и цифры!';
            }
        }

        if (empty($data['PASSWORD']))
        {
            $errors['PASSWORD'][] = 'Поле не может быть пустым!';
        }
        else
        {
            $len = strlen($data['PASSWORD']);
            if ($len < 8 || $len > 20)
            {
                $errors['PASSWORD'][] = 'Пароль должен содержать от 8 и до 20 символов!';
            }

            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[_]).*$/', $data['PASSWORD']))
            {
                $errors['PASSWORD'][] = 'Пароль должен включать знак нижнего подчеркивания, латинские символы в 
                верхнем и нижнем регистре а также цифры!';
            }
        }

        if ($data['PASSWORD'] !== $data['PASSWORD_REPEAT'])
        {
            $errors['PASSWORD_REPEAT'][] = 'Пароль и повторный пароль должны быть одинаковыми!';
        }

        return $errors;
    }

    public function getEditData() : array
    {
        $user_id = intval($_GET['id']);
        $user = UserTable::getById($user_id);

        return [
            'USER' => $user,
        ];
    }
}