<?php
    if($_SERVER['REQUEST_URI'] == '/crm/index.php'){
        header('Location: /crm');
    }

    $title = 'Home page';
    ob_start();
?>

<h1>Home page</h1>
<div id='calendar'></div>

<?php $path = '/crm/todo/tasks/viewtask/'; ?>

<script>
// Получение данных о задачах, из нашего PHP-контроллера
const tasksJson = <?= json_encode($tasksJson) ?>;
const tasks = JSON.parse(tasksJson); // tasks это массив объектов
// Преобразование данных (массива) в задачи для календаря
const events = tasks.map((task) => {
    return {
      title: task.client.full_name,
      start: new Date(task.created_at).toISOString().slice(0, 10), // Используйте created_at вместо start_date
      extendedProps: {
        task_id: task.id, // добавьте ID задачи в расширенные свойства
        },
    };
  });

// Обработчик событий загрузки DOM
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    // Инициализация календаря с настройками
    const calendar = new FullCalendar.Calendar(calendarEl, {
        // initialView: 'dayGridMonth',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
        themeSystem: 'bootstrap5',
        events: events, // Задачи в виде событий на календаре
        eventClick: function (info) {
            const taskId = info.event.extendedProps.task_id;

            // URL для  адреса страницы конкретной задачи
            const taskUrl = `<?=$path;?>${taskId}`;

            //переход на страницу задачи
            window.location.href = taskUrl;
        },
    });

    calendar.render();
});
</script>
<?php 
    $content = ob_get_clean();
    include 'app/crm/layout.php';
?>