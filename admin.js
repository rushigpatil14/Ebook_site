document.addEventListener('DOMContentLoaded', () => {
    const uploadForm = document.getElementById('uploadForm');
    const bookTable = document.getElementById('bookTable').querySelector('tbody');

    // Fetch and display books
    fetch('fetch_books.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(book => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${book.title}</td>
                    <td>${book.author}</td>
                    <td><a href="${book.file_path}" download>Download</a></td>
                    <td><button class="delete-btn" onclick="deleteBook(${book.id})">Delete</button></td>
                `;
                bookTable.appendChild(row);
            });
        });

    // Handle book upload
    uploadForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(uploadForm);
        fetch('upload_book.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    });
});

// Delete a book
function deleteBook(id) {
    if (confirm('Are you sure you want to delete this book?')) {
        fetch(`delete_book.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}
