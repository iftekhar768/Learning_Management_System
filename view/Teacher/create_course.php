<?php
session_start();

// Get teacher info from session

require_once("../../model/teacherModel.php");
$teacherId = getTeacherIdByUserId($_SESSION['user_id']);

// Handle lesson creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addLesson"])) {
    header('Content-Type: application/json');
    
    if (empty($_POST["course_id"]) || empty($_POST["lesson_title"])) {
        echo json_encode([
            'success' => false,
            'message' => 'Course ID and lesson title are required'
        ]);
        exit();
    }

    $lessonData = [
        "course_id"       => intval($_POST["course_id"]),
        "lesson_title"    => trim($_POST["lesson_title"]),
        "lesson_content"  => trim($_POST["lesson_content"]),
        "lesson_order"    => intval($_POST["lesson_order"])
    ];

    $result = addLesson($lessonData);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Lesson added successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add lesson'
        ]);
    }
    exit();
}

// Handle material upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploadMaterial"])) {
    header('Content-Type: application/json');
    
    if (empty($_POST["course_id"]) || empty($_FILES["material_file"]["name"])) {
        echo json_encode([
            'success' => false,
            'message' => 'Course ID and file are required'
        ]);
        exit();
    }

    $courseId = intval($_POST["course_id"]);
    $materialTitle = trim($_POST["material_title"]);
    
    // Handle file upload
    $targetDir = "../../uploads/materials/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = time() . "_" . basename($_FILES["material_file"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Allow certain file formats
    $allowedTypes = array("pdf", "doc", "docx", "ppt", "pptx", "txt", "zip", "rar");
    
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode([
            'success' => false,
            'message' => 'Only PDF, DOC, DOCX, PPT, PPTX, TXT, ZIP, RAR files are allowed'
        ]);
        exit();
    }
    
    // Check file size (10MB max)
    if ($_FILES["material_file"]["size"] > 10485760) {
        echo json_encode([
            'success' => false,
            'message' => 'File size must be less than 10MB'
        ]);
        exit();
    }
    
    if (move_uploaded_file($_FILES["material_file"]["tmp_name"], $targetFile)) {
        $materialData = [
            "course_id"      => $courseId,
            "material_title" => $materialTitle ?: $_FILES["material_file"]["name"],
            "file_path"      => $fileName,
            "file_type"      => $fileType
        ];
        
        $result = addCourseMaterial($materialData);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Material uploaded successfully!'
            ]);
        } else {
            unlink($targetFile); // Delete file if database insert fails
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save material'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload file'
        ]);
    }
    exit();
}

// Get teacher's courses for the dropdown
$teacherCourses = getTeacherCourses($teacherId);

// Get lessons and materials for display
$courseLessons = [];
$courseMaterials = [];
if (!empty($teacherCourses)) {
    foreach ($teacherCourses as $course) {
        $courseLessons[$course['course_id']] = getCourseLessons($course['course_id']);
        $courseMaterials[$course['course_id']] = getCourseMaterials($course['course_id']);
    }
}
?>

<link rel="stylesheet" href="../../assets/css/teacher/create_course.css">

