<?php
session_start();

// Ініціалізація змінних сесії, якщо вони не встановлені
if (!isset($_SESSION['max_value'])) $_SESSION['max_value'] = 10;
if (!isset($_SESSION['operand1'])) $_SESSION['operand1'] = 0;
if (!isset($_SESSION['operand2'])) $_SESSION['operand2'] = 0;
if (!isset($_SESSION['sign'])) $_SESSION['sign'] = '+';
if (!isset($_SESSION['input'])) $_SESSION['input'] = '';
if (!isset($_SESSION['result'])) $_SESSION['result'] = '???';

// Обробка натискання кнопок діапазону
if (isset($_POST['max_value'])) {
    $_SESSION['max_value'] = intval($_POST['max_value']);
}

// Обробка натискання знаків операцій
if (isset($_POST['sign'])) {
    $_SESSION['sign'] = $_POST['sign'];
}

// Обробка натискання клавіатури або генерації нового прикладу
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'generate') {
        // Генерація нових операндів
        $flag = ($_SESSION['sign'] == '-') ? 1 : (($_SESSION['sign'] == '*') ? 2 : 0);
        
        $_SESSION['operand1'] = rand(0, $_SESSION['max_value'] - 1);
        
        if ($flag == 0) { // Додавання
            $_SESSION['operand2'] = rand(0, $_SESSION['max_value'] - $_SESSION['operand1'] - 1);
        } elseif ($flag == 1) { // Віднімання
            $_SESSION['operand2'] = rand(0, $_SESSION['operand1']);
        } else { // Множення
            $_SESSION['operand2'] = rand(0, $_SESSION['max_value'] / 2);
        }
        
        $_SESSION['input'] = '';
        $_SESSION['result'] = '???';
    } elseif ($_POST['action'] == 'input') {
        if (isset($_POST['digit']) && $_POST['digit'] != '10') {
            // Додаємо цифру до введення
            $_SESSION['input'] .= $_POST['digit'];
        } elseif (isset($_POST['digit']) && $_POST['digit'] == '10') {
            // Перевіряємо відповідь
            $correct = 0;
            $flag = ($_SESSION['sign'] == '-') ? 1 : (($_SESSION['sign'] == '*') ? 2 : 0);
            
            if ($flag == 0) {
                $correct = $_SESSION['operand1'] + $_SESSION['operand2'];
            } elseif ($flag == 1) {
                $correct = $_SESSION['operand1'] - $_SESSION['operand2'];
            } else {
                $correct = $_SESSION['operand1'] * $_SESSION['operand2'];
            }
            
            if (intval($_SESSION['input']) == $correct) {
                $_SESSION['result'] = "Вірно!";
            } else {
                $_SESSION['result'] = "Спробуй ще!";
                $_SESSION['input'] = "";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Перевірка усного рахунку</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <h1 class="center">Математичний тест</h1>
    <hr />

    <!-- Панель вибору діапазону -->
    <form method="post" action="">
        <table class="center">
            <tr>
                <td><button type="submit" name="max_value" value="10">0-10</button></td>
                <td><button type="submit" name="max_value" value="20">0-20</button></td>
                <td><button type="submit" name="max_value" value="100">0-100</button></td>
                <td><button type="submit" name="max_value" value="39">0-39</button></td>
            </tr>
        </table>
    </form>

    <hr />

    <!-- Операції -->
    <form method="post" action="">
        <table class="center">
            <tr>
                <td><button type="submit" name="sign" value="+">+</button></td>
                <td><button type="submit" name="sign" value="-">-</button></td>
                <td><button type="submit" name="sign" value="*">*</button></td>
            </tr>
        </table>
    </form>

    <hr />

    <!-- Арифметична операція та генерація прикладу -->
    <table class="center">
        <tr>
            <td><input id="op1" size="3" value="<?php echo $_SESSION['operand1']; ?>" readonly></td>
            <td><input id="s_sign" size="1" value="<?php echo $_SESSION['sign']; ?>" readonly></td>
            <td><input id="op2" size="3" value="<?php echo $_SESSION['operand2']; ?>" readonly></td>
            <td>=</td>
            <td><input id="result" size="4" value="<?php echo $_SESSION['input']; ?>" readonly></td>
            <td>
                <form method="post" action="">
                    <button type="submit" name="action" value="generate">?</button>
                </form>
            </td>
            <td><input id="r0" value="<?php echo $_SESSION['result']; ?>" readonly></td>
        </tr>
    </table>

    <hr />
    
    <!-- Клавіатура -->
    <table id="keyboard">
        <tr>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b1" name="digit" value="1">1</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b2" name="digit" value="2">2</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b3" name="digit" value="3">3</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b4" name="digit" value="4">4</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b5" name="digit" value="5">5</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b6" name="digit" value="6">6</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b7" name="digit" value="7">7</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b8" name="digit" value="8">8</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b9" name="digit" value="9">9</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form method="post" action="">
                    <button type="submit" id="b0" name="digit" value="0">0</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
            <td colspan="2">
                <form method="post" action="">
                    <button type="submit" id="bs" name="digit" value="10">OK</button>
                    <input type="hidden" name="action" value="input">
                </form>
            </td>
        </tr>
    </table>

    <hr />
</body>
</html>