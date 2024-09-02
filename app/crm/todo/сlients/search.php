<?php
    $title = 'Клиенты';
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
    <h1 class="my-5 text-center">Клиенты</h1>
    <div class="text-right mb-3 my-5">
        <a href="/crm/todo/clients/showCreateForm" class="b">Добавить</a>
    </div>
    <div class="row justify-content-center col-md-5">
        <form action="/crm/todo/clients/searchClient" method="post">
            <div class="input-group">
                <input type="text" class="form-control" id="query" name="query" placeholder="Введите запрос">
                <button type="submit" class="b">Найти</button>
            </div>
        </form>
    </div>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">ИИН</th>
                <th scope="col">Номер телефона</th>
                <th scope="col">Гос. номер</th>
                <th scope="col">Email</th>
                <!-- <th scope="col">Регион регистрации</th> -->
                <th scope="col">Город</th>
                <th scope="col">Тип ТС</th>
                <th scope="col">Срок эксплуатации</th>
                <th scope="col">Возраст</th>
                <th scope="col">Стаж вождения</th>
                <th scope="col">Льготы</th>
                <th scope="col">Класс</th>
                <th scope="col" class="text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clients as $client): ?>
                <tr>
                <th scope="row"><?php echo $client['id']; ?></th>
                <td><?php echo $client['full_name']; ?></td>
                <td><?php echo $client['identification_number']; ?></td>
                <td><?php echo $client['phone']; ?></td>
                <td><?php echo $client['vehicle_number']; ?></td>
                <td><?php echo $client['email']; ?></td>
                <td><?php echo $client['city_id']; ?></td>
                <td><?php echo $client['vehicle_type']; ?></td>
                <td><?php echo $client['vehicle_service_life']; ?></td>
                <td><?php echo $client['age']; ?></td>
                <td><?php echo $client['driving_exp']; ?></td>
                <td><?php echo $client['has_privileges']; ?></td>
                <td class="text-center">
                    <a href='/crm/todo/clients/showEditForm/<?php echo $client['id']; ?>' class="btn btn-primary">
                        <i class="fa-solid fa-edit text-white"></i>
                    </a>
                    <a href='/crm/todo/clients/deleteClient/<?php echo $client['id']; ?>' class="btn btn-danger">
                        <i class="fa-solid fa-trash-alt text-white"></i>
                    </a>
                </td>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php 
    $content = ob_get_clean();
    include 'app/crm/layout.php';
?>