<div class="create-course-container">
    <h1>Manage Course Content</h1>
    <p class="page-description">Add lessons and upload materials for your courses.</p>

    <!-- Message Alert -->
    <div id="messageAlert" class="message" style="display: none;"></div>

    <!-- Add Lessons Section -->
    <div class="section-card">
        <h2>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            Add Lesson
        </h2>

        <form id="addLessonForm" class="form-grid">
            <div class="form-group full-width">
                <label for="lesson_course_id">Select Course *</label>
                <select id="lesson_course_id" name="course_id" required>
                    <option value="">-- Select a Course --</option>
                    <?php foreach ($teacherCourses as $course): ?>
                        <option value="<?php echo $course['course_id']; ?>">
                            <?php echo htmlspecialchars($course['course_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="lesson_title">Lesson Title *</label>
                <input type="text" id="lesson_title" name="lesson_title" placeholder="e.g., Introduction to HTML" required>
            </div>

            <div class="form-group">
                <label for="lesson_order">Lesson Order *</label>
                <input type="number" id="lesson_order" name="lesson_order" value="1" min="1" required>
            </div>

            <div class="form-group full-width">
                <label for="lesson_content">Lesson Content</label>
                <textarea id="lesson_content" name="lesson_content" rows="6" placeholder="Write your lesson content here..."></textarea>
            </div>

            <button type="submit" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Lesson
            </button>
        </form>
    </div>

    <!-- Upload Materials Section -->
    <div class="section-card">
        <h2>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            Upload Course Material
        </h2>

        <form id="uploadMaterialForm" class="form-grid" enctype="multipart/form-data">
            <div class="form-group full-width">
                <label for="material_course_id">Select Course *</label>
                <select id="material_course_id" name="course_id" required>
                    <option value="">-- Select a Course --</option>
                    <?php foreach ($teacherCourses as $course): ?>
                        <option value="<?php echo $course['course_id']; ?>">
                            <?php echo htmlspecialchars($course['course_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label for="material_title">Material Title</label>
                <input type="text" id="material_title" name="material_title" placeholder="e.g., Week 1 Slides">
            </div>

            <div class="form-group full-width">
                <label for="material_file">Upload File * (PDF, DOC, DOCX, PPT, PPTX, TXT, ZIP, RAR - Max 10MB)</label>
                <div class="file-upload-wrapper">
                    <input type="file" id="material_file" name="material_file" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.zip,.rar" required>
                    <span class="file-name">No file chosen</span>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                Upload Material
            </button>
        </form>
    </div>

    <!-- Display Existing Content -->
    <div class="content-display-section">
        <?php foreach ($teacherCourses as $course): ?>
            <div class="course-content-card">
                <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                
                <!-- Lessons -->
                <div class="content-section">
                    <h4>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                        Lessons
                    </h4>
                    <?php if (!empty($courseLessons[$course['course_id']])): ?>
                        <ul class="content-list">
                            <?php foreach ($courseLessons[$course['course_id']] as $lesson): ?>
                                <li>
                                    <span class="lesson-order"><?php echo $lesson['lesson_order']; ?>.</span>
                                    <span class="lesson-title"><?php echo htmlspecialchars($lesson['lesson_title']); ?></span>
                                    <button class="btn-delete-small" data-type="lesson" data-id="<?php echo $lesson['lesson_id']; ?>">Delete</button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="no-content">No lessons added yet.</p>
                    <?php endif; ?>
                </div>

                <!-- Materials -->
                <div class="content-section">
                    <h4>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                        Materials
                    </h4>
                    <?php if (!empty($courseMaterials[$course['course_id']])): ?>
                        <ul class="content-list">
                            <?php foreach ($courseMaterials[$course['course_id']] as $material): ?>
                                <li>
                                    <span class="material-icon"><?php echo strtoupper($material['file_type']); ?></span>
                                    <span class="material-title"><?php echo htmlspecialchars($material['material_title']); ?></span>
                                    <a href="../../uploads/materials/<?php echo $material['file_path']; ?>" download class="btn-download-small">Download</a>
                                    <button class="btn-delete-small" data-type="material" data-id="<?php echo $material['material_id']; ?>">Delete</button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="no-content">No materials uploaded yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($teacherCourses)): ?>
            <p class="no-courses">You don't have any courses assigned yet. Contact admin to assign courses.</p>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageAlert = document.getElementById('messageAlert');
    const addLessonForm = document.getElementById('addLessonForm');
    const uploadMaterialForm = document.getElementById('uploadMaterialForm');
    const materialFile = document.getElementById('material_file');

    // File input display
    materialFile.addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        document.querySelector('.file-name').textContent = fileName;
    });

    // Add Lesson
    addLessonForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(addLessonForm);
        formData.append('addLesson', 'addLesson');

        fetch('create_course.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            showMessage(data.message, data.success ? 'success' : 'error');
            if (data.success) {
                addLessonForm.reset();
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred. Please try again.', 'error');
        });
    });

    // Upload Material
    uploadMaterialForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(uploadMaterialForm);
        formData.append('uploadMaterial', 'uploadMaterial');

        fetch('create_course.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            showMessage(data.message, data.success ? 'success' : 'error');
            if (data.success) {
                uploadMaterialForm.reset();
                document.querySelector('.file-name').textContent = 'No file chosen';
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred. Please try again.', 'error');
        });
    });

    // Delete functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-delete-small')) {
            const type = e.target.dataset.type;
            const id = e.target.dataset.id;
            
            if (confirm(`Are you sure you want to delete this ${type}?`)) {
                const formData = new FormData();
                formData.append('delete' + type.charAt(0).toUpperCase() + type.slice(1), 'delete');
                formData.append(type + '_id', id);

                fetch('create_course.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    showMessage(data.message, data.success ? 'success' : 'error');
                    if (data.success) {
                        setTimeout(() => location.reload(), 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('An error occurred. Please try again.', 'error');
                });
            }
        }
    });

    function showMessage(message, type) {
        messageAlert.textContent = message;
        messageAlert.className = 'message ' + type;
        messageAlert.style.display = 'block';
        
        setTimeout(() => {
            messageAlert.style.display = 'none';
        }, 5000);
    }
});
</script>