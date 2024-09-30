<?php
$pageTitle = "Form";

session_start();

$modules = $_SESSION['modules'];
$pqe = $_SESSION['pqe'];
$phd = $_SESSION['phd'];
$duties = $_SESSION['duties'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submissions
    if (isset($_POST['add_module'])) {
        // Add module
        $newModule = ["name" => $_POST['module_name'], "units" => (int)$_POST['module_units']];
        $_SESSION['modules'][] = $newModule;
    } else if (isset($_POST['delete_module'])) {
        // Delete selected module
        $moduleIndex = $_POST['module_to_delete'];
        unset($_SESSION['modules'][$moduleIndex]);
        $_SESSION['modules'] = array_values($_SESSION['modules']); // Re-index the array
    } else if (isset($_POST['update_pqe'])) {
        // Update PQE
        $_SESSION['pqe'] = ["name" => $_POST['pqe_name'], "status" => $_POST['pqe_status'], "date" => $_POST['pqe_date']];
    } else if (isset($_POST['update_phd'])) {
        // Update PhD
        $_SESSION['phd'] = ["name" => $_POST['phd_name'], "status" => $_POST['phd_status'], "date" => $_POST['phd_date']];
    } else if (isset($_POST['update_duties'])) {
        // Update Duties
        $_SESSION['duties'] = [
            "teaching" => ["finished" => (int)$_POST['teaching_finished'], "total" => (int)$_POST['teaching_total']],
            "research" => ["finished" => (int)$_POST['research_finished'], "total" => (int)$_POST['research_total']],
            "other" => ["finished" => (int)$_POST['other_finished'], "total" => (int)$_POST['other_total']],
        ];
    }
    header("Location: form.php"); // Refresh the page to avoid resubmission
    exit;
}

include 'includes/header.php';
?>

<section style="width: 20%">
    <h1><?= $pageTitle ?></h1>
    <p>Form Inputs with Submission</p>
    
    <!-- Start of Form -->
    <!-- Module Management Form -->
    <h2>Manage Modules</h2>
    <form method="POST">
        <label for="module_name">Module Name:</label>
        <input type="text" name="module_name" required>
        <label for="module_units">Units:</label>
        <select name="module_units" required>
            <option value="4">4</option>
            <option value="8">8</option>
        </select>
        <button type="submit" name="add_module">Add Module</button>
    </form>

    <h3>Current Modules</h3>
    <ul>
        <?php foreach ($modules as $index => $module): ?>
            <li>
                <?= htmlspecialchars($module['name']) ?> - <?= $module['units'] ?> units
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="module_to_delete" value="<?= $index ?>">
                    <button type="submit" name="delete_module">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- PQE Update Form -->
    <h2>Update PQE</h2>
    <form method="POST">
        <label for="pqe_name">Name:</label>
        <input type="text" name="pqe_name" value="<?= htmlspecialchars($pqe['name']) ?>" required>
        <label for="pqe_status">Status:</label>
        <select name="pqe_status">
            <option value="Done" <?= $pqe['status'] == "Done" ? "selected" : "" ?>>Done</option>
            <option value="Due" <?= $pqe['status'] == "Due" ? "selected" : "" ?>>Due</option>
        </select>
        <label for="pqe_date">Date:</label>
        <input type="date" name="pqe_date" value="<?= date('Y-m-d', strtotime($pqe['date'])) ?>" required>
        <p>Current Date: <?= date('d F Y', strtotime($pqe['date'])) ?></p>
        <button type="submit" name="update_pqe">Update PQE</button>
    </form>

    <!-- PhD Defense Update Form -->
    <h2>Update PhD Defense</h2>
    <form method="POST">
        <label for="phd_name">Name:</label>
        <input type="text" name="phd_name" value="<?= htmlspecialchars($phd['name']) ?>" required>
        <label for="phd_status">Status:</label>
        <select name="phd_status">
            <option value="Done" <?= $phd['status'] == "Done" ? "selected" : "" ?>>Done</option>
            <option value="Due" <?= $phd['status'] == "Due" ? "selected" : "" ?>>Due</option>
        </select>
        <label for="phd_date">Date:</label>
        <input type="date" name="phd_date" value="<?= date('Y-m-d', strtotime($phd['date'])) ?>" required>
        <p>Current Date: <?= date('d F Y', strtotime($phd['date'])) ?></p>
        <button type="submit" name="update_phd">Update PhD Defense</button>
    </form>

    <!-- Duties Update Form -->
    <h2>Update Duties</h2>
    <form method="POST">
        <label for="teaching_finished">Teaching Duties Finished Hours:</label>
        <input type="number" name="teaching_finished" value="<?= $duties['teaching']['finished'] ?>" required>
        <label for="teaching_total">Teaching Duties Total Hours:</label>
        <input type="number" name="teaching_total" value="<?= $duties['teaching']['total'] ?>" required><br>

        <label for="research_finished">Research Duties Finished Hours:</label>
        <input type="number" name="research_finished" value="<?= $duties['research']['finished'] ?>" required>
        <label for="research_total">Research Duties Total Hours:</label>
        <input type="number" name="research_total" value="<?= $duties['research']['total'] ?>" required><br>

        <label for="other_finished">Other Duties Finished Hours:</label>
        <input type="number" name="other_finished" value="<?= $duties['other']['finished'] ?>" required>
        <label for="other_total">Other Duties Total Hours:</label>
        <input type="number" name="other_total" value="<?= $duties['other']['total'] ?>" required><br>

        <button type="submit" name="update_duties">Update Duties</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
