document.addEventListener("DOMContentLoaded", function () {
    // Загрузка данных по сумме продаж по товару
    fetch("data.php?action=salesByProduct")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector("#sales-by-product tbody");
            data.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.product_code}</td>
                    <td>${item.product_name}</td>
                    <td>${item.total_quantity}</td>
                    <td>${item.total_retail_sum.toFixed(2)}</td>
                `;
                tableBody.appendChild(row);
            });
        });

    // Загрузка данных по сумме продаж товаров из группы
    fetch("data.php?action=salesByGroup")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector("#sales-by-group tbody");
            data.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.pharmacy_name}</td>
                    <td>${item.sale_date}</td>
                    <td>${item.total_quantity}</td>
                    <td>${item.total_cost_sum.toFixed(2)}</td>
                    <td>${item.total_retail_sum.toFixed(2)}</td>
                    <td>${item.total_discount.toFixed(2)}</td>
                `;
                tableBody.appendChild(row);
            });
        });

    // Загрузка данных по наценке аптек
    fetch("data.php?action=markupByPharmacy")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector("#markup-by-pharmacy tbody");
            data.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.pharmacy_name}</td>
                    <td>${item.group_name}</td>
                    <td>${(item.markup * 100).toFixed(2)}</td>
                `;
                tableBody.appendChild(row);
            });
        });
});
