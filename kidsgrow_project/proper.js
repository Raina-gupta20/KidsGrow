// Navigation Menu Toggle
function toggleMenu() {
  const nav = document.getElementById("navLinks");
  nav.classList.toggle("show");
}


// Slide Section
const slides = document.querySelectorAll('.slide');
const btns = document.querySelectorAll('.btn');
const leftArrow = document.querySelector('.arrow.left');
const rightArrow = document.querySelector('.arrow.right');
let currentSlide = 0;

// Function to update slides
function updateSlide(index) {
  slides.forEach((slide) => slide.classList.remove('active'));
  btns.forEach((btn) => btn.classList.remove('active'));

  slides[index].classList.add('active');
  btns[index].classList.add('active');
}

// Manual navigation with dots
btns.forEach((btn, index) => {
  btn.addEventListener('click', () => {
    currentSlide = index;
    updateSlide(currentSlide);
  });
});

// Manual navigation with arrows
leftArrow.addEventListener('click', () => {
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  updateSlide(currentSlide);
});

rightArrow.addEventListener('click', () => {
  currentSlide = (currentSlide + 1) % slides.length;
  updateSlide(currentSlide);
});

// Auto-play functionality
function autoPlay() {
  currentSlide = (currentSlide + 1) % slides.length;
  updateSlide(currentSlide);
}

// Start autoplay
setInterval(autoPlay, 3000); // Change slide every 3 seconds

// About Us Section
document.addEventListener("DOMContentLoaded", function() {
  const cards = document.querySelectorAll(".card");
  cards.forEach(card => {
      card.addEventListener("click", function() {
          alert(`You clicked on ${this.querySelector("h3").innerText}`);
      });
  });
});

// Causes Section
function donate(cause) {
  alert(`Thank you for wanting to donate to the ${cause} cause!`);
}

// Our Team Section
document.addEventListener('DOMContentLoaded', () => {
  const socialLinks = document.querySelectorAll('.social-links a');
  socialLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      const url = this.getAttribute('href');
      if (url && url !== "#") {
        alert(`You clicked the link: ${url}`);
        window.open(url, '_blank');
      }
      e.preventDefault();
    });
  });
});



// Contact Us Section - Form Handling
function toggleForm() {
  window.location.href = "login.html";
}

function showForm(formId) {
  document.querySelectorAll(".form-container").forEach(form => {
      form.style.display = "none";
  });
  document.getElementById(formId).style.display = "block";
}

// Alert Confirmation
function showAlert(role, formId) {
  document.getElementById('alert-message').innerText = `Are you sure you want to proceed as a ${role}?`;
  document.getElementById('custom-alert').style.display = 'flex';
  document.getElementById('custom-alert').setAttribute('data-form', formId);
}

function confirmSelection() {
  let formId = document.getElementById('custom-alert').getAttribute('data-form');
  document.getElementById('custom-alert').style.display = 'none';
  showForm(formId);
}

function closeAlert() {
  document.getElementById('custom-alert').style.display = 'none';
}

// Frequently Asked Questions
const faqItems = document.querySelectorAll('.faq-item');
faqItems.forEach(item => {
    item.addEventListener('click', () => {
        item.classList.toggle('active');
    });
});

// Footer Section - Donation Button
document.querySelector(".donate-btn").addEventListener("click", function() {
  alert("Thank you for your generosity! Redirecting to the donation page...");
  window.location.href = "donate.html";
});

// Footer Section - Subscribe Button
document.querySelector(".subscribe-btn").addEventListener("click", function() {
  let email = prompt("Enter your email to subscribe:");
  if (email) {
      alert("Thank you for subscribing!");
  }
});

// Social Media Icons Click
document.querySelectorAll(".social-icons a").forEach((icon) => {
  icon.addEventListener("click", function(event) {
    event.preventDefault();
    const platform = this.children[0].alt;
    alert("Redirecting to " + platform + "...");
    window.location.href = this.href;
  });
});
