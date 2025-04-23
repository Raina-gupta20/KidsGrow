const text = "Welcome to KidsGrow Donation Platform";
let i = 0;
const speed = 70;

function typeEffect() {
  if (i < text.length) {
    document.getElementById("animated-text").innerHTML += text.charAt(i);
    i++;
    setTimeout(typeEffect, speed);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  typeEffect();

  const form = document.getElementById("supportMessageForm");
  const messagesContainer = document.getElementById("messagesContainer");

  loadMessages(); 

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const name = form.querySelector('input[name="name"]').value;
    const message = form.querySelector('textarea[name="message"]').value;

    if (!name || !message) {
      alert("Please fill in both your name and message.");
      return;
    }

    const formData = new FormData(form);

    fetch("submit_msg.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.text())
    .then(() => {
      form.reset();
      loadMessages(); 
    })
    .catch(error => {
      console.error("Error:", error);
    });
  });

  function loadMessages() {
    fetch("get_messages.php") 
      .then(res => res.text())
      .then(html => {
        messagesContainer.innerHTML = html;
      })
      .catch(err => {
        console.error("Failed to load messages:", err);
      });
  }
});

// Profile data handling

fetch('getUserData.php')
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      alert(data.error);
    } else {
      document.querySelector("#userName").textContent = data.name;
      document.querySelector("#userEmail").textContent = data.email;
      document.querySelector("#userRole").textContent = data.role;
      document.querySelector("#userImage").src = data.image || "img/default.png";
    }
  })
  .catch(error => {
    console.error('Fetch error:', error);
  });


