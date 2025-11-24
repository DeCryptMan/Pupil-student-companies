<?php
// hash_form.php
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {
    $password = $_POST['password'];
    $result = password_hash($password, PASSWORD_DEFAULT);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать password_hash()</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        form {
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            width: 350px;
            text-align: center;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-bottom: 15px;
            outline: none;
            font-size: 15px;
        }
        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 15px;
        }
        button:hover { background: #1d4ed8; }
        pre {
            margin-top: 20px;
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <form method="post" autocomplete="off">
        <h2>Создать password_hash()</h2>
        <input type="password" name="password" placeholder="Введите пароль" required>
        <button type="submit">Создать хеш</button>
        <?php if ($result): ?>
            <pre><?php echo htmlspecialchars($result, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></pre>
        <?php endif; ?>
    </form>
</body>
</html>
