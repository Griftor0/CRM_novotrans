<?php 
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
</head>

<body>
    <div class="container">
        <form id="insuranceForm">     
            <div class="breadcrumbs">
                <h4><a href="/">Главная</a></h4>
                <h4>></h4>
                <h4 style="color: #007BFB;">Рассчитать точную стоимость</h4>
            </div>
            <h2>Рассчитать точную стоимость</h2>
            <h3>Для расчета конечной стоимости страховки нам нужны ваши данные</h3>
            <div class="input-block">
                <div class="item">
                    <h4 class="item__name">Область регистрации *</h4>
                    <select name="area" id="area" required>
                        <option value="" disabled selected></option>
                        <option value="г. Алматы">г. Алматы</option>
                        <option value="г. Астана">г. Астана</option>
                        <option value="Акмолинская область">Акмолинская область</option>
                        <option value="Актюбинская область">Актюбинская область</option>
                        <option value="Алматинская область">Алматинская область</option>
                        <option value="Атырауская область">Атырауская область</option>
                        <option value="Восточно-Казахстанская область">Восточно-Казахстанская область</option>
                        <option value="Жамбылская область">Жамбылская область</option>
                        <option value="Западно-Казахстанская область">Западно-Казахстанская область</option>
                        <option value="Карагандинская область">Карагандинская область</option>
                        <option value="Костанайская область">Костанайская область</option>
                        <option value="Кызылординская область">Кызылординская область</option>
                        <option value="Мангистауская область">Мангистауская область</option>
                        <option value="Павлодарская область">Павлодарская область</option>
                        <option value="Северо-Казахстанская область">Северо-Казахстанская область</option>
                        <option value="Южно-Казахстанская область">Южно-Казахстанская область</option>
                    </select>
                </div>
                <div class="item">
                    <h4 class="item__name">Город *</h4>
                    <input type="text" name="city" id="city" required>
                </div>
                <div class="item">
                    <h4 class="item__name">Возраст *</h4>
                    <input type="text" name="age" id="age" required>
                </div>
                <div class="item">
                    <h4 class="item__name">Стаж вождения *</h4>
                    <input type="text" name="driving_exp" id="driving_exp" required>
                </div>
                <div class="item">
                    <h4 class="item__name">Тип транспорта *</h4>
                    <select name="vehicle_type" id="vehicle_type" required>
                        <option value="" disabled selected></option>
                        <option value="Легковое">Легковое</option>
                        <option value="Автобус">Автобус</option>
                        <option value="Грузовое">Грузовое</option>
                        <option value="Мототранспорт">Мототранспорт</option>
                        <option value="Прицеп">Прицеп</option>
                    </select>
                </div>
                <div class="item">
                    <h4 class="item__name">Год выпуска автомобиля *</h4>
                    <input type="text" name="vehicle_service_life" id="vehicle_service_life" required>
                </div>
                <div class="item">
                    <h4 class="item__name">Бонус-малус *</h4>
                    <select name="bonus_mapus_class" id="bonus_mapus_class" required>
                        <option value="" disabled selected></option>
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
                <div class="item checkboxes">
                    <div class="checkbox top">
                        <input type="checkbox" name="has_privileges1" id="has_privileges1" value="1">
                        <h4 style="margin: 0;">Являюсь пенсионером</h4>
                    </div>
                    <div class="checkbox bot">
                        <input type="checkbox" name="has_privileges2" id="has_privileges2" value="1">
                        <h4 style="margin: 0;">Являюсь инвалидом</h4>
                    </div>
                </div>
            </div>
            <div class="calculator-button">
                <button type="button" class="btn btn-calculator" id="calculateButton">Рассчитать полную стоимость</button>
                <div class="calculator-cost">
                    <h3 style="margin-bottom:10px">Стоимость вашей страховки: </h3>
                    <h3 id="result"></h3>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('calculateButton').addEventListener('click', function() {
            if (validateForm()) {
                calculateInsurance();
            }
        });

        function validateForm() {
            var area = document.getElementById('area').value;
            var city = document.getElementById('city').value;
            var age = document.getElementById('age').value;
            var drivingExp = document.getElementById('driving_exp').value;
            var vehicleType = document.getElementById('vehicle_type').value;
            var vehicleServiceLife = document.getElementById('vehicle_service_life').value;

            if (area === "" || city === "" || age === "" || drivingExp === "" || vehicleType === "" || vehicleServiceLife === "") {
                alert("Пожалуйста, заполните все обязательные поля.");
                return false;
            }
            if (isNaN(age) || age < 18) {
                alert("Возраст должен быть числом и не меньше 18.");
                return false;
            }
            if (isNaN(drivingExp) || drivingExp < 0) {
                alert("Стаж вождения должен быть числом и не меньше 0.");
                return false;
            }
            var currentYear = new Date().getFullYear();
            if (isNaN(vehicleServiceLife) || vehicleServiceLife < 1900 || vehicleServiceLife > currentYear) {
                alert("Год выпуска автомобиля должен быть числом между 1900 и " + currentYear + ".");
                return false;
            }
            return true;
        }

        function calculateInsurance() {
            var area = document.getElementById('area').value;
            var vehicle = document.getElementById('vehicle_type').value;
            var age = parseInt(document.getElementById('age').value);
            var drivingExp = parseInt(document.getElementById('driving_exp').value);
            var vehicleServiceLife = parseInt(document.getElementById('vehicle_service_life').value);
            var bonusMalus = document.getElementById('bonus_mapus_class').value;
            var hasPrivileges1 = document.getElementById('has_privileges1').checked;
            var hasPrivileges2 = document.getElementById('has_privileges2').checked;

            var areasC = {
                'г. Алматы': 2.96,
                'г. Астана': 2.20,
                'Акмолинская область': 1.32,
                'Актюбинская область': 1.35,
                'Алматинская область': 1.78,
                'Атырауская область': 2.69,
                'Восточно-Казахстанская область': 1.96,
                'Жамбылская область': 1.00,
                'Западно-Казахстанская область': 1.17,
                'Карагандинская область': 1.39,
                'Костанайская область': 1.95,
                'Кызылординская область': 1.09,
                'Мангистауская область': 1.15,
                'Павлодарская область': 1.63,
                'Северо-Казахстанская область': 1.33,
                'Южно-Казахстанская область': 1.01
            };

            var vehiclesC = {
                'Легковое': 2.09,
                'Автобус': 3.26,
                'Грузовое': 3.98,
                'Мототранспорт': 1.00,
                'Прицеп': 1.00
            };

            var bonusMalusesC = {
                'Класс М': 2.45,
                'Класс 0': 2.30,
                'Класс 1': 1.55,
                'Класс 2': 1.40,
                'Класс 3': 1.00,
                'Класс 4': 0.95,
                'Класс 5': 0.90,
                'Класс 6': 0.85,
                'Класс 7': 0.80,
                'Класс 8': 0.75,
                'Класс 9': 0.70,
                'Класс 10': 0.65,
                'Класс 11': 0.60,
                'Класс 12': 0.55,
                'Класс 13': 0.50
            };

            var areaC = areasC[area];
            var vehicleC = vehiclesC[vehicle];
            var cityC = 1.0;
            var ageC = (age > 25 ? 1.05 : 1.0) + (drivingExp > 2 ? 0.05 : 0);
            var vehicleServiceLifeC = (2024 - vehicleServiceLife > 7 ? 1.10 : 1.0);
            var bonusMalusC = bonusMalusesC[bonusMalus];
            var privilegesC = (hasPrivileges1 || hasPrivileges2) ? 0.5 : 1;

            var mrp = 3692;
            var baseCost = mrp * 1.9;
            var totalCost = baseCost * areaC * vehicleC * cityC * ageC * vehicleServiceLifeC * bonusMalusC * privilegesC;

            document.getElementById('result').innerHTML = Math.round(totalCost) + '₸';
        }
    </script>
</body>
</html>

<?php 
$content = ob_get_clean();
include "app/site/header.php";
echo $content;
include "app/site/footer.php";
?>