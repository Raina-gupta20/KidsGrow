<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$showAlert = false;
if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
    $showAlert = true;
    unset($_SESSION['login_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="img/kg1.png" sizes="128x128" />
  <title>KidsGrow - Donation</title>
  <link rel="stylesheet" href="donation.css" />
  <style>
    /* Profile Card Styles */
    .nav-user-pic {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  margin-right: 6px;
  vertical-align: middle;
}
    
.profile-cart {
position: fixed;
top: 0;
right: -400px;
width: 350px;
height: 60%;
background: linear-gradient(to bottom, #ffffff, #f9f9f9);
box-shadow: -3px 0 20px rgba(0, 0, 0, 0.2);
transition: right 0.4s ease-in-out;
z-index: 1001;
padding: 30px 20px;
overflow-y: auto;
border-top-left-radius: 20px;
border-bottom-left-radius: 20px;
font-family: 'Segoe UI', sans-serif;
    }

.profile-cart.active {
right: 0;
 }

.profile-cart-header {
display: flex;
justify-content: space-between;
align-items: center;
border-bottom: 1px solid #ddd;
padding-bottom: 10px;
}

.profile-cart-header h2 {
font-size: 2rem;
color: #333;
}

.close-btn {
font-size: 24px;
cursor: pointer;
color: #666;
}

.profile-cart-body {
margin-top: 25px;
text-align: center;
}

.profile-image img {
width: 150px;
height: 150px;
border-radius: 20%;
object-fit: cover;
border: 3px solid #ffa500;
box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
margin-bottom: 15px;
}

.profile-details p {
font-size: 1.5rem;
margin: 10px 0;
color: #444;
}

.profile-details span {
font-weight: 600;
color: #000;
}

.profile-cart-body button {
margin-top: 20px;
background: linear-gradient(to right, #ff8a00, #e65c00);
color: white;
border: none;
padding: 12px 25px;
border-radius: 30px;
cursor: pointer;
font-size: 1rem;
transition: background 0.3s ease;
}

.profile-cart-body button:hover {
background: linear-gradient(to right, #e65c00, #ff8a00);
}

.overlay {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: rgba(0, 0, 0, 0.5);
z-index: 1000;
display: none;
}

.overlay.active {
display: block;
}

  </style>
</head>
<body>

  <!-- Navigation Bar -->
<header>
  <nav class="navbar">
    <div class="nav-logo"><img src="img/kg2.png" alt="Logo"></div>
    <ul class="nav-links">
      <li><a href="proper.html">Home</a></li>
      <li>
        <a href="javascript:void(0);" onclick="toggleProfile()">
          <img src="img/user.jpeg" alt="User" class="nav-user-pic"> Your Profile</a>
      </li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<!-- Profile Slide-In -->
<div class="profile-cart" id="profileCard">
  <div class="profile-cart-header">
    <h2>Your Profile</h2>
    <span class="close-btn" onclick="toggleProfile()">&times;</span>
  </div>
  <div class="profile-cart-body">
    <div class="profile-image">
      <img id="userImage" src="img/user-profile.png" alt="Profile Image" />
    </div>
    <div class="profile-details">
      <p><strong>Name:</strong> <span id="userName"></span></p>
      <p><strong>Email:</strong> <span id="userEmail"></span></p>
      <p><strong>Role:</strong> <span id="userRole"></span></p>
    </div>
    <button onclick="openUpdateProfileForm()">Update Profile</button>
  </div>
</div>
<!-- Overlay -->
<div class="overlay" id="profileOverlay" onclick="toggleProfile()"></div>

<!-- Donation Section -->
  <div class="wrapper" id="donationSection">
    <div class="right-side">
      <div class="content">
        <h1>Your donation can light up a child's future!</h1>
        <p>Help us bring education, food, and care to underprivileged children.</p>
        <button onclick="window.open('donation_form.html', '_blank')">Donate Now</button>
      </div>
    </div>
    <div class="left-side">
      <img src="img/donation1.jpg" alt="Donation Image" />
    </div>
  </div>

  <!-- Video Section -->
  <section class="video-section">
    <div class="video-content">
      <h2>See the Impact of Your Donations</h2>
      <p>Watch how your contributions bring smiles, education, and better lives to underprivileged children.</p>
      <div class="video-wrapper">
        <video width="100%" controls>
          <source src="img/video KG.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  </section>

  <!-- Support Message Section -->
  <section class="message-section">
    <h2>Leave a Message of Support</h2>
    <form id="supportMessageForm" class="message-form">
      <input type="text" name="name" placeholder="Your Name" required />
      <textarea name="message" placeholder="Your message to the kids..." required></textarea>
      <button type="submit">Send Message</button>
    </form>
    <div id="messageStatus"></div>
  </section>

  <!-- Display Messages -->
  <section class="message-display">
    <h2>Messages from Our Supporters</h2>
    <div class="messages-container" id="messagesContainer">
      <!-- Messages will be dynamically added here -->
    </div>
  </section>

  <script>
    window.addEventListener('DOMContentLoaded', function () {
      <?php if ($showAlert): ?>
        alert('Login successful!');
      <?php endif; ?>
    });

    function toggleProfile() {
      const profileCard = document.getElementById('profileCard');
      const overlay = document.getElementById('profileOverlay');
      profileCard.classList.toggle('active');
      overlay.classList.toggle('active');
    }

    // Load user data from PHP
    fetch('getUserData.php')
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
        } else {
          document.getElementById("userName").textContent = data.name;
          document.getElementById("userEmail").textContent = data.email;
          document.getElementById("userRole").textContent = data.role;
          document.getElementById("userImage").src = data.image || "img/default.png";
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
      });


      document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("supportMessageForm");
  const messageStatus = document.getElementById("messageStatus");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch("submit_msg.php", {
      method: "POST",
      body: formData,
    })
      .then(res => res.text())
      .then(data => {
        messageStatus.innerText = data;
        form.reset();
        loadMessages(); 
      })
      .catch(err => {
        messageStatus.innerText = "Failed to send message.";
        console.error(err);
      });
  });

  function loadMessages() {
    fetch("get_messages.php")
      .then(res => res.text())
      .then(html => {
        document.getElementById("messagesContainer").innerHTML = html;
      });
  }

  loadMessages(); 
});

  </script>
  <script src="donation.js"></script>
</body>
</html>
