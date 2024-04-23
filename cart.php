<?php
include_once "header.php";
// Проверяваме дали е изпратена поръчка
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["phone"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["address"]) && isset($_POST["city"]) && isset($_POST["totalAmount"]) && isset($_POST["products"])) {
    // Проверяваме дали сесията е стартирана
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Изчистваме количката, ако съществува
    if (isset($_SESSION["cart"])) {
        unset($_SESSION["cart"]);
    }

    header("Location: index.php?success=true"); // Пренасочваме към index.php със съобщение за успешна поръчка
    exit();
}
?>

</div>
<!-- Cart-Items details -->
<div class="small-container cart-page">
    <?php if (empty($_SESSION['cart'])) : ?>
        <p>Количката е празна.</p>
    <?php else : ?>
        <table>
            <tr>
                <th>Продукт</th>
                <th>Количество</th>
                <th>Междинна сума</th>
                <th>Изтрий</th> <!-- Добавен ред за бутона за изтриване -->
            </tr>
            <?php
            
            // Инициализираме променливата за междинна сума
            $intermediateTotal = 0;
            foreach ($_SESSION["cart"] as $index => $cartItem) {
                $sql = "SELECT * FROM products WHERE productId = " . $cartItem['id'];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $sql2 = "";
                if (!empty($row["images"])) {
                    $imagesArray = explode(" ", $row["images"]);
                    if (is_array($imagesArray) && count($imagesArray) > 0) {
                        $sql2 = "SELECT * FROM images WHERE id = " . $imagesArray[0];
                    }
                }
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);

                if ($row && $row2) {
                    // Изчисляваме базовата цена на продукта
                    $price = str_replace('.', ',', $row["price"]);

                    foreach ($cartItem as $item) {
                        if (isset($item["year"]) && isset($item["count"])) {
                            $year = $item["year"];
                            $count = $item["count"];
                           

                            // Изчисляваме междинната сума за текущия продукт
                            $productIntermediateTotal = $count * $price;
                            $intermediateTotal += $productIntermediateTotal;

                            ?>
                            <tr>
                                <td>
                                    <div class="cart-info">
                                        <img src="includes/<?php echo $row2['img_dir'] ?>">
                                        <div>
                                            <p><?php echo $row["name"] ?> - <?php echo $year ?></p>
                                            <small>Цена: <?php echo $price ?> лв.</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="quantity-cell">
                                    <form onsubmit="event.preventDefault(); updateQuantity(<?php echo $cartItem['id']; ?>, <?php echo $index; ?>);">
                                        <input type="number" name="quantity" value="<?php echo $count; ?>" min="1">
                                        <button type="submit">Обнови</button>
                                    </form>
                                </td>
                                <td class="subtotal"><?php echo $productIntermediateTotal ?> лв.</td>
                                <td><button onclick="deleteFromCart(<?php echo $cartItem['id']; ?>, <?php echo $index; ?>)">Изтрий</button></td> <!-- Бутон за изтриване -->
                            </tr>
                            <?php
                        }
                    }
                }
            }
            ?>
        </table>
    <?php endif; ?>

    <div class="total-price">
        <table>
            <tr>
                <td>Междинна сума:</td>
                <td id="intermediateTotal"><?php echo isset($intermediateTotal) ? number_format($intermediateTotal, 2) : '0.00'; ?> лв.</td>
            </tr>
            <tr>
                <td>ДДС:</td>
                <td id="vat"><?php echo isset($intermediateTotal) ? number_format($intermediateTotal * 0.2, 2) : '0.00'; ?> лв.</td>
            </tr>
            <tr>
                <td>Обща сума:</td>
                <td id="total"><?php echo isset($intermediateTotal) ? number_format(($intermediateTotal + $intermediateTotal * 0.2), 2) : '0.00'; ?> лв.</td>
            </tr>
            <tr>
                <td colspan="2">
                    <button onclick="showPaymentForm()">Плащане</button>
                </td>
            </tr>
        </table>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=ASIMF9IP0pjVrfVuduP3s_SWy6YH07GjPxfuCuv1nQ1A_XAMp3_8-OdgZP6-dZ739mA-moVIdS6ag1dB&currency=USD"></script>
    <!-- Payment Form -->
    <div id="paymentForm" style="display: none;">
        <h2>Информация за плащане</h2>
        <form id="paymentFormSubmit" onsubmit="submitPaymentForm(event)">
            <label for="phone">Телефонен номер:</label><br>
            <input type="text" id="phone" name="phone" required><br>
            <label for="name">Име:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="email">Имейл:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="address">Адрес:</label><br>
            <input type="text" id="address" name="address" required><br>
            <label for="city">Град:</label><br>
            <input type="text" id="city" name="city" required><br><br>
            <input type="submit" value="Потвърди" id="submitPaymentButton">
