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
                'PASSWORD' => htmlspecialchars($_POST['user-password']),
                'PASSWORD_REPEAT' => htmlspecialchars($_POST['user-password-repeat']),
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
        $data = [];
        $user_id = intval($_GET['id']);
        $data['USER'] = UserTable::getById($user_id);

        if (isset($_SESSION['user-edited']) && $_SESSION['user-edited'] === 'Y')
        {
            $data['SUCCESS'][] = 'Изменения сохранены!';
            unset($_SESSION['user-edited']);
        }

        if (isset($_POST['update-user']))
        {
            $updateData = [];

            $updateEmail = trim(htmlspecialchars($_POST['user-email']));
            $isEmailToUpdate = ($updateEmail !== $data['USER']['EMAIL']);
            if ($isEmailToUpdate)
            {
                $updateData['EMAIL'] = $updateEmail;
            }

            $updateLogin = trim(htmlspecialchars($_POST['user-login']));
            $isLoginToUpdate = ($updateLogin !== $data['USER']['LOGIN']);
            if ($isLoginToUpdate)
            {
                $updateData['LOGIN'] = $updateLogin;
            }

            if (isset($_POST['user-password-changed']))
            {
                $updateData['PASSWORD'] = htmlspecialchars($_POST['user-password']);
                $updateData['PASSWORD_REPEAT'] = htmlspecialchars($_POST['user-password-repeat']);
                $updateData['PASSWORD_CHANGED'] = 'Y';
            }

            $data['UPDATE_DATA'] = $updateData;

            $validator = new Validator($updateData);
            if ($isEmailToUpdate)
            {
                $data['ERRORS']['EMAIL'] = $validator->getEmailErrors();
            }
            if ($isLoginToUpdate)
            {
                $data['ERRORS']['LOGIN'] = $validator->getLoginErrors();
            }

            if (isset($_POST['user-password-changed']))
            {
                $data['ERRORS']['PASSWORD'] = $validator->getPasswordErrors();
                $data['ERRORS']['PASSWORD_REPEAT'] = $validator->getPasswordRepeatErrors();
            }

            foreach ($data['ERRORS'] as $errorGroup)
            {
                if (empty($errorGroup) === false)
                {
                    return $data;
                }
            }

            $userUpdateData = [];
            if ($isLoginToUpdate)
            {
                $userUpdateData['LOGIN'] = $updateData['LOGIN'];
            }
            if ($isEmailToUpdate)
            {
                $userUpdateData['EMAIL'] = $updateData['EMAIL'];
            }
            if (isset($_POST['user-password-changed']))
            {
                $userUpdateData['PASSWORD'] = password_hash($updateData['PASSWORD'], PASSWORD_DEFAULT);
            }

            if (empty($userUpdateData) === false)
            {
                $isUpdated = UserTable::update($user_id, $userUpdateData);

                if ($isUpdated)
                {
                    $_SESSION['user-edited'] = 'Y';
                    header("Location:/user/edit/?id=$user_id");
                }
            }
        }

        return $data;
    }
}