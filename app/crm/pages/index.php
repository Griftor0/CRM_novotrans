<?php
    $title = 'Page list';
    ob_start();
?>
<style>
    .b {
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
    <h1 class="my-5 text-center">Страницы</h1>
    <div class="text-right mb-3">
        <a href="/crm/pages/showCreateForm" class="b" style="background-color: #007BFB;">Добавить</a>
    </div>
    <table class="table table-striped table-hover rounded-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Slug</th>
                <th>Роли</th>
                <th class="text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pages as $page): ?>
                <tr>
                    <td><?= $page['title'] ?></td>
                    <td><?= $page['slug'] ?></td>
                    <td><?= $page['roles'] ?></td>
                    <td class="text-center">
                        <a href='/crm/pages/showEditForm/<?php echo $page['id']; ?>' class="btn btn-primary">
                            <i class="fa-solid fa-edit text-white"></i>
                        </a>
                        <a href='/crm/pages/deletePage/<?php echo $page['id']; ?>' class="btn btn-danger">
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