<div id="paypal-button-container"></div>

        </form>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col-1">
                <h3>Кратко описание:</h3>
                <p>"Kiko's parts" е най-добрият магазин за авточасти в България!.Ниски цени високо качество и изключително много доволни клиенти! </p>
                
            </div>
           
            <div class="footer-col-3">
                <h3>Работно време: </h3>
                
              <p> <span>Понеделник -Петък:</span> 8:00 - 19:00ч. </p>
              <p> <span>Събота:</span> 10:00 - 17:00ч. </p>
              <p> <span>Неделя:</span> Затворено</p>
              <p> <span>Официални  празници:</span> Затворено</p>
              <p> <span>Национален празник:</span> Затворено</p>
              
            </div>
            <div class="footer-col-4">
                <h3>Последвайте ни:</h3>
                <ul>
                    <li><a class="fa fa-facebook" > Кристиян Радев</a></li>
                    <li><a class="fa fa-instagram" > radev31</a></li>
                    <li><a class="link"> <i class="fa fa-mobile-phone"></i> +359-893-724-681 </a></li>
                    <li><a  class="link"> <i class="fa fa-envelope"></i> kristiyanradev19b@gmail.com </a></li>
                </ul>
            </div>
        </div>
        <hr>
        <p class="copyright"> &copy Създадено от Кристиян Радев | Всички права запазени!</p>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
<script>
    function updateButtonState() {
    var phone = document.getElementById("phone").value;
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var address = document.getElementById("address").value;
    var city = document.getElementById("city").value;
    var submitPaymentButton = document.getElementById("submitPaymentButton");
    var paypalButton = document.getElementById("paypal-button-container");

    if (phone && name && email && address && city) {
        submitPaymentButton.removeAttribute("disabled");
        submitPaymentButton.classList.remove("disabled");
        paypalButton.style.display = "block"; // Показваме бутона на PayPal
    } else {
        submitPaymentButton.setAttribute("disabled", "disabled");
        submitPaymentButton.classList.add("disabled");
        paypalButton.style.display = "none"; // Скриваме бутона на PayPal
    }
}

// Добавяме слушатели за промяна на съдържанието на полетата за плащане
document.getElementById("phone").addEventListener("input", updateButtonState);
document.getElementById("name").addEventListener("input", updateButtonState);
document.getElementById("email").addEventListener("input", updateButtonState);
document.getElementById("address").addEventListener("input", updateButtonState);
document.getElementById("city").addEventListener("input", updateButtonState);

// Извикваме функцията updateButtonState() при зареждане на страницата
document.addEventListener("DOMContentLoaded", updateButtonState);

// Функция за показване на формата за плащане
function showPaymentForm() {
    document.getElementById("paymentForm").style.display = "block";
}

// Функция за изпращане на формата за плащане
function submitPaymentForm(event) {
    event.preventDefault();
    // Останалите части от кода остават непроменени
    // ...
}

