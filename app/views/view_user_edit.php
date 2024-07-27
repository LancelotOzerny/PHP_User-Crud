<?php
    $user = $data['USER'] ?? null;

    if ($user === null || empty($user))
    {
        echo '<div class="container display-6 mt-3">Пользователь не найден</div>';
        return;
    }
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-center display-6 mt-4"><?= $user['LOGIN'] ?> [<?= $user['ID'] ?>]</p>
        </div>
    </div>
</div>

<hr class="my-3">

<form method="post" class="container my-5" style="max-width: 640px">
    <?php if(empty($data['SUCCESS']) === false): ?>
        <div class="row mb-2">
            <?php foreach($data['SUCCESS'] as $message) : ?>
                <div class="col-auto mx-auto alert alert-success">
                    <?= $message ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row mb-2">
        <div class="row">
            <label for="inputEmailField" class="form-label">Your@email</label>
            <input type="text"
                   name="user-email"
                   id="inputEmailField"
                   class="form-control d-inline"
                   aria-describedby="inputEmailHelpArea"
                   value="<?= $data['USER']['EMAIL'] ?? '' ?>">

            <div id="inputEmailHelpArea" class="form-text">
                Введите корректный email который содержит знак '@'.
            </div>

            <?php if(isset($data['ERRORS']['EMAIL'])): ?>
                <div class="form-errors">
                    <?php foreach($data['ERRORS']['EMAIL'] as $error): ?>
                        <div class="form-text text-danger"><?= $error ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <hr class="my-3">
        <div class="row">
            <label for="inputLoginField" class="form-label">Логин</label>
            <input type="text"
                   name="user-login"
                   id="inputLoginField"
                   class="form-control d-inline"
                   aria-describedby="inputLoginHelpArea"
                   value="<?= $data['USER']['LOGIN'] ?? '' ?>">
            <div id="inputLoginHelpArea" class="form-text">
                Логин должен быть уникальным и содержать от 4 до 16 латинских букв и цифр.
            </div>

            <?php if(isset($data['ERRORS']['LOGIN'])): ?>
                <div class="form-errors">
                    <?php foreach($data['ERRORS']['LOGIN'] as $error): ?>
                        <div class="form-text text-danger"><?= $error ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <hr class="my-3">

        <div class="row mb-4">
            <div class="form-check">
                <label class="form-check-label" for="checkPasswordChange">Изменить пароль</label>
               <input type="checkbox"
                      name="user-password-changed"
                      class="form-check-input"
                      id="checkPasswordChange">
            </div>
        </div>

        <div class="row">
            <label for="inputPasswordField" class="form-label">Новый пароль</label>
            <input type="password"
                   name="user-password"
                   id="inputPasswordField"
                   class="pass-field form-control d-inline"
                   disabled
                   aria-describedby="inputPasswordHelpArea"
                   value="">
            <div id="inputPasswordHelpArea" class="form-text">
                Пароль должен содержать от 8 до 20 знаков и включать нижнее подчеркивание,
                латинские символы в верхнем и нижнем регистре, цифры.
            </div>

            <?php if(isset($data['ERRORS']['PASSWORD'])): ?>
                <div class="form-errors">
                    <?php foreach($data['ERRORS']['PASSWORD'] as $error): ?>
                        <div class="form-text text-danger"><?= $error ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <hr class="my-3">
        <div class="row mb-3">
            <label for="inputPasswordRepeatField" class="form-label">Подтверждение пароля</label>
            <input type="password"
                   name="user-password-repeat"
                   id="inputPasswordRepeatField"
                   class="pass-field form-control d-inline"
                   disabled
                   aria-describedby="inputPasswordRepeatHelpArea"
                   value="">
            <div id="inputPasswordRepeatHelpArea" class="form-text">
                Ну... Бывают случаи, когда в пароле букву пропустили. На всякий случай введите его еще раз.
            </div>

            <?php if(isset($data['ERRORS']['PASSWORD_REPEAT'])): ?>
                <div class="form-errors">
                    <?php foreach($data['ERRORS']['PASSWORD_REPEAT'] as $error): ?>
                        <div class="form-text text-danger"><?= $error ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="list-inline-item d-flex justify-content-center mx-2s">
                <div class="d-inline">
                    <a href="/user/">
                        <button type="button" class="d-inline btn btn-secondary btn-sm rounded-1 text-uppercase">
                            Список
                        </button>
                    </a>
                </div>

                <div class="d-inline mx-2">
                    <button type="submit" name="create-user" class="d-inline form-control btn btn-primary btn-sm rounded-1 text-uppercase">
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function()
    {
        changeFieldsEnable()

        $("#checkPasswordChange").change(function() {
            changeFieldsEnable();
        });

        function changeFieldsEnable()
        {
            let active = $("#checkPasswordChange").is(':checked');
            if (active)
            {
                $(".pass-field").removeAttr('disabled');
            }
            else
            {
                $(".pass-field").attr('disabled', 'disabled');
            }
        }
    });
</script>