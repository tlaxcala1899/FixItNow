<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Lista de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Rol</th>
        </tr>
        <?php foreach ($datos as $dato): ?>
        <tr>
            <td><?php echo $dato['ID_usuario']; ?></td>
            <td><?php echo $dato['nombre']; ?></td>
            <td><?php echo $dato['rol']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>