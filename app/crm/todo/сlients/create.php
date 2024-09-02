<?php
$title = 'Добавить клиента';
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
    <h1 class="my-4">Добавить клиента</h1>
    <form method="POST" action="/crm/todo/clients/createClient">
        <div style="background: #F4F6FB; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">ФИО</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="identification_number" class="form-label">ИИН</label>
                        <input type="text" class="form-control" id="identification_number" name="identification_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_number" class="form-label">Гос. номер</label>
                        <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_type" class="form-label">Тип ТС</label>
                        <select class="form-select" id="vehicle_type" name="vehicle_type">
                            <option value="">Выберите тип ТС</option>
                            <option value="Легковое">Легковое</option>
                            <option value="Автобус">Автобус</option>
                            <option value="Грузовое">Грузовое</option>
                            <option value="Мототранспорт">Мототранспорт</option>
                            <option value="Прицеп">Прицеп</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_service_life" class="form-label">Срок эксплуатации</label>
                        <input type="number" class="form-control" id="vehicle_service_life" name="vehicle_service_life">
                    </div>
                    <div class="mb-3">
                        <label for="city_name" class="form-label">Город</label>
                        <input type="text" class="form-control" id="city_name" name="city_name">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Возраст</label>
                        <input type="number" class="form-control" id="age" name="age">
                    </div>
                    <div class="mb-3">
                        <label for="driving_exp" class="form-label">Стаж вождения</label>
                        <input type="number" class="form-control" id="driving_exp" name="driving_exp">
                    </div>
                    <div class="mb-3">
                        <label for="bonus_mapus_class" class="form-label">Класс</label>
                        <select class="form-select" id="bonus_mapus_class" name="bonus_mapus_class">
                            <option value="">Выберите класс</option>
                            <option value="Класс М">Класс М</option>
                            <option value="Класс 0">Класс 0</option>
                            <option value="Класс 1">Класс 1</option>
                            <option value="Класс 2">Класс 2</option>
                            <option value="Класс 3">Класс 3</option>
                            <option value="Класс 4">Класс 4</option>
                            <option value="Класс 5">Класс 5</option>
                            <option value="Класс 6">Класс 6</option>
                            <option value="Класс 7">Класс 7</option>
                            <option value="Класс 8">Класс 8</option>
                            <option value="Класс 9">Класс 9</option>
                            <option value="Класс 10">Класс 10</option>
                            <option value="Класс 11">Класс 11</option>
                            <option value="Класс 12">Класс 12</option>
                            <option value="Класс 13">Класс 13</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" id="has_privileges" name="has_privileges" value="1">
                        <label for="has_privileges" class="form-label" >Льготы</label>
                    </div>
                </div>
            </div>
            <button button type="submit" class="b">Добавить</button>
        </div>
    </form>    
</div>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>