const fileInput = document.getElementById('file-input');
const label = document.getElementById('upload-label');
const fileNameEl = document.getElementById('file-name');

fileInput.addEventListener('change', () => {
    fileNameEl.textContent = fileInput.files[0].name;
    fileNameEl.hidden = false;
});

label.addEventListener('dragover', (e) => {
    e.preventDefault();
    label.style.borderColor = '#6366f1';
    label.style.background = '#f5f3ff';
});

label.addEventListener('dragleave', () => {
    label.style.borderColor = '';
    label.style.background = '';
});

label.addEventListener('drop', (e) => {
    e.preventDefault();
    label.style.borderColor = '';
    label.style.background = '';
    const file = e.dataTransfer.files[0];
    if (file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
        fileNameEl.textContent = file.name;
        fileNameEl.hidden = false;
    }
});
