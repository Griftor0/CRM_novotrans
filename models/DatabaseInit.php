<?php

namespace models;

use models\Database;

class DatabaseInit {
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = Database::getInstance()->getConnection();
        
        try{
            $result = $this->dbConnection->query("SELECT 1 FROM `users` LIMIT 1");
        } catch(\PDOException $e){
            $this->initializeTables();
        }
    }

    public function initializeTables() {
        $queries = [
            "CREATE TABLE IF NOT EXISTS `roles` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `role_name` VARCHAR(255) NOT NULL,
                `role_description` TEXT
            )",
            "CREATE TABLE IF NOT EXISTS `users` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `email_verification` TINYINT(1) DEFAULT 0,
                `password` VARCHAR(255) NOT NULL,
                `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
                `role` INT(11) NOT NULL DEFAULT 0,
                `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                `last_login` TIMESTAMP NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
            )",
            "CREATE TABLE IF NOT EXISTS `pages` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(255) NOT NULL,
                `roles` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
            "CREATE TABLE IF NOT EXISTS `todo_category` (
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `description` TEXT,
                `is_visible` TINYINT DEFAULT 1,
                `user_id` INT NOT NULL,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
            )",
            "CREATE TABLE `areas` (
                `id` INT NOT NULL PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL
            )",
             "CREATE TABLE `cities` (
                `id` INT NOT NULL PRIMARY KEY,
                `area_id` INT,
                `name` VARCHAR(255) NOT NULL,
                FOREIGN KEY (`area_id`) REFERENCES `areas`(`id`)
            )",
            "CREATE TABLE IF NOT EXISTS `clients` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `full_name` VARCHAR(255) NOT NULL,
                `identification_number` VARCHAR(13) NOT NULL,
                `phone` VARCHAR(25) NOT NULL,
                `email` VARCHAR(255),
                `vehicle_number` VARCHAR(11) NOT NULL,
                `vehicle_type` ENUM('Легковое', 'Автобус', 'Грузовое', 'Мототранспорт', 'Прицеп'),
                `vehicle_service_life` INT(3),
                `city_id` INT,
                `age` INT(3),
                `driving_exp` INT(3),
                `has_privileges` TINYINT(1),
                `bonus_mapus_class` ENUM('Класс М', 'Класс 0', 'Класс 1', 'Класс 2', 'Класс 3', 'Класс 4', 'Класс 5', 'Класс 6', 'Класс 7', 'Класс 8', 'Класс 9', 'Класс 10', 'Класс 11', 'Класс 12', 'Класс 13'),
                FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`)
            )",
            "CREATE TABLE IF NOT EXISTS `todo_list` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `client_id` INT,
                `category_id` INT,
                `description` TEXT,
                `status` ENUM('В ожидании', 'К выполнению', 'Выполнено', 'Архив') NOT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `completed_at` DATETIME,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
                FOREIGN KEY (`category_id`) REFERENCES `todo_category`(`id`) ON DELETE SET NULL,
                FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS `tags` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT(11),
                `name` VARCHAR(255) NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS `task_tags` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `task_id` INT(11) NOT NULL,
                `tag_id` INT(11) NOT NULL,
                FOREIGN KEY (task_id) REFERENCES todo_list(id) ON DELETE CASCADE, 
                FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
            )",
            "INSERT INTO `pages` (`title`, `slug`, `roles`) VALUES
                ('Home', 'crm', '2,3,4,5'),
                ('Users', 'crm/users', '2,5'),
                ('Users createForm', 'crm/users/showCreateForm', '3,4,5'),
                ('Users editForm', 'crm/users/showEditForm', '2,5'),
                ('Users create', 'crm/users/createUser', '3,4,5'),
                ('Users update', 'crm/users/updateUser', '5'),
                ('Users delete', 'crm/users/delete', '5'),
                ('Roles', 'crm/roles', '2,3,4,5'),
                ('Roles createForm', 'crm/roles/showCreateForm', '3,4,5'),
                ('Roles editForm', 'crm/roles/showEditForm', '3,4,5'),
                ('Roles create', 'crm/roles/createRole', '3,4,5'),
                ('Roles update', 'crm/roles/updateRole', '5'),
                ('Pages', 'crm/pages', '5'),
                ('Pages createForm', 'crm/pages/showCreateForm', '5'),
                ('Pages editForm', 'crm/pages/showEditForm', '5'),
                ('Pages create', 'crm/pages/createPage', '5'),
                ('Pages update', 'crm/pages/updatePage', '5'),
                ('Pages delete', 'crm/pages/deletePage', '5'),
                ('Todo category', 'crm/todo/category', '3,4,5'),
                ('Todo category createForm', 'crm/todo/category/showCreateForm', '3,4,5'),
                ('Todo category editForm', 'crm/todo/category/showEditForm', '3,4,5'),
                ('Todo category create', 'crm/todo/category/createCategory', '3,4,5'),
                ('Todo category update', 'crm/todo/category/updateCategory', '3,4,5'),
                ('Todo category delete', 'crm/todo/category/deleteCategory', '3,4,5'),
                ('Todo tasks', 'crm/todo/tasks', '3,4,5'),
                ('Todo tasks create', 'crm/todo/tasks/showCreateForm', '3,4,5'),
                ('Todo tasks store', 'crm/todo/tasks/createTask', '3,4,5'),
                ('Todo tasks edit', 'crm/todo/tasks/showEditForm', '3,4,5'),
                ('Todo tasks update', 'crm/todo/tasks/updateTask', '3,4,5'),
                ('Todo tasks delete', 'crm/todo/tasks/deleteTask', '3,4,5'),
                ('Todo completed tasks', 'crm/todo/tasks/completed', '3,4,5'),
                ('Todo expired tasks', 'crm/todo/tasks/expired', '3,4,5'),
                ('Todo tasks task info', 'crm/todo/tasks/viewTask', '2,3,4,5'),
                ('Todo tasks by tag', 'crm/todo/tasks/by-tag', '2,3,4,5');",
            "INSERT INTO `roles` (`role_name`, `role_description`) VALUES
                ('Subscriber', 'Может только читать статьи и оставлять комментарии, но не имеет права создавать свой контент или управлять сайтом.'),
                ('Editor', 'Доступ к управлению и публикации статей, страниц и других контентных материалов на сайте. Редактор также может управлять комментариями и разрешать или запрещать их публикацию.'),
                ('Author', 'Может создавать и публиковать собственные статьи, но не имеет возможности управлять контентом других пользователей.'),
                ('Contributor', 'Может создавать свои собственные статьи, но они не могут быть опубликованы до одобрения администратором или редактором.'),
                ('Administrator', 'Полный доступ ко всем функциям сайта, включая управление пользователями, плагинами а также создание и публикация статей.');",
            "INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES
                ('Admin', 'admin@gmail.com', '\$2y\$10\$HQrDKhcsKha2ARkPLxxtCuNHwPyXZKk6cQmooF8akYkmzT.fOs7fK', 5);",
            "INSERT INTO `todo_category` (`title`, `description`, `is_visible`, `user_id`) VALUES
                ('ОС ГПО ВТС', 'Обязательное страхование владельцев транспортных средств', 1, 1),
                ('ОС ГПО ППП', 'Обязательное страхование перевозчиков перед пассажирами', 1, 1),
                ('ОС ГПО АО', 'Обязательное страхование аудиторских организаций', 1, 1),
                ('ОС ГПО ВОО', 'Обязательное страхование владельцев опасных объектов', 1, 1),
                ('ОЭС', 'Обязательное экологическое страхование', 1, 1),
                ('Страховой случай', 'Событие, при наступлении которого осуществляется страховая выплата согласно договору страхования', 1, 1),
                ('Оценка ущерба', 'Процесс определения размера ущерба, подлежащего возмещению по договору страхования', 1, 1),
                ('КАСКО', 'Комплексное автомобильное страхование, включающее защиту от различных рисков, таких как угон, повреждение и др.', 1, 1);",
            "INSERT INTO `areas` (`id`, `name`) VALUES
                (1, 'АКМОЛИНСКАЯ ОБЛАСТЬ'),
                (2, 'АКТЮБИНСКАЯ ОБЛАСТЬ'),
                (3, 'АЛМАТИНСКАЯ ОБЛАСТЬ'),
                (4, 'АТЫРАУСКАЯ ОБЛАСТЬ'),
                (5, 'ЗАПАДНО-КАЗАХСТАНСКАЯ ОБЛАСТЬ'),
                (6, 'ЖАМБЫЛЬСКАЯ ОБЛАСТЬ'),
                (7, 'КАРАГАНДИНСКАЯ ОБЛАСТЬ'),
                (8, 'КОСТАНАЙСКАЯ ОБЛАСТЬ'),
                (9, 'КЫЗЫЛОРДИНСКАЯ ОБЛАСТЬ'),
                (10, 'МАНГИСТАУСКАЯ ОБЛАСТЬ'),
                (11, 'ЮЖНО-КАЗАХСТАНСКАЯ ОБЛАСТЬ'),
                (12, 'ПАВЛОДАРСКАЯ ОБЛАСТЬ'),
                (13, 'СЕВЕРО-КАЗАХСТАНСКАЯ ОБЛАСТЬ'),
                (14, 'ВОСТОЧНО-КАЗАХСТАНСКАЯ ОБЛАСТЬ');",
            "INSERT INTO `cities` (`id`, `area_id`, name) VALUES
                (1, 1, 'Кокшетау'), (2, 1, 'Степногорск'), (3, 2, 'Актобе'), (4, 3, 'Талдыкорган'), (5, 3, 'Капчагай'), (6, 3, 'Текели'), (7, 4, 'Атырау'),
                (8, 5, 'Уральск'), (9, 6, 'Тараз'), (10, 7, 'Караганда'), (11, 7, 'Балхаш'), (12, 7, 'Жезказган'), (13, 7, 'Каражал'), (14, 7, 'Приозерск'),
                (15, 7, 'Саран'), (16, 7, 'Сатпаев'), (17, 7, 'Темиртау'), (18, 7, 'Шахтинск'), (19, 8, 'Костанай'), (20, 8, 'Аркалык'), (21, 8, 'Лисаковск'),
                (22, 8, 'Рудный'), (23, 9, 'Кызылорда'), (24, 10, 'Актау'), (25, 10, 'Жанаозень'), (26, 11, 'Шымкент'), (27, 11, 'Арыс'), (28, 11, 'Кентау'),
                (29, 11, 'Туркестан'), (30, 12, 'Павлодар'), (31, 12, 'Аксу'), (32, 12, 'Экибастуз'), (33, 13, 'Петропавловск'), (34, 14, 'Усть-Каменогорск'), (35, 14, 'Курчатов'),
                (36, 14, 'Риддер'), (37, 14, 'Семей'), (38, 1, 'Акколь'), (39, 1, 'Атбасар'), (40, 1, 'Макинск'), (41, 1, 'Степняк'), (42, 1, 'Ерейментау'),
                (43, 1, 'Есиль'), (44, 1, 'Державин'), (45, 1, 'Щучинск'), (46, 2, 'Алга'), (47, 2, 'Кандыагаш'), (48, 2, 'Эмба'), (49, 2, 'Жем'),
                (50, 2, 'Темир'), (51, 2, 'Хромтау'), (52, 2, 'Шалкар'), (53, 3, 'Учарал'), (54, 3, 'Иссык'), (55, 3, 'Уштобе'), (56, 3, 'Каскелен'),
                (57, 3, 'Жаркент'), (58, 3, 'Сарканд'), (59, 4, 'Кульсары'), (60, 5, 'Аксай'), (61, 6, 'Жанатас'), (62, 6, 'Каратау'), (63, 6, 'Чу'),
                (64, 7, 'Абай'), (65, 7, 'Каркаралы'), (66, 8, 'Жетыкара'), (67, 9, 'Арал'), (68, 9, 'Казалы'), (69, 10, 'Форт - Шевченко'),
                (70, 11, 'Жетысай'), (71, 11, 'Сарыагаш'), (72, 11, 'Ленгер'), (73, 11, 'Шардара'), (74, 13, 'Булаев'), (75, 13, 'Мамлют'),
                (76, 13, 'Сергеев'), (77, 13, 'Тайынша'), (78, 14, 'Шар'), (79, 14, 'Зайсан'), (80, 14, 'Серебрянск'), (81, 14, 'Аягоз'),
                (82, 14, 'Зырьяновск'), (83, 14, 'Шемонаиха');",        
        ];
        
        foreach ($queries as $query) {
            $this->createTable($query);
        }
    }

    private function createTable($query) {
        $this->dbConnection->exec($query);
    }    
}