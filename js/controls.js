function hideForm() {
    const forms = document.getElementsByClassName("user-form");
    for (let i = 0; i < forms.length; i++) {
        forms[i].style.display = "none";
    }
}

function accessForm(e) {
    hideForm();
    const forms = document.getElementsByClassName("user-form");
    for (let i = 0; i < forms.length; i++) {
        forms[i].id === e ? forms[i].style.display = "flex" : null;
    }
}
