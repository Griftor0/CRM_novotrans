<?php
    $title = 'Todo List';
    ob_start();
?>
<style>
.accordion {
    background-color: #ededee;
    height: 800px;
    width: 650px;
    border-radius: 10px;
    padding: 20px;
}
</style>
<div class="container p-0">
    <h1 class="d-flex justify-content-center mb-5">Архив</h1>
    <div class="d-flex justify-content-center">
        <div class="accordion" id="tasks-accordion">
        <?php foreach ($tasks as $task): ?>
            <div class="accordion-item" style="width: 600px;">
                <div class="accordion-header d-flex justify-content-between align-items-center" id="task-<?php echo $task['id']; ?>">
                    <h2 style="width: 600px;">
                        <button  class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#task-collapse-<?php echo $task['id']; ?>" aria-expanded="false" aria-controls="task-collapse-<?php echo $task['id']; ?>">
                            <div class="d-flex justify-content-between w-100">
                                <span class="ml-1 text-dark" style="overflow: hidden; text-overflow: ellipsis; width: 350px">
                                    <strong><?php echo $task['client']['full_name']; ?> </strong>
                                </span>
                                <span class="ml-1 text-dark">
                                    <strong><?php echo htmlspecialchars($task['category']['title'] ?? ''); ?> </strong>
                                </span>
                            </div>
                        </button>
                    </h2>
                </div>
                <div id="task-collapse-<?php echo $task['id']; ?>" class="accordion-collapse collapse" aria-labelledby="task-<?php echo $task['id']; ?>" data-bs-parent="#tasks-accordion">
                    <div class="accordion-body" style="width: 600px; white-space: normal;">
                        <p class="row m-0">
                            <div class="mb-2">
                                <strong>Данные</strong>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-file-alt"></i> Тип страхования:</strong> 
                                <?php echo htmlspecialchars($task['category']['title'] ?? ''); ?>
                            </div>
                            <div cless="mr-5">
                                <strong><i class="fa-solid fa-user"></i> ФИО:</strong> 
                                <?php echo htmlspecialchars($task['client']['full_name'] ?? ''); ?>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-phone"></i> Телефон:</strong> 
                                <?php echo htmlspecialchars($task['client']['phone'] ?? ''); ?>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-car"></i> Гос. номер автомобиля:</strong> 
                                <?php echo htmlspecialchars($task['client']['vehicle_number'] ?? ''); ?>
                            </div>
                        </p>
                        <p class="row m-0">
                            <div class="mb-2">
                                <strong>Доп. информация</strong>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-envelope"></i> EMAIL:</strong> 
                                <?php echo htmlspecialchars($task['client']['email'] ?? ''); ?>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-solid fa-car-side"></i> Тип транспортного средства:</strong> 
                                <?php echo htmlspecialchars($task['client']['vehicle_type'] ?? ''); ?>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-calendar-alt"></i> Срок службы транспортного средства:</strong> 
                                <?php echo htmlspecialchars($task['client']['vehicle_service_life'] ?? ''); ?> лет
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-city"></i> ID города:</strong> 
                                <?php echo htmlspecialchars($task['client']['city_id'] ?? ''); ?>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-user"></i> Возраст:</strong> 
                                <?php echo htmlspecialchars($task['client']['age'] ?? ''); ?> лет
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-road"></i> Стаж вождения:</strong> 
                                <?php echo htmlspecialchars($task['client']['driving_exp'] ?? ''); ?> лет
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-medal"></i> Наличие льгот:</strong> 
                                <?php echo htmlspecialchars($task['client']['has_privileges'] ?? ''); ?>
                            </div>
                            <div>
                                <strong><i class="fa-solid fa-star"></i> Класс бонус-малус:</strong> 
                                <?php echo htmlspecialchars($task['client']['bonus_mapus_class'] ?? ''); ?>
                            </div>
                        </p>
                        <p><strong><i class="fa-solid fa-file-prescription"></i> Теги:</strong> 
                            <?php foreach ($task['tags'] as $tag): ?>
                                <a href="/crm/todo/tasks/by-tag/<?= $tag['id'] ?>" class="tag"><?= htmlspecialchars($tag['name']) ?></a>
                            <?php endforeach; ?>
                        </p>
                        <p class="row">
                            <div>
                                <strong><i class="fa-solid fa-prescription"></i> Описание:</strong> 
                                <?php echo htmlspecialchars($task['description']); ?>
                            </div>
                        </p>
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
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php 
    $content = ob_get_clean();
    include 'app/crm/layout.php';
?>
