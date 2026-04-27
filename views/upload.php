<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Reader</title>
</head>
<body>
    <h1>Upload a file</h1>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept="<?= implode(',', array_map(fn($e) => ".$e", $supported)) ?>">
        <button type="submit">Upload</button>
    </form>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($rows)): ?>
        <table border="1">
            <thead>
                <tr>
                    <?php foreach (array_keys($rows[0]) as $column): ?>
                        <th><?= htmlspecialchars($column) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?= htmlspecialchars(is_scalar($cell) || $cell === null ? (string) $cell : json_encode($cell)) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
