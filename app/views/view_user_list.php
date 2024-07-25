<?php
    $userList = $data['USER_LIST'] ?? [];
?>
<div class="container">
    <div class="row col-12">
        <p class="display-4 text-center py-5">CRUD (AJAX) пользователей</p>
    </div>
</div>

<div class="container">
    <div class="table-list-container">
        <table class="table table-hover table-borderless">
            <thead>
            <tr class="border-bottom">
                <th scope="col">#</th>
                <th scope="col">Логин</th>
                <th scope="col">Почта</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($userList as $user): ?>
                <tr>
                    <th><?= $user['ID'] ?></th>
                    <td><?= $user['LOGIN'] ?></td>
                    <td><?= $user['EMAIL'] ?></td>
                    <td>
                        <div class="list-inline-item d-flex justify-content-end">
                            <a href="/user/edit/?id=<?= $user['ID'] ?>"
                               class="btn btn-secondary btn-sm rounded-1 text-uppercase"
                               title="Edit">
                                Редактировать
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="list-inline-item d-flex justify-content-end">
                <a href="/user/create ?>"
                   class="btn btn-success btn-sm rounded-1 text-uppercase"
                   title="Create">
                    Создать
                </a>
            </div>
        </div>
    </div>
</div>