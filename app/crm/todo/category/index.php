<?php
    $title = 'Todo Categories';
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
    <h1 class="my-4 text-center">Категории</h1>
    <div class="text-right mb-3 my-5">
        <a href="/crm/todo/category/showCreateForm" class="b">Добавить</a>
    </div>
    <table class="table table-striped table-hover rounded-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Видимость</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $category): ?>
                <tr>
                    <td><?= $category['title'] ?></td>
                    <td style="max-width: 400px; overflow: hidden; text-overflow: ellipsis;"><?= $category['description'] ?></td>
                    <td><?= $category['is_visible'] == 1 ? 'Да' : 'Нет' ?></td>
                    <td class="text-center">
                        <a href='/crm/todo/category/showEditForm/<?php echo $category['id']; ?>' class="btn btn-primary">
                            <i class="fa-solid fa-edit text-white"></i>
                        </a>
                        <a href='/crm/todo/category/deleteCategory/<?php echo $category['id']; ?>' class="btn btn-danger">
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
