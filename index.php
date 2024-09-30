<?php
$pageTitle = "Home Page";

session_start();

// Initialize default values if not already set
if (!isset($_SESSION['modules'])) {
    $_SESSION['modules'] = [
        ["name" => "AR5652 PhD Seminar", "units" => 4],
        ["name" => "AR5657 R-Programming", "units" => 4],
        ["name" => "AR5652 PhD Seminar", "units" => 4],
        ["name" => "AR5657 R-Programming", "units" => 4],
        ["name" => "AR5652 PhD Seminar", "units" => 8],
        ["name" => "AR5657 R-Programming", "units" => 4],
        ["name" => "AR5652 PhD Seminar", "units" => 8],
        ["name" => "AR5657 R-Programming", "units" => 4],
    ];
}

if (!isset($_SESSION['pqe'])) {
    $_SESSION['pqe'] = [
        "name" => "PhD Qualifying Oral Examination",
        "status" => "Done",
        "date" => "22 April 2024"
    ];
}

if (!isset($_SESSION['phd'])) {
    $_SESSION['phd'] = [
        "name" => "PhD Oral Defense",
        "status" => "Due",
        "date" => "22 April 2025"
    ];
}

if (!isset($_SESSION['duties'])) {
    $_SESSION['duties'] = [
        "teaching" => ["finished" => 6, "total" => 10],
        "research" => ["finished" => 12, "total" => 12],
        "other" => ["finished" => 2, "total" => 15]
    ];
}

$modules = $_SESSION['modules'];
$pqe = $_SESSION['pqe'];
$phd = $_SESSION['phd'];
$duties = $_SESSION['duties'];

include 'includes/header.php';
?>
<main>
   <side>
        <section class="profile-container">
            <div class="profile-photo-container">
              <img src="images/nusgs_profile_test.png" alt="NUS Graduate School Profile Test">
            </div>
            <div class="profile-name-container">
                <h1 id="profile-name">Sherry Tan Xue Er</h1>
                <h2 id="profile-title">PGF Scholar</h2>
            </div>
            <div class="profile-info-container">
                <p id="profile-year">Yr 4 PhD Student</p>
                <p id="profile-school">School of Medicine</p>
                <p id="profile-department">Department of Biochemistry</p>
            </div>
        </section>

        <section class="reminder-container">
            <h1>Reminders</h1>
            <ul class="reminder-grid">
                <li class="reminder">
                    <img src="https://cdn-icons-png.flaticon.com/512/7069/7069964.png" alt="Info Icon">
                    <div>
                        <h3>Sit in for Sherry’s Thesis Defense </h3>
                        <p>Due 22 April 2023 </p>
                    </div>
                </li>
                <li class="reminder">
                    <img src="https://cdn-icons-png.flaticon.com/512/7069/7069964.png" alt="Info Icon">
                    <div>
                        <h3>Sit in for Sherry’s Thesis Defense </h3>
                        <p>Due 22 April 2023 </p>
                    </div>
                </li>
            </ul>
        </section>
   </side>
   <dashboard>
        <section class="progress-module-container">
            <progress-group>
                <h1>% to Graduation</h1>
                <div class="progress-percentage-container">
                    <svg viewBox="0 0 250 250" class="circular-progress">
                        <circle class="bg" r="104" cx="125" cy="125"></circle>
                        <circle class="fg" r="104" cx="125" cy="125"></circle>
                        <circle class="overflow-fg" r="104" cx="125" cy="125"></circle>
                        <circle class="inner-circle" r="35" cx="125" cy="125"></circle>
                        <text x="50%" y="50%" text-anchor="middle" dx="-.1em" dy=".1em" class="percentage-text" id="percentage-text">
                            0%
                        </text>
                    </svg>
                </div>
            </progress-group>

            <module>
                <div class="module-header">
                    <h1>Completed Modules</h1>
                    <h1 id="module-MC">0 / 64 MCs Completed</h1>
                </div>
                <ul class="modules">
                    <?php foreach ($modules as $module): ?>
                        <li class="module">
                            <h3><?= htmlspecialchars($module['name']) ?></h3>
                            <p><?= $module['units'] ?> units</p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </module>
        </section>

        <section class="pqe-container">
        <h1>PQE</h1>
            <div class="pqe-daysHours">
                <p id="pqe-day">0 Days</p>
                <p id="pqe-hour">0 Hours</p>
            </div>
            <div class="pqe-phd-task" id="pqe-task">
                <img src="" alt="Info Icon">
                <div>
                    <h3><?= $pqe['name'] ?></h3>
                    <p>
                        <?= $pqe['status'] . " " . date('d F Y', strtotime($pqe['date'])) ?>
                    </p>
                </div>
            </div>
        </section>

        <section class="phd-container">
            <h2>PhD Defense</h2>
            <div class="pqe-daysHours">
                
                <p id="phd-day">0 Days</p>
                <p id="phd-hour">0 Hours</p>
            </div>
            <div class="pqe-phd-task" id="phd-task">
                <img src="" alt="Info Icon">
                <div>
                    <h3><?= $phd['name'] ?></h3>
                    <p>
                        <?= $phd['status'] . " " . date('d F Y', strtotime($phd['date'])) ?>
                    </p>
                </div>
            </div>
        </section>
        
        <section class="duties-container">
            <h1>Teaching, Research and Other Duties</h1>
            <div class="duties-group">
                <div class="duty-progress">
                    <div class="duty-word-group">
                        <p class="duty-header">Teaching Duties</p>
                        <p class="duty-hours" id="duty-hours-teaching">
                            <?= $duties['teaching']['finished'] . " / " . $duties['teaching']['total'] . " Hours Completed"; ?>
                        </p>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="duties-teaching"></div>
                    </div>
                </div>
                <div class="duty-progress">
                    <div class="duty-word-group">
                        <p class="duty-header">Research Duties</p>
                        <p class="duty-hours" id="duty-hours-research">
                            <?= $duties['research']['finished'] . " / " . $duties['research']['total'] . " Hours Completed"; ?>
                        </p>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="duties-research"></div>
                    </div>
                </div>
                <div class="duty-progress">
                    <div class="duty-word-group">
                        <p class="duty-header">Other Duties</p>
                        <p class="duty-hours" id="duty-hours-other">
                            <?= $duties['other']['finished'] . " / " . $duties['other']['total'] . " Hours Completed"; ?>
                        </p>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="duties-other"></div>
                    </div>
                </div>
            </div>
        </section>
    </dashboard>
</main>
<script src="./js/script.js"></script>
<?php include 'includes/footer.php'; ?>