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

<form method="post" class="container">
    <div class="row mt-5 mb-2">
        <div class="col-6 d-flex justify-content-end">
            <label for="inputIDField" class="col-form-label">ID</label>
        </div>
        <div class="col-auto d-flex justify-content-start">
            <input type="text" readonly id="inputIDField" class="form-control d-inline" value="<?= $user['ID'] ?>">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6 d-flex justify-content-end">
            <label for="inputIDField" class="col-form-label">Логин</label>
        </div>
        <div class="col-auto d-flex justify-content-start">
            <input type="text" id="inputIDField" class="form-control d-inline" value="<?= $user['LOGIN'] ?>">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6 d-flex justify-content-end">
            <label for="inputIDField" class="col-form-label">Почтовый ящик</label>
        </div>
        <div class="col-auto d-flex justify-content-start">
            <input type="text" id="inputIDField" class="form-control d-inline" value="<?= $user['EMAIL'] ?>">
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-6 d-flex justify-content-end">
            <label for="inputIDField" class="col-form-label">Пароль</label>
        </div>
        <div class="col-auto d-flex justify-content-start">
            <input type="text" id="inputIDField" class="form-control d-inline" value="<?= $user['PASSWORD'] ?>">
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="list-inline-item d-flex justify-content-center">
                <div class="d-inline">
                    <button type="submit" class="d-inline form-control btn btn-primary btn-sm rounded-1 text-uppercase">
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>