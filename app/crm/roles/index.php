<?php
    $title = 'Role list';
    ob_start();
?>
<style>
    .b {
        background-color: #007BFB;
        text-decoration: none;
        color: #fff;
        border:none;
        border-radius: 8px;
        padding: 8px 25px;
        transition: opacity 0.3s;
    }
    .b:hover {
        color:#fff;
        opacity: 0.7;
    }
    .rounded-table {
        border-radius: 20px;
        overflow: hidden;
    }
</style>

<div class="container">
    <h1 class="my-5 text-center">Роли</h1>
    <div class="text-right mb-3 my-5">
        <a href="/crm/roles/showCreateForm" class="b">Создать</a>
    </div>
    <table class="table table-striped table-hover rounded-table">
        <thead class="thead-dark">
            <tr>
                <th>Роли</th>
                <th>Описание</th>
                <th class="text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($roles as $role): ?>
                <tr>
                    <td><?= $role['role_name'] ?></td>
                    <td><?= $role['role_description'] ?></td>
                    <td class="text-center">
                        <a href='/crm/roles/showEditForm/<?php echo $role['id']; ?>' class="btn btn-primary">
                            <i class="fa-solid fa-edit text-white"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
    $content = ob_get_clean();
    include 'app/crm/layout.php';
?>
