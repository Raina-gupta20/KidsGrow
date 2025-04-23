function toggleForm() {
    window.location.href = "login.html";
}

function goToSignup() {
    window.location.href = "index.html";
}

// Role check
document.getElementById("loginForm").addEventListener("submit", function(e) {
    const role = this.role.value;
    if (!role) {
      e.preventDefault();
      alert("Please select your role before logging in.");
    }
  });

  // Password show/hide
  document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.querySelector("input[type='password']");
    const toggleBtn = document.querySelector(".toggle-password");

    toggleBtn.addEventListener("click", function () {
      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleBtn.textContent = "🙈";
      } else {
        passwordField.type = "password";
        toggleBtn.textContent = "👁";
      }
    });
  });