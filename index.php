<?php 
  session_start(); 
  include('user/connect.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Navachar - Empowering Communities</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>
   <header class="navbar">
    <div class="logo"><i class="fas fa-leaf"></i> Navachar</div>
    <nav id="nav-links">
      <a href="#">Home</a>
      <a href="#">Features</a>
      <?php if (isset($_SESSION['email'])): ?>
        <?php 
          $email = $_SESSION['email'];
          $query = mysqli_query($conn, "SELECT firstName, lastName FROM users WHERE email='$email'");
          $user = mysqli_fetch_assoc($query);
        ?>
        <div class="user-menu" id="user-menu">
          <i class="fas fa-user-circle"></i>
          <span><?php echo htmlspecialchars($user['firstName']); ?></span>
          <a href="user/logout.php" id="logout-link">Logout</a>
        </div>
      <?php else: ?>
        <a href="user/index.php" id="login-link">Login</a>
        <a href="user/index.php" id="register-link">Register</a>
      <?php endif; ?>
    </nav>
  </header>

  <section class="hero">
    <h1>Empowering Local Communities</h1>
    <p>
      A digital platform for rural development, education, NGOs, and SHGs—fostering collaboration, discussion, and growth.
    </p>
    <a class="cta-button" href="#">Get Started</a>
  </section>

  <section class="features">
    <h2>🌟 Platform Highlights</h2>
    <div class="feature-grid">
      <div class="card">
        <a href="http://localhost:3000/" _target="bank"><i class="fas fa-comments feature-icon"></i></a>
        <h3>Collaborative Discussions</h3>
        <p>Share ideas, solve issues, and connect with your community in meaningful conversations.</p>
      </div>
      <div class="card">
        <a href="_event_management_/_event_management_.html"><i class="fas fa-calendar-alt feature-icon"></i></a>
        <h3>Event Management</h3>
        <p>Plan and promote local gatherings, training sessions, and campaigns effortlessly.</p>
      </div>
      <div class="card">
        <a href="_collective_solutions_/_collective_solutions_.html"><i class="fas fa-lightbulb feature-icon"></i></a>
        <h3>Collective Solutions</h3>
        <p>Brainstorm and develop sustainable ideas to address community challenges.</p>
      </div>
    </div>
  </section>

  <section class="audience">
    <h2>👥 Built For</h2>
    <ul>
      <li>🌾 Rural Communities</li>
      <li>🏫 Schools & Colleges</li>
      <li>🤝 NGOs & Self-Help Groups</li>
      <li>💬 Local Leaders & Volunteers</li>
    </ul>
  </section>

  <footer class="footer">
    <p>&copy; 2025 Navachar. Empowering Change, Together.</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>