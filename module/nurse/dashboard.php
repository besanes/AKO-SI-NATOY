<?php
/*
  NURSE DASHBOARD
  ----------------
  Lives at: module/nurse/dashboard.php

  Wired to match your actual login.php session variables:
  $_SESSION['UID'], $_SESSION['DISPLAYNAME'], $_SESSION['USERNAME'], $_SESSION['TYPE']
*/
require_once("../../include/initialize.php");

// --- Auth guard: must be logged in AND be a Nurse ---
if (!isset($_SESSION['UID']) || $_SESSION['TYPE'] !== 'Nurse') {
    redirect("../../login.php");
    exit;
}

$nickname = $_SESSION['DISPLAYNAME'];

// --- Example DB stat queries (uncomment once tblclinicvisits / tblmedicineinventory exist) ---
// Uses $conn from initialize.php if that's your DB connection variable name — confirm and adjust.
// $totalStudents   = $conn->query("SELECT COUNT(*) FROM tblstudent")->fetch_row()[0];
// $todayVisits     = $conn->query("SELECT COUNT(*) FROM tblclinicvisits WHERE visit_date = CURDATE()")->fetch_row()[0];
// $lowStockItems   = $conn->query("SELECT COUNT(*) FROM tblmedicineinventory WHERE stock <= reorder_level")->fetch_row()[0];
// $pendingFollowUp = $conn->query("SELECT COUNT(*) FROM tblclinicvisits WHERE status = 'Follow-up'")->fetch_row()[0];

// Placeholder sample data (remove once DB queries above are wired in)
$totalStudents   = 482;
$todayVisits     = 7;
$lowStockItems   = 3;
$pendingFollowUp = 2;

