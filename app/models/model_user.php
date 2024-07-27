<?php
use App\Core\Model;
use App\Orm\Mysql\UserTable;
use App\Classes\Validator;

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