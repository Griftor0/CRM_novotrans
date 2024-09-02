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
    <h1 class="my-4">Редактировать</h1>
    <form method="POST" action="/crm/todo/clients/updateClient">
        <div style="background: #F4F6FB; padding: 30px; width: 500px; border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.5) ">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="id" value="<?= $client['id'] ?>">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">ФИО</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $client['full_name'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="identification_number" class="form-label">ИИН</label>
                        <input type="text" class="form-control" id="identification_number" name="identification_number" value="<?= $client['identification_number'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $client['phone'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_number" class="form-label">Гос. номер</label>
                        <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" value="<?= $client['vehicle_number'] ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $client['email'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_type" class="form-label">Тип ТС</label>
                        <select class="form-select" id="vehicle_type" name="vehicle_type">
                            <option value="" <?= $client['vehicle_type'] == '' ? 'selected' : ''?>>Выберите тип ТС</option>
                            <option value="Легковое" <?= $client['vehicle_type'] == 'Легковое' ? 'selected' : ''?>>Легковое</option>
                            <option value="Автобус" <?= $client['vehicle_type'] == 'Автобус' ? 'selected' : ''?>>Автобус</option>
                            <option value="Грузовое" <?= $client['vehicle_type'] == 'Грузовое' ? 'selected' : ''?>>Грузовое</option>
                            <option value="Мототранспорт" <?= $client['vehicle_type'] == 'Мототранспорт' ? 'selected' : ''?>>Мототранспорт</option>
                            <option value="Прицеп" <?= $client['vehicle_type'] == 'Прицеп' ? 'selected' : ''?>>Прицеп</option>
                        </select>
                    </select>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_service_life" class="form-label">Срок эксплуатации</label>
                        <input type="number" class="form-control" id="vehicle_service_life" name="vehicle_service_life" value="<?= $client['vehicle_service_life'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="city_id" class="form-label">Город</label>
                        <input type="text" class="form-control" id="city_id" name="city_id" value="<?= $client['city_id'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="city_name" class="form-label">Город</label>
                        <input type="text" class="form-control" id="city_name" name="city_name">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Возраст</label>
                        <input type="number" class="form-control" id="age" name="age" value="<?= $client['age'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="driving_exp" class="form-label">Стаж вождения</label>
                        <input type="number" class="form-control" id="driving_exp" name="driving_exp" value="<?= $client['driving_exp'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="bonus_mapus_class" class="form-label">Класс</label>
                        <select class="form-select" id="bonus_mapus_class" name="bonus_mapus_class">
                            <option value="" <?= $client['bonus_mapus_class'] == 'Легковое' ? 'selected' : ''?>>Выберите класс</option>
                            <option value="Класс М" <?= $client['bonus_mapus_class'] == 'Класс М' ? 'selected' : ''?>>Класс М</option>
                            <option value="Класс 0" <?= $client['bonus_mapus_class'] == 'Класс 0' ? 'selected' : ''?>>Класс 0</option>
                            <option value="Класс 1" <?= $client['bonus_mapus_class'] == 'Класс 1' ? 'selected' : ''?>>Класс 1</option>
                            <option value="Класс 2" <?= $client['bonus_mapus_class'] == 'Класс 2' ? 'selected' : ''?>>Класс 2</option>
                            <option value="Класс 3" <?= $client['bonus_mapus_class'] == 'Класс 3' ? 'selected' : ''?>>Класс 3</option>
                            <option value="Класс 4" <?= $client['bonus_mapus_class'] == 'Класс 4' ? 'selected' : ''?>>Класс 4</option>
                            <option value="Класс 5" <?= $client['bonus_mapus_class'] == 'Класс 5' ? 'selected' : ''?>>Класс 5</option>
                            <option value="Класс 6" <?= $client['bonus_mapus_class'] == 'Класс 6' ? 'selected' : ''?>>Класс 6</option>
                            <option value="Класс 7" <?= $client['bonus_mapus_class'] == 'Класс 7' ? 'selected' : ''?>>Класс 7</option>
                            <option value="Класс 8" <?= $client['bonus_mapus_class'] == 'Класс 8' ? 'selected' : ''?>>Класс 8</option>
                            <option value="Класс 9" <?= $client['bonus_mapus_class'] == 'Класс 9' ? 'selected' : ''?>>Класс 9</option>
                            <option value="Класс 10" <?= $client['bonus_mapus_class'] == 'Класс 10' ? 'selected' : ''?>>Класс 10</option>
                            <option value="Класс 11" <?= $client['bonus_mapus_class'] == 'Класс 11' ? 'selected' : ''?>>Класс 11</option>
                            <option value="Класс 12" <?= $client['bonus_mapus_class'] == 'Класс 12' ? 'selected' : ''?>>Класс 12</option>
                            <option value="Класс 13" <?= $client['bonus_mapus_class'] == 'Класс 13' ? 'selected' : ''?>>Класс 13</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" id="has_privileges" name="has_privileges" value="1" <?php echo $client['has_privileges'] ? ' checked' : '';?>>
                        <label for="has_privileges" class="form-label" >Льготы</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="b">Изменить</button>
        </div>
    </form>    
</div>
<?php 
$content = ob_get_clean();
include 'app/crm/layout.php'; 
?>