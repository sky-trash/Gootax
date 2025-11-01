document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll("form");

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add("is-invalid");
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert("Please fill in all required fields.");
      }
    });
    form.querySelectorAll("input, textarea, select").forEach((field) => {
      field.addEventListener("input", function () {
        if (this.value.trim()) {
          this.classList.remove("is-invalid");
          this.classList.add("is-valid");
        } else {
          this.classList.remove("is-valid");
        }
      });
    });
  });
});
