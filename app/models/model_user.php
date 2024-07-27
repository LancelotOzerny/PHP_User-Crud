<?php
use App\Core\Model;
use App\Orm\Mysql\UserTable;

class Model_User extends Model
{
    public function getListData() : array
    {
        $data = [];
        if (isset($_SESSION['USER_DELETED']))
        {
            if ($_SESSION['USER_DELETED'] === 'Y')
            {
                $data['SUCCESS'][] = 'Удаление пользователя прошло успешно!';
            }

            if ($_SESSION['USER_DELETED'] === 'N')
            {
                $data['ERRORS'][] = 'Удаление пользователя не удалось';
            }
            unset($_SESSION['USER_DELETED']);
        }
        $data['USER_LIST'] = UserTable::getList();
        return $data;
    }

    public function getCreateUserData() : array
    {
        $data = [];

        if (isset($_SESSION['user-created']) && $_SESSION['user-created'] === 'Y')
        {
            $data['SUCCESS'][] = 'Создан новый пользователь!';
            unset($_SESSION['user-created']);
        }

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

                $_SESSION['user-created'] = 'Y';
                header('Location:/user/create/');
            }

            $data['USER'] = [
                'LOGIN' => $userData['LOGIN'],
                'EMAIL' => $userData['EMAIL'],
            ];
        }

        return $data;
    }

    public function deleteUser()
    {
        if (isset($_POST['delete-id']))
        {
            $id = intval($_POST['delete-id']);
            $deleted = UserTable::deleteById($id);
            $_SESSION['USER_DELETED'] = $deleted ? 'Y' : 'N';
        }
        header('Location:/user/list/');
    }

    public function getUserCreateDataErrors(array $data) : array
    {
        $errors = [];

        // EMAIL
        if (empty($data['EMAIL']))
        {
            $errors['EMAIL'][] = 'Поле не может быть пустым!';
        }
        else if (!filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL))
        {
            $errors['EMAIL'][] = 'Email введен некорректно!';
        }
        else if (count(UserTable::getByEmail($data['EMAIL'])) > 0)
        {
            $errors['EMAIL'][] = 'Пользователь с таким email уже существует!';
        }

        // LOGIN
        if (empty($data['LOGIN']))
        {
            $errors['LOGIN'][] = 'Поле не может быть пустым!';
        }
        else if (strlen($data['LOGIN']) < 4 || strlen($data['LOGIN']) > 16)
        {
            $errors['LOGIN'][] = 'Логин должен содержать от 4 и до 16 символов!';
        }
        else if (!preg_match('/^[A-Za-z0-9]/', $data['LOGIN']))
        {
            $errors['LOGIN'][] = 'Логин может содержать только латинские буквы и цифры!';
        }
        else if (empty(UserTable::getByLogin($data['LOGIN'])) === false)
        {
            $errors['LOGIN'][] = 'Пользователь с таким логином уже существует!';
        }

        // PASSWORD
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

        // PASSWORD REPEAT
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