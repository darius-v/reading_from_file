(() => {
    const dragDropArea = document.getElementById('upload-label');

    // dragover/dragleave only control visual highlight
    dragDropArea.addEventListener('dragover', (e) => {
        e.preventDefault(); // without this, the browser opens the file directly instead of firing the drop event
        dragDropArea.style.borderColor = '#6366f1';
        dragDropArea.style.background = '#f5f3ff';
    });

    dragDropArea.addEventListener('dragleave', () => {
        dragDropArea.style.borderColor = '';
        dragDropArea.style.background = '';
    });

    {
        const fileInput = document.getElementById('file-input');
        const fileNameEl = document.getElementById('file-name');

        function showFileName(el, name) {
            el.textContent = name;
            el.hidden = false;
        }

        // change fired when user clicks on drag drop area and selects file
        fileInput.addEventListener('change', () => {
            showFileName(fileNameEl, fileInput.files[0].name);
        });

        dragDropArea.addEventListener('drop', (e) => {
            e.preventDefault(); // without this, the browser opens the file directly instead of firing the drop event
            dragDropArea.style.borderColor = '';
            dragDropArea.style.background = '';
            const file = e.dataTransfer.files[0];
            if (file) { // file might be undefined if user drops selected text, for example.
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                showFileName(fileNameEl, file.name);
            }
        });
    }
})();
