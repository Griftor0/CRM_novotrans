<?php
function is_active($href) {
    // Получаем текущий URL
    $currentUrl = $_SERVER['REQUEST_URI'];
    
    // Проверяем, содержит ли текущий URL адрес ссылки из меню
    if ($currentUrl == $href) {
        return 'active'; // Возвращаем 'active', если текущий URL совпадает с адресом ссылки
    } else {
        return ''; // Возвращаем пустую строку в противном случае
    }
}
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'no-name';
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 1;

ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/app/crm/style.css">

    <script src="https://kit.fontawesome.com/6e56039614.js" crossorigin="anonymous"></script>

    <!-- flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- JavaScript Calendar | https://fullcalendar.io/ -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
</head>
<body>
    <div class="row">
        <?php if ($user_role != 1): ?>
            <div class="sidebar col-md-2 p-0">
                <div class="d-flex flex-column flex-shrink-0 p-0 text-white position-sticky" style="height: 98vh; background-color: #282D3C; top: 0;">
                    <a href="/crm" class="d-flex align-items-center mt-5 mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                        <span class="fs-4">Календарь</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <?php 
                            $menuItems = [
                                'Пользователи' => '/crm/users',
                                'Роли' => '/crm/roles',
                                'Страницы' => '/crm/pages',
                                'Типы страхования' => '/crm/todo/category',
                                'Заявки' => '/crm/todo/tasks',
                                'Архив' => '/crm/todo/tasks/showArchive',
                                'Клиенты' => '/crm/todo/clients',
                                'Добавить заявку' => '/crm/todo/tasks/showCreateForm',
                            ];
                            $icons = [
                                'Пользователи' => 'fa-user',
                                'Роли' => 'fa-user-shield',
                                'Страницы' => 'fa-file-alt',
                                'Типы страхования' => 'fa-list-alt',
                                'Заявки' => 'fa-tasks',
                                'Архив' => 'fa-archive',
                                'Клиенты' => 'fa-users',
                                'Добавить заявку' => 'fa-plus-circle',
                            ];
                            $menuStarted = false;
                            foreach ($menuItems as $name => $href) {
                                if ($name === 'Типы страхования') {
                                    if ($user_role == 5){
                                        echo '<hr>';
                                    }
                                    $menuStarted = true;
                                }
                                if ($menuStarted || $user_role == 5) {
                                    $icon = isset($icons[$name]) ? $icons[$name] : 'fa-question-circle';
                                    echo '
                                    <li class="ms-3">
                                        <a href="'.$href.'" class="nav-link text-white ' . is_active($href) . '">
                                            <i class="fa-solid ' . $icon . ' me-2"></i>
                                            '.$name.'
                                        </a>
                                    </li>';
                                }
                            }
                        ?>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle me-2" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zm0 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM4.5 6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 .5-.5zm7 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                        </svg>
                        <strong><?=$user_email?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="/crm/authentication/logout">Sign out</a></li>
                            <li><a class="dropdown-item" href="/crm/authentication/showLoginForm">Sign in</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="<?php echo $user_role == 1 ? 'col-md-12' : 'col-md-10'; ?> p-0">
            <div class="container mt-4">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="/app/crm/my.js"></script>
</body>
</html>