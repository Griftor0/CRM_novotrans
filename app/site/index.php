<?php 
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новотранс</title>
</head>
<body>
    <main class="main">
        <section class="order" id="part1">
            <div class="container">
                <h1>Страхование вида ОС ГПО ВТС</h1>
                <h3 class="slogan">Более 10 лет помогаем вам не переживать за автомобиль</h3>
                    <div class="row">
                        <input type="text" name="full_name" id="fio" placeholder="ФИО*">
                        <input type="text" name="phone" id="phone" placeholder="Телефон*">
                        <input type="text" name="vehicle_number" id="number" placeholder="Гос.номер*">
                        <input type="text" name="identification_number" id="iin" placeholder="ИИН*">
                        <select name="category_id" id="category_id">
                            <option value="" disabled selected>Выберите категорию*</option>
                            <option value="1">ОС ГПО ВТС</option>
                            <option value="2">ОС ГПО ППП</option>
                            <option value="3">ОС ГПО АО</option>
                            <option value="4">ОС ГПО ВОО</option>
                            <option value="5">ОЭС</option>
                            <option value="6">Страховой случай</option>
                            <option value="7">Оценка ущерба</option>
                            <option value="8">КАСКО</option>
                        </select>
                        <button id="submitBtn" class="btn btn-small">Отправить заявку</button>
                    </div>
                <h4 class="prompt">Знаком * отмечены обязательные для заполнения поля. Нажимая на кнопку, вы соглашаетесь на обработку персональных данных</h4>
            </div>
        </section>
        <section class="calculator">
            <div class="container">
                <div class="calculator__desc">
                    <h3 class="calculator__name">Калькулятор страхования</h3>  
                    <h2 class="calculator__text">Узнайте стоимость вашей страховки прямо сейчас</h2>
                </div>
                <div class="calculator__solver">
                    <div class="calculator__button">
                        <a href='/showCalculatorForm'>
                            <button class="btn big-button">Расчитать точную стоимость</button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('submitBtn').addEventListener('click', function(event) {
                var fullName = document.getElementById('fio').value.trim();
                var phone = document.getElementById('phone').value.trim();
                var vehicleNumber = document.getElementById('number').value.trim();
                var identificationNumber = document.getElementById('iin').value.trim();
                var categoryId = document.getElementById('category_id').value;

                if (!fullName || !phone || !vehicleNumber || !identificationNumber || !categoryId) {
                    alert('Пожалуйста, заполните все обязательные поля.');
                    return;
                }

                if (!/^[A-Za-zА-Яа-яЁё\s]{2,}$/.test(fullName)) {
                    alert('ФИО должно содержать только буквы и быть не менее 2 символов.');
                    return;
                }

                if (!/^\+?[0-9\s\-]{10,15}$/.test(phone)) {
                    alert('Телефон должен содержать от 10 до 15 цифр и может включать "+" в начале.');
                    return;
                }

                if (!/^[A-Za-z0-9\s\-]{1,10}$/.test(vehicleNumber)) {
                    alert('Гос.номер должен содержать от 1 до 10 символов (буквы и цифры).');
                    return;
                }

                if (!/^\d{12}$/.test(identificationNumber)) {
                    alert('ИИН должен содержать 12 цифр.');
                    return;
                }

                var formData = new FormData();
                formData.append('full_name', fullName);
                formData.append('phone', phone);
                formData.append('vehicle_number', vehicleNumber);
                formData.append('identification_number', identificationNumber);
                formData.append('category_id', categoryId);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/crm/todo/tasks/createClientWithTask', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert('Заявка успешно отправлена!');
                            document.getElementById('fio').value = '';
                            document.getElementById('phone').value = '';
                            document.getElementById('number').value = '';
                            document.getElementById('iin').value = '';
                            document.getElementById('category_id').value = '';
                        } else {
                            alert('Произошла ошибка при отправке заявки. Пожалуйста, попробуйте еще раз.');
                        }
                    }
                };
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>

<?php 
$content = ob_get_clean();
include "app/site/header.php";
echo $content;
include "app/site/footer.php";
?>