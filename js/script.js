document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM content loaded!");

  let scrollContainer = document.querySelector(".gallery");
  let backBtn = document.getElementById("backBtn");
  let nextBtn = document.getElementById("nextBtn");

  // Scroll distance settings
  const wheelScrollAmount = 200;  // Adjust this value to control wheel scroll distance
  const buttonScrollAmount = 200; // Adjust this value to control button scroll distance

  scrollContainer.addEventListener("wheel", (evt) => {
    evt.preventDefault();
    gsap.to(scrollContainer, {
      scrollLeft: scrollContainer.scrollLeft + evt.deltaY * (wheelScrollAmount / 100),
      duration: 0.5,
      ease: "bounce.out"
    });
  });

  backBtn.addEventListener("click", () => {
    gsap.to(scrollContainer, {
      scrollLeft: scrollContainer.scrollLeft - buttonScrollAmount,
      duration: 0.5,
      ease: "bounce.out"
    });
  });

  nextBtn.addEventListener("click", () => {
    gsap.to(scrollContainer, {
      scrollLeft: scrollContainer.scrollLeft + buttonScrollAmount,
      duration: 0.5,
      ease: "bounce.out"
    });
  });

  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeModal = document.querySelector(".close");
  const commentInput = document.getElementById("commentInput");
  const commentsList = document.getElementById("commentsList");
  const submitCommentBtn = document.getElementById("submitComment");
  let currentImageSrc = ""; // Store the currently viewed image source

  // Function to read the comment aloud
  function readCommentAloud(comment) {
    const utterance = new SpeechSynthesisUtterance(comment);
    speechSynthesis.speak(utterance);
  }



  // Function to load comments for the specific image
  function loadComments() {
    const comments = JSON.parse(localStorage.getItem("comments")) || {};
    const imageComments = comments[currentImageSrc] || []; // Get comments for the current image
    commentsList.innerHTML = ""; // Clear the existing comments list
    imageComments.forEach(comment => {
      const commentItem = document.createElement("div");
      commentItem.textContent = comment; // Set the text to the comment
      commentItem.style.margin = "5px 0"; // Optional styling for spacing
      commentsList.appendChild(commentItem); // Append the comment div to the comments list
    });
  }

  // Opening the modal and loading comments
  document.querySelectorAll(".gallery img").forEach(img => {
    img.addEventListener("click", () => {
      modal.style.display = "flex";
      modal.classList.add("show");
      modalImg.src = img.src; // Set the modal image source
      currentImageSrc = img.src; // Store the current image source
      loadComments(); // Load comments when the modal is opened
    });
  });

  // Close the modal
  modal.addEventListener("click", (event) => {
    if (event.target === modal) { // Ensure click is on the modal background
      modal.classList.remove("show");
      setTimeout(() => {
        modal.style.display = "none";
      }, 400);
    }
  });

  // Submit comment
  submitCommentBtn.addEventListener("click", () => {
    const comment = commentInput.value.trim(); // Get the trimmed comment input

    console.log("Comment input value:", comment); // Log the comment

    if (comment) {
      const comments = JSON.parse(localStorage.getItem("comments")) || {}; // Retrieve existing comments
      if (!comments[currentImageSrc]) {
        comments[currentImageSrc] = []; // Initialize array if it doesn't exist
      }
      comments[currentImageSrc].push(comment); // Add the new comment to the specific image
      localStorage.setItem("comments", JSON.stringify(comments)); // Save back to local storage

      const commentItem = document.createElement("div");
      commentItem.textContent = comment; // Set the text of the new comment
      commentItem.style.margin = "5px 0"; // Add spacing
      commentsList.appendChild(commentItem); // Append to the list

      // Check if speech feedback is enabled before reading the comment aloud
      const speechToggle = document.getElementById("speechToggle");
      if (speechToggle.checked) {
        readCommentAloud(comment);
      }

      commentInput.value = ""; // Clear the input
    } else {
      alert("Please enter a comment."); // Alert for empty comments
    }
  });

});
