 var genreDropdownToggle = document.getElementById("genre-dropdown-toggle");
    var dropdownContent = document.querySelector(".dropdown-content");
    
    genreDropdownToggle.addEventListener("click", function(event) {
      event.preventDefault();
      dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
    });
    
    dropdownContent.addEventListener("click", function(event) {
      event.stopPropagation();
    });
    
