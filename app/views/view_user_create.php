<?php
$data = $data ?? [];
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-center display-6 mt-4">Создание пользователя</p>
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
        <div class="row mb-2">
            <label for="inputEmailField" class="form-label">Your@email</label>
            <input type="text"
                   name="user-email"
                   id="inputEmailField"
                   class="form-control d-inline"
                   aria-describedby="inputEmailHelpArea"
                   value="">
            <div id="inputEmailHelpArea" class="form-text">
                Введите корректный email который содержит знак '@'.
            </div>
        </div>

        <div class="row mb-2">
            <label for="inputLoginField" class="form-label">Логин</label>
            <input type="text"
                   name="user-login"
                   id="inputLoginField"
                   class="form-control d-inline"
                   aria-describedby="inputLoginHelpArea"
                   value="">
            <div id="inputLoginHelpArea" class="form-text">
                Логин должен быть уникальным и содержать от 4 до 16 символов.
            </div>
        </div>

        <div class="row mb-2">
            <label for="inputPasswordField" class="form-label">Пароль</label>
            <input type="password"
                   name="user-password"
                   id="inputPasswordField"
                   class="form-control d-inline"
                   aria-describedby="inputPasswordHelpArea"
                   value="">
            <div id="inputPasswordHelpArea" class="form-text">
                Пароль должен иметь длинну от 8 до 16 знаков и состоять их нижнего подчеркивания, цифр и латинских букв.
            </div>
        </div>

        <div class="row mb-2">
            <label for="inputPasswordRepeatField" class="form-label">Подтверждение пароля</label>
            <input type="password"
                   name="user-password-repeat"
                   id="inputPasswordRepeatField"
                   class="form-control d-inline"
                   aria-describedby="inputPasswordRepeatHelpArea"
                   value="">
            <div id="inputPasswordRepeatHelpArea" class="form-text">
                Ну... Бывают случаи, когда в пароле букву пропустили. На всякий случай введите его еще раз.
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="list-inline-item d-flex justify-content-center">
                <div class="d-inline">
                    <button type="submit" name="create-user" class="d-inline form-control btn btn-primary btn-sm rounded-1 text-uppercase">
                        Создать
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>