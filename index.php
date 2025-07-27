<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Comercio Electrónico</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<header>
    <h1>Tienda de Comercio Electrónico</h1>
</header>

<main>
    <h2>Agregar Producto</h2>
    <form method="post">
        <input type="text" name="nombre_producto" placeholder="Nombre" required>
        <textarea name="descripcion" placeholder="Descripción del producto"></textarea>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <input type="submit" name="guardar_producto" value="Guardar Producto">
    </form>

    <h2>Agregar Cliente</h2>
    <form method="post">
        <input type="text" name="nombre_cliente" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="direccion" placeholder="Dirección"></textarea>
        <input type="submit" name="guardar_cliente" value="Guardar Cliente">
    </form>

    <h2>Registrar Compra</h2>
    <form method="post">
        <input type="number" name="id_cliente" placeholder="ID Cliente" required>
        <input type="number" name="id_producto" placeholder="ID Producto" required>
        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <input type="submit" name="registrar_compra" value="Registrar Compra">
    </form>

    <?php
    if (isset($_POST['guardar_producto'])) {
        $sql = "INSERT INTO PRODUCTO (nombre, descripcion, precio, stock)
                VALUES ('{$_POST['nombre_producto']}', '{$_POST['descripcion']}', {$_POST['precio']}, {$_POST['stock']})";
        $conn->query($sql);
    }

    if (isset($_POST['guardar_cliente'])) {
        $sql = "INSERT INTO CLIENTE (nombre, email, direccion)
                VALUES ('{$_POST['nombre_cliente']}', '{$_POST['email']}', '{$_POST['direccion']}')";
        $conn->query($sql);
    }

    if (isset($_POST['registrar_compra'])) {
        $cantidad = $_POST['cantidad'];
        $id_producto = $_POST['id_producto'];
        $precio = $conn->query("SELECT precio FROM PRODUCTO WHERE id_producto = $id_producto")->fetch_assoc()['precio'];
        $total = $precio * $cantidad;
        $sql = "INSERT INTO COMPRA (cantidad, total, id_producto, id_cliente)
                VALUES ($cantidad, $total, $id_producto, {$_POST['id_cliente']})";
        $conn->query($sql);
    }

    echo "<h2>Productos</h2>";
    $res = $conn->query("SELECT * FROM PRODUCTO");
    while ($row = $res->fetch_assoc()) {
        echo "<p class='centrado-texto'>ID: {$row['id_producto']} - {$row['nombre']} - \$ {$row['precio']} - Stock: {$row['stock']}</p>";
    }

    echo "<h2>Clientes</h2>";
    $res = $conn->query("SELECT * FROM CLIENTE");
    while ($row = $res->fetch_assoc()) {
        echo "<p class='centrado-texto'>ID: {$row['id_cliente']} - {$row['nombre']} - {$row['email']}</p>";
    }

    echo "<h2>Compras</h2>";
    $res = $conn->query("SELECT * FROM COMPRA");
    while ($row = $res->fetch_assoc()) {
        echo "<p class='centrado-texto'>ID Compra: {$row['id_compra']} - Cliente ID: {$row['id_cliente']} - Producto ID: {$row['id_producto']} - Total: \$ {$row['total']}</p>";
    }

    $conn->close();
    ?>
</main>

<footer>
    <p>&copy; 2025 Tienda de Comercio Electrónico</p>
</footer>
</body>
</html>
