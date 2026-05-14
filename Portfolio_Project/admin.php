<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); exit;
}
require_once 'backend/db.php';
$success_msg = ''; $error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add_project') {
        $title = trim($_POST['title'] ?? ''); $description = trim($_POST['description'] ?? '');
        $image_url = trim($_POST['image_url'] ?? ''); $demo_link = trim($_POST['demo_link'] ?? ''); $repo_link = trim($_POST['repo_link'] ?? '');
        if ($title && $description) {
            $pdo->prepare("INSERT INTO projects (title, description, image_url, demo_link, repo_link) VALUES (?,?,?,?,?)")->execute([$title, $description, $image_url, $demo_link, $repo_link]);
            $success_msg = 'Project added successfully!';
        } else { $error_msg = 'Title and Description are required.'; }
    }
    if ($action === 'edit_project') {
        $id = (int)($_POST['id'] ?? 0); $title = trim($_POST['title'] ?? ''); $description = trim($_POST['description'] ?? '');
        $image_url = trim($_POST['image_url'] ?? ''); $demo_link = trim($_POST['demo_link'] ?? ''); $repo_link = trim($_POST['repo_link'] ?? '');
        if ($id && $title && $description) {
            $pdo->prepare("UPDATE projects SET title=?, description=?, image_url=?, demo_link=?, repo_link=? WHERE id=?")->execute([$title, $description, $image_url, $demo_link, $repo_link, $id]);
            $success_msg = 'Project updated!';
        } else { $error_msg = 'Title and Description are required.'; }
    }
    if ($action === 'delete_project') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) { $pdo->prepare("DELETE FROM projects WHERE id=?")->execute([$id]); $success_msg = 'Project deleted!'; }
    }
    if ($action === 'delete_message') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) { $pdo->prepare("DELETE FROM messages WHERE id=?")->execute([$id]); $success_msg = 'Message deleted!'; }
    }
}
if (isset($_GET['logout'])) { session_destroy(); setcookie('admin_session', '', time() - 3600, '/'); header('Location: login.php'); exit; }
$edit_project = null;
if (isset($_GET['edit'])) { $s = $pdo->prepare("SELECT * FROM projects WHERE id=?"); $s->execute([(int)$_GET['edit']]); $edit_project = $s->fetch(); }
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body{background:var(--bg-primary);color:var(--text-primary);font-family:'Inter',sans-serif;margin:0}
        .admin-layout{display:flex;min-height:100vh}
        .admin-sidebar{width:260px;flex-shrink:0;background:var(--glass-bg);border-right:1px solid var(--glass-border);padding:2rem 1.5rem;display:flex;flex-direction:column;position:sticky;top:0;height:100vh}
        .sidebar-logo{font-size:1.5rem;font-weight:800;color:var(--text-primary);margin-bottom:.25rem}
        .sidebar-logo span{color:var(--accent)}
        .sidebar-subtitle{color:var(--text-muted);font-size:.8rem;margin-bottom:2.5rem}
        .sidebar-nav{list-style:none;padding:0;margin:0;flex:1}
        .sidebar-nav li{margin-bottom:.5rem}
        .sidebar-nav a{display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;border-radius:.75rem;color:var(--text-secondary);text-decoration:none;font-size:.9rem;font-weight:500;transition:all .2s}
        .sidebar-nav a:hover,.sidebar-nav a.active{background:rgba(99,102,241,.15);color:var(--accent)}
        .sidebar-footer{margin-top:auto}
        .sidebar-user{display:flex;align-items:center;gap:.75rem;padding:1rem;background:rgba(99,102,241,.1);border-radius:.75rem;margin-bottom:1rem}
        .user-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-secondary));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;color:white}
        .user-name{font-size:.9rem;font-weight:600;color:var(--text-primary)}
        .user-role{font-size:.75rem;color:var(--text-muted)}
        .btn-logout{display:flex;align-items:center;justify-content:center;gap:.5rem;padding:.75rem;border-radius:.75rem;width:100%;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:#f87171;text-decoration:none;font-size:.875rem;font-weight:500;transition:all .2s;cursor:pointer;box-sizing:border-box}
        .btn-logout:hover{background:rgba(239,68,68,.2)}
        .admin-main{flex:1;padding:2.5rem;overflow-y:auto}
        .admin-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:2.5rem}
        .admin-header h1{font-size:1.75rem;font-weight:800;margin:0}
        .admin-header h1 span{color:var(--accent)}
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.25rem;margin-bottom:2.5rem}
        .stat-card{background:var(--glass-bg);border:1px solid var(--glass-border);border-radius:1.25rem;padding:1.5rem;display:flex;align-items:center;gap:1rem}
        .stat-icon{font-size:2rem}
        .stat-value{font-size:2rem;font-weight:800;color:var(--accent);line-height:1}
        .stat-label{font-size:.85rem;color:var(--text-muted);margin-top:.2rem}
        .admin-section{margin-bottom:3rem}
        .section-title{font-size:1.25rem;font-weight:700;margin-bottom:1.5rem}
        .alert{padding:1rem 1.25rem;border-radius:.75rem;margin-bottom:1.5rem;font-size:.9rem}
        .alert-success{background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.3);color:#86efac}
        .alert-error{background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.3);color:#fca5a5}
        .form-card{background:var(--glass-bg);border:1px solid var(--glass-border);border-radius:1.25rem;padding:2rem;margin-bottom:2rem}
        .form-card h3{font-size:1.1rem;font-weight:700;margin:0 0 1.5rem;color:var(--accent)}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
        .fg{display:flex;flex-direction:column;gap:.4rem}
        .fg.full{grid-column:1/-1}
        .form-label{font-size:.85rem;font-weight:500;color:var(--text-secondary)}
        .form-input,.form-textarea{background:var(--bg-secondary);border:1px solid var(--glass-border);color:var(--text-primary);border-radius:.6rem;padding:.7rem .9rem;font-family:'Inter',sans-serif;font-size:.9rem;transition:border-color .2s;width:100%;box-sizing:border-box}
        .form-input:focus,.form-textarea:focus{outline:none;border-color:var(--accent)}
        .form-textarea{resize:vertical;min-height:90px}
        .form-actions{display:flex;gap:1rem;margin-top:1.25rem}
        .table-wrap{background:var(--glass-bg);border:1px solid var(--glass-border);border-radius:1.25rem;overflow:hidden}
        .data-table{width:100%;border-collapse:collapse}
        .data-table th{text-align:left;padding:.875rem 1rem;font-size:.8rem;font-weight:600;letter-spacing:.05em;color:var(--text-muted);text-transform:uppercase;border-bottom:1px solid var(--glass-border)}
        .data-table td{padding:1rem;font-size:.9rem;border-bottom:1px solid rgba(255,255,255,.04);vertical-align:middle}
        .data-table tr:last-child td{border-bottom:none}
        .data-table tr:hover td{background:rgba(99,102,241,.05)}
        .project-img{width:60px;height:40px;object-fit:cover;border-radius:.4rem;background:var(--bg-secondary)}
        .badge{display:inline-block;padding:.25rem .6rem;border-radius:999px;font-size:.75rem;font-weight:600;background:rgba(99,102,241,.2);color:#a5b4fc}
        .btn-sm{padding:.4rem .8rem;border-radius:.5rem;font-size:.8rem;font-weight:500;cursor:pointer;border:none;transition:all .2s;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem}
        .btn-edit{background:rgba(99,102,241,.2);color:#a5b4fc}
        .btn-edit:hover{background:rgba(99,102,241,.4)}
        .btn-delete{background:rgba(239,68,68,.15);color:#f87171}
        .btn-delete:hover{background:rgba(239,68,68,.3)}
        .btn-primary-sm{background:linear-gradient(135deg,var(--accent),var(--accent-secondary));color:white;padding:.75rem 1.5rem;border-radius:.75rem;font-weight:600;font-size:.9rem;border:none;cursor:pointer;transition:opacity .2s}
        .btn-primary-sm:hover{opacity:.85}
        .btn-cancel{background:var(--bg-secondary);color:var(--text-secondary);padding:.75rem 1.5rem;border-radius:.75rem;font-weight:600;font-size:.9rem;border:1px solid var(--glass-border);cursor:pointer;text-decoration:none;transition:all .2s}
        .btn-cancel:hover{border-color:var(--accent);color:var(--accent)}
        .link-a{color:var(--accent);text-decoration:none;font-size:.85rem}
        .link-a:hover{text-decoration:underline}
        .msg-text{max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text-secondary);display:block}
        .empty-state{text-align:center;padding:3rem;color:var(--text-muted)}
        .empty-icon{font-size:3rem;margin-bottom:1rem}
        @media(max-width:900px){.admin-layout{flex-direction:column}.admin-sidebar{width:100%;height:auto;position:relative}.form-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="admin-layout">
  <aside class="admin-sidebar">
    <div class="sidebar-logo">Port<span>folio</span></div>
    <div class="sidebar-subtitle">Admin Dashboard</div>
    <ul class="sidebar-nav">
      <li><a href="#projects" class="active">🚀 Projects</a></li>
      <li><a href="#messages">✉️ Messages <span class="badge" style="margin-left:auto"><?= count($messages) ?></span></a></li>
      <li><a href="index.php" target="_blank">🌐 View Portfolio</a></li>
    </ul>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_username'],0,1)) ?></div>
        <div><div class="user-name"><?= htmlspecialchars($_SESSION['admin_username']) ?></div><div class="user-role">Administrator</div></div>
      </div>
      <a href="?logout=1" class="btn-logout">🚪 Logout</a>
    </div>
  </aside>
  <main class="admin-main">
    <div class="admin-header"><h1>Welcome back, <span><?= htmlspecialchars($_SESSION['admin_username']) ?></span> 👋</h1></div>
    <div class="stats-grid">
      <div class="stat-card"><div class="stat-icon">🚀</div><div><div class="stat-value"><?= count($projects) ?></div><div class="stat-label">Total Projects</div></div></div>
      <div class="stat-card"><div class="stat-icon">✉️</div><div><div class="stat-value"><?= count($messages) ?></div><div class="stat-label">Messages</div></div></div>
      <div class="stat-card"><div class="stat-icon">⚡</div><div><div class="stat-value">Active</div><div class="stat-label">Portfolio Status</div></div></div>
    </div>
    <?php if($success_msg):?><div class="alert alert-success">✅ <?= htmlspecialchars($success_msg)?></div><?php endif;?>
    <?php if($error_msg):?><div class="alert alert-error">❌ <?= htmlspecialchars($error_msg)?></div><?php endif;?>

    <!-- Projects -->
    <div class="admin-section" id="projects">
      <div class="section-title">🚀 Manage Projects</div>
      <div class="form-card">
        <h3><?= $edit_project ? '✏️ Edit Project' : '➕ Add New Project' ?></h3>
        <form method="POST" action="admin.php#projects">
          <input type="hidden" name="action" value="<?= $edit_project ? 'edit_project' : 'add_project'?>">
          <?php if($edit_project):?><input type="hidden" name="id" value="<?= $edit_project['id']?>"><?php endif;?>
          <div class="form-grid">
            <div class="fg"><label class="form-label">Title *</label><input type="text" name="title" class="form-input" required placeholder="Project Title" value="<?= htmlspecialchars($edit_project['title']??'')?>"></div>
            <div class="fg"><label class="form-label">Image URL</label><input type="url" name="image_url" class="form-input" placeholder="https://..." value="<?= htmlspecialchars($edit_project['image_url']??'')?>"></div>
            <div class="fg"><label class="form-label">Demo Link</label><input type="url" name="demo_link" class="form-input" placeholder="https://..." value="<?= htmlspecialchars($edit_project['demo_link']??'')?>"></div>
            <div class="fg"><label class="form-label">Repo Link</label><input type="url" name="repo_link" class="form-input" placeholder="https://github.com/..." value="<?= htmlspecialchars($edit_project['repo_link']??'')?>"></div>
            <div class="fg full"><label class="form-label">Description *</label><textarea name="description" class="form-textarea" required placeholder="Describe this project..."><?= htmlspecialchars($edit_project['description']??'')?></textarea></div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary-sm"><?= $edit_project ? '💾 Save Changes' : '➕ Add Project'?></button>
            <?php if($edit_project):?><a href="admin.php#projects" class="btn-cancel">Cancel</a><?php endif;?>
          </div>
        </form>
      </div>
      <div class="table-wrap">
        <?php if(empty($projects)):?>
          <div class="empty-state"><div class="empty-icon">🚀</div><p>No projects yet. Add your first one above!</p></div>
        <?php else:?>
        <table class="data-table">
          <thead><tr><th>Image</th><th>Title</th><th>Description</th><th>Links</th><th>Date</th><th>Actions</th></tr></thead>
          <tbody>
          <?php foreach($projects as $p):?>
          <tr>
            <td><?php if($p['image_url']):?><img src="<?= htmlspecialchars($p['image_url'])?>" alt="" class="project-img"><?php else:?><div class="project-img" style="display:flex;align-items:center;justify-content:center">🖼️</div><?php endif;?></td>
            <td><strong><?= htmlspecialchars($p['title'])?></strong></td>
            <td><span class="msg-text"><?= htmlspecialchars($p['description'])?></span></td>
            <td>
              <?php if($p['demo_link']):?><a href="<?= htmlspecialchars($p['demo_link'])?>" target="_blank" class="link-a">Demo</a> <?php endif;?>
              <?php if($p['repo_link']):?><a href="<?= htmlspecialchars($p['repo_link'])?>" target="_blank" class="link-a">Repo</a><?php endif;?>
            </td>
            <td style="color:var(--text-muted);font-size:.8rem"><?= date('M d, Y', strtotime($p['created_at']))?></td>
            <td>
              <a href="?edit=<?= $p['id']?>#projects" class="btn-sm btn-edit">✏️ Edit</a>
              <form method="POST" style="display:inline" onsubmit="return confirm('Delete this project?')">
                <input type="hidden" name="action" value="delete_project"><input type="hidden" name="id" value="<?= $p['id']?>">
                <button type="submit" class="btn-sm btn-delete">🗑️ Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach;?>
          </tbody>
        </table>
        <?php endif;?>
      </div>
    </div>

    <!-- Messages -->
    <div class="admin-section" id="messages">
      <div class="section-title">✉️ Contact Messages</div>
      <div class="table-wrap">
        <?php if(empty($messages)):?>
          <div class="empty-state"><div class="empty-icon">📭</div><p>No messages yet.</p></div>
        <?php else:?>
        <table class="data-table">
          <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Message</th><th>Received</th><th>Action</th></tr></thead>
          <tbody>
          <?php foreach($messages as $i=>$m):?>
          <tr>
            <td style="color:var(--text-muted)"><?= $i+1?></td>
            <td><strong><?= htmlspecialchars($m['name'])?></strong></td>
            <td><a href="mailto:<?= htmlspecialchars($m['email'])?>" class="link-a"><?= htmlspecialchars($m['email'])?></a></td>
            <td><span class="msg-text" title="<?= htmlspecialchars($m['message'])?>"><?= htmlspecialchars($m['message'])?></span></td>
            <td style="color:var(--text-muted);font-size:.8rem"><?= date('M d, Y H:i', strtotime($m['created_at']))?></td>
            <td>
              <form method="POST" style="display:inline" onsubmit="return confirm('Delete this message?')">
                <input type="hidden" name="action" value="delete_message"><input type="hidden" name="id" value="<?= $m['id']?>">
                <button type="submit" class="btn-sm btn-delete">🗑️ Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach;?>
          </tbody>
        </table>
        <?php endif;?>
      </div>
    </div>
  </main>
</div>
</body>
</html>