$recentVisits = [
    ['name' => 'Maria Santos',   'grade' => 'Grade 10-B', 'reason' => 'Headache',        'time' => '9:14 AM', 'status' => 'Released'],
    ['name' => 'John Reyes',     'grade' => 'Grade 8-A',  'reason' => 'Fever',           'time' => '9:40 AM', 'status' => 'Sent Home'],
    ['name' => 'Ana Cruz',       'grade' => 'Grade 11-C', 'reason' => 'Minor cut (hand)', 'time' => '10:02 AM','status' => 'Follow-up'],
    ['name' => 'Miguel Torres',  'grade' => 'Grade 7-D',  'reason' => 'Stomach ache',     'time' => '10:20 AM','status' => 'Released'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Nurse Dashboard - CANOPIN SOLUTIONS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
  :root{
    /* Nurse role color — teal instead of the admin red */
    --topbar-color: #0d8a86;
    --topbar-color-dark: #0a6d6a;
    --accent: #0d8a86;
  }
  body{ background:#f4f6f9; font-family:'Segoe UI',Roboto,Arial,sans-serif; }

  /* Sidebar (unchanged dark style from your existing layout) */
  .sidebar{
    width:250px; min-height:100vh; background:#20242c; position:fixed; top:0; left:0; z-index:100;
  }
  .sidebar .brand{ display:flex; align-items:center; gap:10px; padding:18px 16px; border-bottom:1px solid rgba(255,255,255,.08); }
  .sidebar .brand img{ width:34px; height:34px; border-radius:50%; }
  .sidebar .brand span{ color:#fff; font-weight:600; letter-spacing:.5px; font-size:14px; }
  .sidebar-nav{ padding-top:8px; }
  .sidebar-nav a{
    display:flex; align-items:center; gap:12px; padding:12px 18px; color:#c7c9cf; text-decoration:none; font-size:14.5px;
  }
  .sidebar-nav a:hover{ background:#2a2f38; color:#fff; }
  .sidebar-nav a.active{ background:var(--accent); color:#fff; }
  .sidebar-nav a i{ width:18px; text-align:center; }

  /* Topbar — this is the piece that changes color per role */
  .topbar{
    background:var(--topbar-color);
    background:linear-gradient(90deg,var(--topbar-color),var(--topbar-color-dark));
    color:#fff; padding:14px 24px; display:flex; align-items:center; justify-content:space-between;
    margin-left:250px;
  }
  .topbar .home-link{ color:#fff; font-weight:500; }
  .topbar .hello{ display:flex; align-items:center; gap:14px; }
  .topbar .logout-btn{
    color:#fff; text-decoration:none; font-size:14px; display:flex; align-items:center; gap:6px;
    border:1px solid rgba(255,255,255,.5); padding:5px 12px; border-radius:6px; transition:.2s;
  }
  .topbar .logout-btn:hover{ background:rgba(255,255,255,.15); color:#fff; text-decoration:none; }

  .content-wrap{ margin-left:250px; padding:26px; }
  .page-title{ font-size:26px; color:#3a3f4b; margin-bottom:4px; }
  .breadcrumb-line a{ color:var(--accent); text-decoration:none; }

  .small-box{ border-radius:6px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.12); color:#fff; margin-bottom:24px; }
  .small-box .sb-body{ padding:20px 22px; position:relative; min-height:100px; }
  .small-box .sb-num{ font-size:38px; font-weight:700; line-height:1; }
  .small-box .sb-num sup{ font-size:20px; }
  .small-box .sb-label{ font-size:15px; margin-top:6px; opacity:.95; }
  .small-box .sb-icon{
    position:absolute; top:14px; right:18px; font-size:52px; opacity:.28;
  }
  .small-box .sb-footer{
    display:block; padding:9px 22px; color:#fff; text-decoration:none; font-size:13.5px;
    background:rgba(0,0,0,.12); transition:.2s;
  }
  .small-box .sb-footer:hover{ background:rgba(0,0,0,.22); color:#fff; text-decoration:none; }
  .sb-teal{ background:#0d8a86; }
  .sb-green{ background:#28a745; }
  .sb-amber{ background:#f0ad2e; }
  .sb-red{ background:#dc3545; }

  .panel{ background:#fff; border-radius:10px; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:20px; }
  .panel-title{ font-weight:600; color:#3a3f4b; margin-bottom:14px; }

  table.visits th{ font-size:12.5px; text-transform:uppercase; color:#8a8f98; border-top:none; }
  .badge-released{ background:#e5f6ed; color:#1e8a4c; }
  .badge-home{ background:#fdecec; color:#c0392b; }
  .badge-followup{ background:#fff4dc; color:#b8860b; }

  .btn-accent{ background:var(--accent); border-color:var(--accent); color:#fff; }
  .btn-accent:hover{ background:var(--topbar-color-dark); border-color:var(--topbar-color-dark); color:#fff; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <div class="brand">
    <img src="https://via.placeholder.com/34" alt="logo">
    <span>CANOPIN SOLUTIONS</span>
  </div>
  <nav class="sidebar-nav">
    <a href="#" class="active"><i class="fa fa-heart-pulse"></i> Nurse Dashboard</a>
    <a href="#"><i class="fa fa-user-injured"></i> Clinic Visits</a>
    <a href="#"><i class="fa fa-notes-medical"></i> Student Health Records</a>
    <a href="#"><i class="fa fa-pills"></i> Medicine Inventory</a>
    <a href="#"><i class="fa fa-calendar-check"></i> Appointments</a>
    <a href="#"><i class="fa fa-gear"></i> Account Settings</a>
  </nav>
</div>

<!-- TOPBAR -->
<div class="topbar">
  <div><i class="fa fa-bars"></i> &nbsp; <span class="home-link">Home</span></div>
  <div class="hello">
    <i class="fa fa-circle-user fa-lg"></i> Hello, <?= htmlspecialchars($nickname) ?>
    <a href="../../logout.php" class="logout-btn"><i class="fa fa-right-from-bracket"></i> Logout</a>
  </div>
</div>

<!-- CONTENT -->
<div class="content-wrap">
  <div class="d-flex justify-content-between align-items-start mb-3">
    <div>
      <div class="page-title">Nurse Dashboard</div>
      <div class="breadcrumb-line"><a href="#">Home</a> / Nurse Dashboard</div>
    </div>
  </div>

  <!-- STAT CARDS -->
  <div class="row mb-2">
    <div class="col-md-3">
      <div class="small-box sb-teal">
        <div class="sb-body">
          <div class="sb-num"><?= $totalStudents ?></div>
          <div class="sb-label">Total Students</div>
          <i class="fa fa-user-graduate sb-icon"></i>
        </div>
        <a href="#" class="sb-footer">More info <i class="fa fa-circle-arrow-right"></i></a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box sb-green">
        <div class="sb-body">
          <div class="sb-num"><?= $todayVisits ?></div>
          <div class="sb-label">Clinic Visits Today</div>
          <i class="fa fa-briefcase-medical sb-icon"></i>
        </div>
        <a href="#" class="sb-footer">More info <i class="fa fa-circle-arrow-right"></i></a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box sb-amber">
        <div class="sb-body">
          <div class="sb-num"><?= $lowStockItems ?></div>
          <div class="sb-label">Low Stock Medicines</div>
          <i class="fa fa-pills sb-icon"></i>
        </div>
        <a href="#" class="sb-footer">More info <i class="fa fa-circle-arrow-right"></i></a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box sb-red">
        <div class="sb-body">
          <div class="sb-num"><?= $pendingFollowUp ?></div>
          <div class="sb-label">Pending Follow-ups</div>
          <i class="fa fa-clock sb-icon"></i>
        </div>
        <a href="#" class="sb-footer">More info <i class="fa fa-circle-arrow-right"></i></a>
      </div>
    </div>
  </div>

  <!-- RECENT VISITS TABLE -->
  <div class="panel">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div class="panel-title">Recent Clinic Visits</div>
      <a href="#" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> Log New Visit</a>
    </div>
    <table class="table visits">
      <thead>
        <tr>
          <th>Student</th>
          <th>Grade / Section</th>
          <th>Reason</th>
          <th>Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recentVisits as $v): ?>
        <tr>
          <td><?= htmlspecialchars($v['name']) ?></td>
          <td><?= htmlspecialchars($v['grade']) ?></td>
          <td><?= htmlspecialchars($v['reason']) ?></td>
          <td><?= htmlspecialchars($v['time']) ?></td>
          <td>
            <?php
              $badgeClass = 'badge-released';
              if ($v['status'] === 'Sent Home') $badgeClass = 'badge-home';
              if ($v['status'] === 'Follow-up') $badgeClass = 'badge-followup';
            ?>
            <span class="badge <?= $badgeClass ?> px-2 py-1"><?= htmlspecialchars($v['status']) ?></span>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>