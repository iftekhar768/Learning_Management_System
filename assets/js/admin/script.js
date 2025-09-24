document.addEventListener("DOMContentLoaded", () => {
    const content = document.getElementById("content");

 
    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            const page = this.getAttribute("data-page");

            fetch(page)
                .then(res => res.text())
                .then(data => {
                    content.innerHTML = data;
                })
                .catch(err => console.error("Error loading page:", err));
        });
    });
});
