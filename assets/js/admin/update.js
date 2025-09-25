let originalValues = {};

        function editRow(userId) {
            const row = document.getElementById('row_' + userId);
            const nameCell = row.querySelector('.name');
            const roleCell = row.querySelector('.role');
            const emailCell = row.querySelector('.email');

          
            originalValues[userId] = {
                name: nameCell.textContent.trim(),
                role: roleCell.textContent.trim(),
                email: emailCell.textContent.trim()
            };

            nameCell.innerHTML = `<input type="text" class="edit-input" value="${originalValues[userId].name}">`;
            
            roleCell.innerHTML = `<select class="edit-select">
                <option value="student" ${originalValues[userId].role === 'student' ? 'selected' : ''}>Student</option>
                <option value="teacher" ${originalValues[userId].role === 'teacher' ? 'selected' : ''}>Teacher</option>
            </select>`;
            
            emailCell.innerHTML = `<input type="email" class="edit-input" value="${originalValues[userId].email}">`;

           
            row.querySelector('.edit-btn').style.display = 'none';
            row.querySelector('.save-btn').style.display = 'inline-block';
            row.querySelector('.cancel-btn').style.display = 'inline-block';

           
            row.classList.add('edit-mode');
        }

        function saveRow(userId) {
            const row = document.getElementById('row_' + userId);
            const nameInput = row.querySelector('.name input');
            const roleSelect = row.querySelector('.role select');
            const emailInput = row.querySelector('.email input');

           
            if (!nameInput.value.trim() || !emailInput.value.trim()) {
                alert('Name and Email cannot be empty!');
                return;
            }

            if (!isValidEmail(emailInput.value)) {
                alert('Please enter a valid email address!');
                return;
            }

        
            document.getElementById('updateUserId').value = userId;
            document.getElementById('updateUsername').value = nameInput.value.trim();
            document.getElementById('updateRole').value = roleSelect.value;
            document.getElementById('updateEmail').value = emailInput.value.trim();

         
            document.getElementById('updateForm').submit();
        }

        function cancelEdit(userId) {
            const row = document.getElementById('row_' + userId);
            const nameCell = row.querySelector('.name');
            const roleCell = row.querySelector('.role');
            const emailCell = row.querySelector('.email');

 
            nameCell.textContent = originalValues[userId].name;
            roleCell.textContent = originalValues[userId].role;
            emailCell.textContent = originalValues[userId].email;

            
            row.querySelector('.edit-btn').style.display = 'inline-block';
            row.querySelector('.save-btn').style.display = 'none';
            row.querySelector('.cancel-btn').style.display = 'none';

            
            row.classList.remove('edit-mode');

         
            delete originalValues[userId];
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }