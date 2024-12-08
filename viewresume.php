<?php
require './assets/class/functions.class.php';
require './assets/class/db.class.php';

// Sanitize and fetch resume
$slug = $database->real_escape_string($_GET['resume'] ?? '');
$resumeQuery = $database->query("SELECT * FROM resumes WHERE slug='$slug'");
$resumes = $resumeQuery->fetch_assoc();

if (!$resumes) {
    $fn->redirect('myresumes.php');
}

// Fetch related data
$exps = $database->query("SELECT * FROM experience WHERE resume_id=" . (int)$resumes['id'])->fetch_all(MYSQLI_ASSOC);
$edus = $database->query("SELECT * FROM educations WHERE resume_id=" . (int)$resumes['id'])->fetch_all(MYSQLI_ASSOC);
$skills = $database->query("SELECT * FROM skills WHERE resume_id=" . (int)$resumes['id'])->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="icon" href="./assets/images/logo.png">
    <title><?= htmlspecialchars($resumes['full_name']) ?> | <?= htmlspecialchars($resumes['resume_title']) ?></title>
    <style>
        body {
            background: radial-gradient(circle, rgba(249, 249, 249, 1) 0%, rgba(240, 232, 127, 1) 49%, rgba(246, 243, 132, 1) 100%);
            font-family: 'Poppins', sans-serif;
        }
        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 0.5cm;
            margin: auto;
            border: 1px solid #D3D3D3;
            background: white;
        }
        @media print {
            .page {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="extra w-100 p-3 py-2 bg-dark text-center">
        <button id="download" class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </button>
    </div>

    <div class="page">
        <div class="subpage">
            <table class="w-100">
                <tbody>
                    <!-- Resume Header -->
                    <tr>
                        <td colspan="2" class="text-center fw-bold fs-4">Resume</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="fw-bold"><?= htmlspecialchars($resumes['full_name']) ?></div>
                            <div>Mobile: +91-<?= htmlspecialchars($resumes['mobile_no']) ?></div>
                            <div>Email: <?= htmlspecialchars($resumes['email']) ?></div>
                            <div>Address: <?= htmlspecialchars($resumes['address']) ?></div>
                            <hr>
                        </td>
                    </tr>

                    <!-- Objective Section -->
                    <tr>
                        <td class="fw-bold text-nowrap">Objective</td>
                        <td><?= htmlspecialchars($resumes['objective']) ?></td>
                    </tr>

                    <!-- Experience Section -->
                    <tr>
                        <td class="fw-bold text-nowrap">Experience</td>
                        <td>
                            <?php foreach ($exps as $exp): ?>
                                <div>
                                    <div class="fw-bold">- <?= htmlspecialchars($exp['position']) ?></div>
                                    <div><?= htmlspecialchars($exp['company']) ?> (<?= htmlspecialchars($exp['started']) ?> - <?= htmlspecialchars($exp['ended']) ?>)</div>
                                    <div><?= htmlspecialchars($exp['job_desc']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>

                    <!-- Education Section -->
                    <tr>
                        <td class="fw-bold text-nowrap">Education</td>
                        <td>
                            <?php foreach ($edus as $edu): ?>
                                <div>
                                    <div class="fw-bold">- <?= htmlspecialchars($edu['course']) ?></div>
                                    <div><?= htmlspecialchars($edu['institute']) ?> (Completed: <?= htmlspecialchars($edu['ended']) ?>)</div>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>

                    <!-- Skills Section -->
                    <tr>
                        <td class="fw-bold text-nowrap">Skills</td>
                        <td>
                            <?php foreach ($skills as $skill): ?>
                                <div>- <?= htmlspecialchars($skill['skill']) ?></div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src = "https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>                                
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('download').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.html(document.querySelector('.page'), {
                callback: function (doc) {
                    doc.save('<?= htmlspecialchars($resumes['full_name']) ?>_<?= htmlspecialchars($resumes['resume_title']) ?>.pdf');
                },
                x: 0,
                y: 0,
                width: 190,
                windowWidth: 800
            });
        });
    </script>
</body>
</html>
