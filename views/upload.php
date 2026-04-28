<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Reader</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1>File Reader</h1>

        <?php if (!empty($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="card">
            <form method="POST" enctype="multipart/form-data">
                <input
                    class="file-input"
                    id="file-input"
                    type="file"
                    name="file"
                    accept="<?= implode(',', array_map(fn($e) => ".$e", $supported)) ?>"
                >
                <label class="upload-label" for="file-input" id="upload-label">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                    <span class="hint">Click to choose a file or drag and drop</span>
                    <span class="accepted-file-formats"><?= implode(' · ', array_map('strtoupper', $supported)) ?></span>
                    <span class="file-name" id="file-name" hidden></span>
                </label>
                <div class="form-footer">
                    <button class="btn btn-primary" type="submit">Upload</button>
                </div>
            </form>
        </div>

        <?php if (!empty($rows)): ?>
            <div class="card">
                <div class="table-wrapper">
                    <table>
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
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="/js/upload.js" defer></script>
</body>
</html>
