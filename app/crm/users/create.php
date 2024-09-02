<?php
$title = 'Create user';
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
    <h1 class="my-4">Форма добавления</h1>
    <form method="POST" action="/crm/users/createUser">
        <div style="background: #F4F6FB; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <div class="mb-3">
                <label for="username" class="form-label ">Имя</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label ">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label ">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="b">Добавить</button>
        </div>
    </form>    
</div>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>