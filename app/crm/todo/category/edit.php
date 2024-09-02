<?php
$title = 'Edit Category';
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
    <h1 class="text-center mb-4">Редактировать</h1>
    <form method="POST" action="/crm/todo/category/updateCategory">
        <div style="background: #ededee; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <input type="hidden" name="id" value="<?= $selectedCategory['id'] ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $selectedCategory['title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <input type="description" class="form-control" id="description" name="description" value="<?= $selectedCategory['description'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="is_visible" class="form-label">Видимость</label>
                <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" value="1" <?php echo $selectedCategory['is_visible'] ? ' checked' : '';?>>
            </div>
            <button type="submit" class="b">Редактировать</button>
        </div>
    </form>
</div>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>