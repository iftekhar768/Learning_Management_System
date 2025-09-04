

(function(){
    
    function $(id){ return document.getElementById(id) || null; }
    function qAll(sel){ return Array.from(document.querySelectorAll(sel)); }


    function escapeHtml(s){
        return String(s === null || s === undefined ? '' : s)
            .replace(/[&<>"']/g, function(c){
                return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
            });
    }

    const monthYear = $('month-year');
    const daysContainer = $('calendar-days');
    let date = new Date();

    function renderCalendar() {
        if (!daysContainer || !monthYear) return;
        daysContainer.innerHTML = '';
        let year = date.getFullYear();
        let month = date.getMonth();
        const today = new Date();

        monthYear.textContent = date.toLocaleString("default", { month: "long", year: "numeric" });

        let firstDay = new Date(year, month, 1).getDay();
        let lastDate = new Date(year, month + 1, 0).getDate();

        const weekdays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        weekdays.forEach(day => daysContainer.innerHTML += `<div class="weekday"><strong>${escapeHtml(day)}</strong></div>`);

        for (let i = 0; i < firstDay; i++) daysContainer.innerHTML += `<div></div>`;

        for (let day = 1; day <= lastDate; day++) {
            let isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
            let dayClass = isToday ? 'day today' : 'day';
            daysContainer.innerHTML += `<div class="${dayClass}">${day}</div>`;
        }

        const dayEls = qAll('.day');
        dayEls.forEach(d => {
            d.addEventListener('click', () => {
                dayEls.forEach(el => el.classList.remove('selected'));
                if (!d.classList.contains('today')) d.classList.add('selected');
            });
        });
    }

   
    const prevBtn = $('prev'), nextBtn = $('next');
    if (prevBtn) prevBtn.addEventListener('click', () => { date.setMonth(date.getMonth() - 1); renderCalendar(); });
    if (nextBtn) nextBtn.addEventListener('click', () => { date.setMonth(date.getMonth() + 1); renderCalendar(); });


    function loadCoursesIntoSelect(deptId, targetSelectId) {
        const courseSelect = $(targetSelectId);
        if (!courseSelect) return;
        if (!deptId) {
            courseSelect.innerHTML = '<option value="">First select a department</option>';
            return;
        }
        courseSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`get_courses.php?dept_id=${encodeURIComponent(deptId)}`)
            .then(resp => {
                if (!resp.ok) throw new Error('Network response not ok');
                return resp.json();
            })
            .then(data => {
                courseSelect.innerHTML = '<option value="">Select Course</option>';
                if (!Array.isArray(data) || data.length === 0) {
                    courseSelect.innerHTML += '<option value="">No courses available</option>';
                    return;
                }
                data.forEach(course => {
                    const id = escapeHtml(course.course_id);
                    const name = escapeHtml(course.course_name || '');
                    const code = escapeHtml(course.course_code || '');
                    courseSelect.innerHTML += `<option value="${id}">${name}${code ? ' (' + code + ')' : ''}</option>`;
                });
            })
            .catch(err => {
                console.error('Error loading courses:', err);
                courseSelect.innerHTML = '<option value="">Error loading courses</option>';
            });
    }

    function showDepartmentCourses(deptId, tabButton) {
        const courseDisplay = $('course-display');
        if (!courseDisplay) return;
        courseDisplay.innerHTML = '<p>Loading courses...</p>';

  
        qAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        if (tabButton) tabButton.classList.add('active');

        fetch(`get_department_courses.php?dept_id=${encodeURIComponent(deptId)}`)
            .then(resp => {
                if (!resp.ok) throw new Error('Network response not ok');
                return resp.text();
            })
            .then(html => {
                courseDisplay.innerHTML = html;
        
                loadCoursesIntoSelect(deptId, 'course_select_assign');
            })
            .catch(err => {
                console.error('Error loading department courses:', err);
                courseDisplay.innerHTML = '<p>Error loading courses. Please try again.</p>';
            });
    }

    function refreshCourseList() {
        const activeTab = document.querySelector('.tab-btn.active');
        if (activeTab) {
            const deptId = activeTab.getAttribute('data-dept');
            if (deptId) showDepartmentCourses(parseInt(deptId, 10), activeTab);
        }
    }


    function validateCourseForm() {
        const form = document.querySelector('.course-form');
        if (!form) return true;
        const courseName = form.querySelector('#course_name').value.trim();
        const deptId = form.querySelector('#dept_select_for_course').value;
        if (!courseName) { alert('Please enter a course name'); return false; }
        if (!deptId) { alert('Please select a department'); return false; }
        return true;
    }
    function validateAssignmentForm() {
        const form = document.querySelector('.assign-form');
        if (!form) return true;
        const teacherId = form.querySelector('#teacher_select').value;
        const courseId = form.querySelector('#course_select_assign').value;
        if (!teacherId) { alert('Please select a teacher'); return false; }
        if (!courseId) { alert('Please select a course'); return false; }
        return true;
    }

   
    function hideMessages() {
        qAll('.success-msg, .error-msg').forEach(msg => {
            setTimeout(() => {
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 300);
            }, 5000);
        });
    }


    function searchCourses() {
        const searchInput = $('course-search');
        const courseItems = qAll('.course-item');
        if (!searchInput) return;
        const searchTerm = searchInput.value.toLowerCase();
        courseItems.forEach(item => {
            const h4 = item.querySelector('h4');
            const p = item.querySelector('p');
            const courseName = h4 ? h4.textContent.toLowerCase() : '';
            const description = p ? p.textContent.toLowerCase() : '';
            item.style.display = (courseName.includes(searchTerm) || description.includes(searchTerm)) ? 'flex' : 'none';
        });
    }

 
    function attachFormSubmitUX() {
        const courseForm = document.getElementById('course-form');
        if (courseForm) {
            courseForm.addEventListener('submit', function(e){
                if (!validateCourseForm()) { e.preventDefault(); return; }
                const btn = courseForm.querySelector('button[type="submit"]');
                if (btn) {
                    btn.dataset.orig = btn.textContent;
                    btn.textContent = 'Processing...';
                    btn.disabled = true;
                   
                }
            });
        }

        const assignForm = document.getElementById('assign-form');
        if (assignForm) {
            assignForm.addEventListener('submit', function(e){
                if (!validateAssignmentForm()) { e.preventDefault(); return; }
                const btn = assignForm.querySelector('button[type="submit"]');
                if (btn) {
                    btn.dataset.orig = btn.textContent;
                    btn.textContent = 'Processing...';
                    btn.disabled = true;
                }
            });
        }
    }


    document.addEventListener('DOMContentLoaded', function(){
        renderCalendar();

   
        qAll('.tab-btn').forEach((btn, idx) => {
            btn.addEventListener('click', function(){
                const deptId = btn.getAttribute('data-dept');
                if (!deptId) return;
                showDepartmentCourses(deptId, btn);
            });

            if (idx === 0) {
                btn.classList.add('active');
                const deptId = btn.getAttribute('data-dept');
                if (deptId) showDepartmentCourses(deptId, btn);
            }
        });

        attachFormSubmitUX();
        hideMessages();

        const searchInput = $('course-search');
        if (searchInput) {
            searchInput.addEventListener('input', searchCourses);
        }
    });

 
    window.refreshCourseList = refreshCourseList;
    window.loadCoursesIntoSelect = loadCoursesIntoSelect;

})();
