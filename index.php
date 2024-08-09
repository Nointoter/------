<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчеты по продажам</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Отчеты по продажам</h1>

    <div class="report" id="sales-by-product">
        <h2>Сумма продаж по товару</h2>
        <table>
            <thead>
                <tr>
                    <th>Код товара</th>
                    <th>Название</th>
                    <th>Количество</th>
                    <th>Сумма (розничная)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Данные будут загружены с помощью JavaScript -->
            </tbody>
        </table>
    </div>

    <div class="report" id="sales-by-group">
        <h2>Сумма продаж товаров из группы</h2>
        <table>
            <thead>
                <tr>
                    <th>Аптека</th>
                    <th>Дата</th>
                    <th>Количество</th>
                    <th>Сумма (приходная)</th>
                    <th>Сумма (розничная)</th>
                    <th>Скидка</th>
                </tr>
            </thead>
            <tbody>
                <!-- Данные будут загружены с помощью JavaScript -->
            </tbody>
        </table>
    </div>

    <div class="report" id="markup-by-pharmacy">
        <h2>Наценка по аптекам и группам товаров</h2>
        <table>
            <thead>
                <tr>
                    <th>Аптека</th>
                    <th>Группа товаров</th>
                    <th>Наценка (%)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Данные будут загружены с помощью JavaScript -->
            </tbody>
        </table>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
