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

            $validator = new Validator($userData);
            $data['ERRORS']['EMAIL'] = $validator->getEmailErrors();
            $data['ERRORS']['LOGIN'] = $validator->getLoginErrors();
            $data['ERRORS']['PASSWORD'] = $validator->getPasswordErrors();
            $data['ERRORS']['PASSWORD_REPEAT'] = $validator->getPasswordRepeatErrors();

            foreach ($data['ERRORS'] as $errorGroup)
            {
                if (empty($errorGroup) === false)
                {
                    return $data;
                }
            }

            UserTable::create([
                'LOGIN' => $userData['LOGIN'],
                'EMAIL' => $userData['EMAIL'],
                'PASSWORD' => password_hash($userData['PASSWORD'], PASSWORD_DEFAULT),
            ]);

            $_SESSION['user-created'] = 'Y';
            header('Location:/user/create/');

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
    public function getEditData() : array
    {
        $user_id = intval($_GET['id']);

        if (isset($_POST['update-user']))
        {
            $updateData = [
                'EMAIL' => $_POST['user-email'],
                'LOGIN' => $_POST['user-login'],
            ];

            UserTable::update($user_id, $updateData);
        }

        $user = UserTable::getById($user_id);

        return [
            'USER' => $user,
        ];
    }
}

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