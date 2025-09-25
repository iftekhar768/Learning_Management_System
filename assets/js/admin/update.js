let originalValues = {};

        function editRow(userId) {
            const row = document.getElementById('row_' + userId);
            const nameCell = row.querySelector('.name');
            const roleCell = row.querySelector('.role');
            const emailCell = row.querySelector('.email');

            // Store original values
            originalValues[userId] = {
                name: nameCell.textContent.trim(),
                role: roleCell.textContent.trim(),
                email: emailCell.textContent.trim()
            };

            // Replace text with input fields
            nameCell.innerHTML = `<input type="text" class="edit-input" value="${originalValues[userId].name}">`;
            
            roleCell.innerHTML = `<select class="edit-select">
                <option value="student" ${originalValues[userId].role === 'student' ? 'selected' : ''}>Student</option>
                <option value="teacher" ${originalValues[userId].role === 'teacher' ? 'selected' : ''}>Teacher</option>
            </select>`;
            
            emailCell.innerHTML = `<input type="email" class="edit-input" value="${originalValues[userId].email}">`;

            // Toggle buttons
            row.querySelector('.edit-btn').style.display = 'none';
            row.querySelector('.save-btn').style.display = 'inline-block';
            row.querySelector('.cancel-btn').style.display = 'inline-block';

            // Add edit mode styling
            row.classList.add('edit-mode');
        }

        function saveRow(userId) {
            const row = document.getElementById('row_' + userId);
            const nameInput = row.querySelector('.name input');
            const roleSelect = row.querySelector('.role select');
            const emailInput = row.querySelector('.email input');

            // Validate inputs
            if (!nameInput.value.trim() || !emailInput.value.trim()) {
                alert('Name and Email cannot be empty!');
                return;
            }

            if (!isValidEmail(emailInput.value)) {
                alert('Please enter a valid email address!');
                return;
            }

            // Update hidden form values
            document.getElementById('updateUserId').value = userId;
            document.getElementById('updateUsername').value = nameInput.value.trim();
            document.getElementById('updateRole').value = roleSelect.value;
            document.getElementById('updateEmail').value = emailInput.value.trim();

            // Submit the form
            document.getElementById('updateForm').submit();
        }

        function cancelEdit(userId) {
            const row = document.getElementById('row_' + userId);
            const nameCell = row.querySelector('.name');
            const roleCell = row.querySelector('.role');
            const emailCell = row.querySelector('.email');

            // Restore original values
            nameCell.textContent = originalValues[userId].name;
            roleCell.textContent = originalValues[userId].role;
            emailCell.textContent = originalValues[userId].email;

            // Toggle buttons
            row.querySelector('.edit-btn').style.display = 'inline-block';
            row.querySelector('.save-btn').style.display = 'none';
            row.querySelector('.cancel-btn').style.display = 'none';

            // Remove edit mode styling
            row.classList.remove('edit-mode');

            // Clear stored values
            delete originalValues[userId];
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }