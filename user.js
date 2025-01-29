document.addEventListener('DOMContentLoaded', () => {
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
                `;
                bookTable.appendChild(row);
            });
        });
});

// Logout function
function logout() {
    // Implement logout logic (e.g., clear session and redirect)
    console.log("function invoked");
    
    alert('Logging out...');
   window.location.href="login.php"
  
}
