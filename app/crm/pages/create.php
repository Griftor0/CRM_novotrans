<?php
$title = 'Create page';
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
    margin-top: 10px;
    }
    .b:hover {
        color:#fff;
        opacity: 0.7;
    }
</style>

<div class="container d-flex flex-column justify-content-center align-items-center">
    <h1 class="text-center mb-4">Добавить страницу</h1>
    <form method="POST" action="/crm/pages/createPage">
        <div style="background: #ededee; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <div class="mb-3">
                <label for="title" class="form-label ">Название</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label ">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" required>
            </div>
            <div class="mb-3">
                <label for="roles" class="form-label ">Роли</label>
                <?php foreach($roles as $role): ?>
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="<?=$role['id'];?>">
                        <label class="form-check-label " for="roles" ><?=$role['role_name'];?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="b">Создать</button>
        </div>
    </form>
</div>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>