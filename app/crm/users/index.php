<?php
    $title = 'User list';
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
    <h1 class="my-5 text-center">Пользователи</h1>
    <div class="text-right mb-3 my-5">
        <a href="/crm/users/showCreateForm" class="b">Добавить</a>
    </div>
    <table class="table table-striped table-hover rounded-table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Имя</th>
                <th scope="col">Email</th>
                <th scope="col">Роль</th>
                <th scope="col" class="text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td class="text-center">
                        <a href='/crm/users/showEditForm/<?php echo $user['id']; ?>' class="btn btn-primary">
                            <i class="fa-solid fa-edit text-white"></i>
                        </a>
                        <a href='/crm/users/deleteUser/<?php echo $user['id']; ?>' class="btn btn-danger">
                            <i class="fa-solid fa-trash-alt text-white"></i> 
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
