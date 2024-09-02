<?php
$title = 'Create task';
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
    <h1 class="mb-4">Добавить заявку</h1>
    <form method="POST" action="/crm/todo/tasks/createTask">
        <div style="background: #ededee; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <div class="mb-3">
                <label for="status">Клиент</label>
                <select class="form-control" id="client_id" name="client_id">
                    <option value="">Выберите клиента</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>" ><?= $client['full_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="category_id">Тип страхования</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
            </div>
            <button type="submit" class="b">Добавить</button>
        </div>
    </form>
</div>
</script>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>