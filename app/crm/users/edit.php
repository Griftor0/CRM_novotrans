<?php
$title = 'Edit user';
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
    <h1 class="my-4">Форма редактирования</h1>
    <form method="POST" action="/crm/users/updateUser/<?php echo $user['id']; ?>">
        <div style="background: #F4F6FB; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <div class="mb-3">
                <label for="username">Имя</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username'];?>" required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email'];?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label ">Роль</label>
                <select class="form-control" id="role" name="role">
                    <?php foreach($roles as $role): ?>
                        <option value = "<?php echo $role['id'];?>" <?php echo $user['role'] == $role['id'] ? 'selected' : '';?>>
                            <?php echo $role['role_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="b">Редактировать</button>
        </div>
        
    </form>
    
</div>



<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>