// PayPal Button
paypal.Buttons({
        createOrder: function(data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo isset($intermediateTotal) ? $intermediateTotal : '0.00'; ?>', // Тук посочете общата сума за плащане
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
    // This function captures the funds from the transaction.
    return actions.order.capture().then(function(details) {
        // This function shows a transaction success message to your buyer.
        alert('Транзакцията е успешна!'); 
        
        // Събиране на данните от количката
        var cart = <?php echo json_encode($_SESSION['cart']); ?>;
        
        // Пренасочване към placePaypalOrder.php с добавени данни от количката
        window.location.href = 'placePaypalOrder.php?cart=' + encodeURIComponent(JSON.stringify(cart));
    });
        }
    }).render('#paypal-button-container');
    // Проверка за запазено количество в Local Storage и актуализация на формите за количеството
    document.addEventListener("DOMContentLoaded", function() {
        var cartItems = <?php echo json_encode($_SESSION["cart"]); ?>;
        cartItems.forEach(function(cartItem, index) {
            var storedQuantity = localStorage.getItem("cart_" + cartItem.id);
            if (storedQuantity !== null) {
                var inputElement = document.querySelectorAll("table tr")[index].querySelector(".quantity-cell input[name='quantity']");
                if (inputElement) {
                    inputElement.value = storedQuantity;
                }
            }
        });
        updateTotalPrice(); // Актуализация на междинната и общата сума
    });

    // Функция за обновяване на количеството
    function updateQuantity(productId, index) {
        var inputElement = document.querySelectorAll("table tr")[index].querySelector(".quantity-cell input[name='quantity']");
        var newQuantity = inputElement ? inputElement.value : 0;
        $.ajax({
            url: "/includes/updateQuantity.php",
            type: "POST",
            data: { productId: productId, quantity: newQuantity, index: index },
            success: function(data) {
                // Ако актуализацията е успешна, пресметнете новата междинна сума и обща сума
                updateTotalPrice();

                // Запазване на текущото количество в Local Storage
                localStorage.setItem("cart_" + productId, newQuantity);

                // Реагиране на отговора от сървъра
                var response = JSON.parse(data);
                if (response.success) {
                    // Успешно актуализиране на количеството в сесията
                    // Актуализация на DOM елементите на страницата с новите данни
                    var intermediateTotalCell = document.getElementById("intermediateTotal");
                    intermediateTotalCell.innerText = response.newIntermediateTotal.toFixed(2) + ' лв.';

                    var vatCell = document.getElementById("vat");
                    vatCell.innerText = (response.newIntermediateTotal * 0.2).toFixed(2) + ' лв.';

                    var totalCell = document.getElementById("total");
                    totalCell.innerText = (response.newIntermediateTotal * 1.2).toFixed(2) + ' лв.';
                } else {
                    // Показване на съобщение за грешка
                    console.log("Грешка при актуализиране на количеството в сесията.");
                }
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
                alert("Грешка при обновяване на количеството.");
            }
        });
    }

    // Функция за изтриване на продукт от количката
    function deleteFromCart(productId, index) {
        $.ajax({
            url: "/includes/deleteFromCart.php",
            type: "POST",
            data: { productId: productId, index: index },
            success: function(data) {
                // Ако изтриването е успешно, презареждаме страницата
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
                alert("Грешка при изтриване на продукта от количката.");
            }
        });
    }

    // Функция за актуализация на междинната сума и общата сума
    function updateTotalPrice() {
        var intermediateTotal = 0;
        var rows = document.querySelectorAll("table tr");
        for (var i = 1; i < rows.length; i++) {
            var inputElement = rows[i].querySelector(".quantity-cell input[name='quantity']");
            if (inputElement) {
                var quantity = parseInt(inputElement.value);
                var priceElement = rows[i].querySelector(".cart-info small").innerText.split(": ")[1];
                var price = parseFloat(priceElement);
                intermediateTotal += quantity * price;
                var subtotalCell = rows[i].querySelector(".subtotal");
                subtotalCell.innerText = (quantity * price).toFixed(2) + ' лв.';
            }
        }
        var vat = intermediateTotal * 0.2;
        var total = intermediateTotal + vat;
        document.getElementById("intermediateTotal").innerText = intermediateTotal.toFixed(2) + ' лв.';
        document.getElementById("vat").innerText = vat.toFixed(2) + ' лв.';
        document.getElementById("total").innerText = total.toFixed(2) + ' лв.';
    }

    // Функция за показване на формата за плащане
    function showPaymentForm() {
        document.getElementById("paymentForm").style.display = "block";
    }

    // Функция за изпращане на формата за плащане
    function submitPaymentForm(event) {
    event.preventDefault();
    var phone = document.getElementById("phone").value;
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var address = document.getElementById("address").value;
    var city = document.getElementById("city").value;
    var intermediateTotal = parseFloat(document.getElementById("intermediateTotal").innerText.replace(",", ".")); // Междинна сума
var vat = parseFloat(document.getElementById("vat").innerText.replace(",", ".")); // ДДС
var totalAmount = (intermediateTotal + vat).toFixed(2).replace(".", ","); // Обща сума

    var products = [];

    var rows = document.querySelectorAll("table tr");
    rows.forEach(function(row) {
        var productNameElement = row.querySelector(".cart-info p");
        var quantityInput = row.querySelector(".quantity-cell input[name='quantity']");
        var priceCell = row.querySelector(".subtotal");

        if (productNameElement && quantityInput && priceCell) {
            var productName = productNameElement.innerText;
            var year = productNameElement.innerText.split(" - ")[1];
            var quantity = quantityInput.value;
            var price = parseFloat(priceCell.innerText.split(" ")[0]);
            var productData = {
                name: productName,
                year: year,
                quantity: quantity
                
                
            };
            products.push(productData);
        }
    });

    $.ajax({
        url: "placeOrder.php",
        type: "POST",
        data: {
            phone: phone,
            name: name,
            email: email,
            address: address,
            city: city,
            totalAmount: totalAmount, // Изпращаме общата сума
            products: JSON.stringify(products)
        },
        success: function(data) {
            alert("Поръчката е приета успешно!");
            location.href = "index.php?success=true"; // Пренасочваме към index.php със съобщение за успешна поръчка
        },
        error: function() {
            alert("Възникна грешка при плащането.");
        }
    });
}
</script>

</body>
</html>
