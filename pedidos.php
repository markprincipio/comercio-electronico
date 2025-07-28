<?php
// pedidos.php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Agregar pedido si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_POST['cliente'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO pedidos (cliente, producto, cantidad, fecha) 
            VALUES ('$cliente', '$producto', $cantidad, NOW())";

    if ($conexion->query($sql) === TRUE) {
        echo "<p>✅ Pedido registrado exitosamente.</p>";
    } else {
        echo "<p>❌ Error al registrar el pedido: " . $conexion->error . "</p>";
    }
}

// Obtener lista de pedidos
$resultado = $conexion->query("SELECT * FROM pedidos ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos</title>
</head>
<body>
    <h2>Registrar nuevo pedido</h2>
    <form method="post" action="">
        Cliente: <input type="text" name="cliente" required><br>
        Producto: <input type="text" name="producto" required><br>
        Cantidad: <input type="number" name="cantidad" min="1" required><br>
        <input type="submit" value="Registrar Pedido">
    </form>

    <h2>📋 Lista de pedidos</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Cliente</th><th>Producto</th><th>Cantidad</th><th>Fecha</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= htmlspecialchars($fila['cliente']) ?></td>
            <td><?= htmlspecialchars($fila['producto']) ?></td>
            <td><?= $fila['cantidad'] ?></td>
            <td><?= $fila['fecha'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
$conexion->close();
?>
