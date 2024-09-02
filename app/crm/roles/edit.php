<?php
$title = 'Edit role';
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
    <h1 class="my-4">Редактировать роль</h1>
    <form method="POST" action="/crm/roles/updateRole">
        <div style="background: #ededee; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <input type="hidden" name="id" value="<?= $role['id'] ?>">
            <div class="mb-3">
                <label for="rolename" class="form-label ">Название</label>
                <input type="text" class="form-control" id="rolename" name="role_name" value="<?= $role['role_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="roledescription" class="form-label ">Описание</label>
                <input type="roledescription" class="form-control" id="roledescription" name="role_description" value="<?= $role['role_description'] ?>" required>
            </div>
            <button type="submit" class="b">Редактировать</button>
        </div>
    </form>
</div>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>