<?php
$title = 'Create role';
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
        <h1 class="text-center mb-4">Создать категорию</h1>
        <form method="POST" action="/crm/todo/category/createCategory">
            <div style="background: #ededee; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
                <div class="mb-3">
                    <label for="title" class="form-label">Название</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="description">Описание</label>
                    <input type="description" class="form-control" id="description" name="description" required>
                </div>
                <button type="submit" class="b">Создать</button>
            </div>
        </form>
</div>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>