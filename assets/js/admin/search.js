document.addEventListener('DOMContentLoaded', function() {
    const teacherSearch = document.getElementById('teacherSearch');
    const teacherId = document.getElementById('teacher_id');
    const suggestions = document.getElementById('suggestions');

    let debounceTimer;

    teacherSearch.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const searchTerm = this.value.trim();

        if (searchTerm.length < 2) {
            suggestions.innerHTML = '';
            suggestions.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`../../controller/search_teacher.php?search=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    displaySuggestions(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }, 300);
    });

    function displaySuggestions(teachers) {
        if (teachers.length === 0) {
            suggestions.innerHTML = '<div class="suggestion-item">No teachers found</div>';
            suggestions.style.display = 'block';
            return;
        }

        suggestions.innerHTML = '';
        teachers.forEach(teacher => {
            const div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = `${teacher.name} (${teacher.email})`;
            div.addEventListener('click', function() {
                teacherSearch.value = teacher.name;
                teacherId.value = teacher.teacher_id;
                suggestions.innerHTML = '';
                suggestions.style.display = 'none';
            });
            suggestions.appendChild(div);
        });
        suggestions.style.display = 'block';
    }

    
    document.addEventListener('click', function(e) {
        if (!teacherSearch.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.style.display = 'none';
        }
    });
});