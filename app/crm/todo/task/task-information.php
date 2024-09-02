<?php

$title = 'Заявка';
ob_start(); 
?>

<div class="card mb-4">
    <div class="card-header">
        <span class="ml-1 text-dark" style="overflow: hidden; text-overflow: ellipsis; width: 300px">
            <strong><?php echo htmlspecialchars($client['full_name'] ?? ''); ?> </strong>
        </span>
    </div>
    <div class="card-body">
        <p class="row">
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-layer-group"></i> Тип страхования:</strong> <?php echo htmlspecialchars($category['title'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-battery-three-quarters"></i> Статус:</strong> <?php echo htmlspecialchars($task['status'] ?? ''); ?></span>
        </p>
        <p class="row">
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-hourglass-start"></i> Было создано:</strong> <?php echo htmlspecialchars($task['created_at'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-person-circle-question"></i> Было изменено:</strong> <?php echo htmlspecialchars($task['updated_at'] ?? ''); ?></span>
        </p>
        <p class="row">
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-user"></i> ФИО:</strong> <?php echo htmlspecialchars($client['full_name'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-id-card"></i> Идентификационный номер:</strong> <?php echo htmlspecialchars($client['identification_number'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-phone"></i> Телефон:</strong> <?php echo htmlspecialchars($client['phone'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-envelope"></i> Email:</strong> <?php echo htmlspecialchars($client['email'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-car"></i> Номер транспортного средства:</strong> <?php echo htmlspecialchars($client['vehicle_number'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-car-side"></i> Тип транспортного средства:</strong> <?php echo htmlspecialchars($client['vehicle_type'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-calendar-alt"></i> Срок службы транспортного средства:</strong> <?php echo htmlspecialchars($client['vehicle_service_life'] ?? ''); ?> лет</span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-city"></i> ID города:</strong> <?php echo htmlspecialchars($client['city_id'] ?? ''); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-birthday-cake"></i> Возраст:</strong> <?php echo htmlspecialchars($client['age'] ?? ''); ?> лет</span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-road"></i> Стаж вождения:</strong> <?php echo htmlspecialchars($client['driving_exp'] ?? ''); ?> лет</span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-medal"></i> Наличие льгот:</strong> <?php echo htmlspecialchars($client['has_privileges'] ? 'Да' : 'Нет'); ?></span>
            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-star"></i> Класс бонус-малус:</strong> <?php echo htmlspecialchars($client['bonus_mapus_class'] ?? ''); ?></span>
        </p>
        
        <p><strong><i class="fa-solid fa-file-prescription"></i> Тэги:</strong> 
            <?php foreach ($tags as $tag): ?>
                <a href="/crm/todo/tasks/by-tag/<?= $tag['id'] ?>" class="tag"><?= htmlspecialchars($tag['name'] ?? '')  ?></a>
            <?php endforeach; ?>
        </p>
        <hr>
        <p><strong><i class="fa-solid fa-file-prescription"></i> Описание:</strong> <em><?php echo htmlspecialchars($task['description'] ?? ''); ?></em></p>
        <hr>
        <div class="d-flex justify-content-start action-task">
            <?php
                $statuses = [
                    'Новое' => 'Новое',
                    'Выполнено' => 'Выполнено',
                    'Архив' => 'Архив',
                ];
                foreach ($statuses as $status => $label) {
                    $btnClass = $task['status'] == $status ? 'btn-dark' : 'btn-secondary';
                    ?>
                    <form action="/crm/todo/tasks/update-status/<?php echo $task['id']; ?>" method="post" class="me-2">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                        <button type="submit" class="btn <?php echo $btnClass; ?>"><?php echo $label; ?></button>
                    </form>
                <?php } 
            ?>
            <div>
                <a href="/crm/todo/tasks/showEditForm/<?php echo $task['id']; ?>" class="btn btn-primary me-2">
                    <i class="fa-solid fa-edit"></i> 
                </a>
                <a href="/crm/todo/tasks/deleteTask/<?php echo $task['id']; ?>" class="btn btn-danger me-2">
                    <i class="fa-solid fa-trash-alt"></i> 
                </a>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); 

include 'app/crm/layout.php';
?>