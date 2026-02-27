document.querySelectorAll(".eye-hide").forEach(function (icon) {
    icon.addEventListener("click", function () {
        const input = document.getElementById(this.dataset.target);
        //si le type est password on le change en text (mdp visible),sinon on remet password
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    });
});
