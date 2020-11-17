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

function displayMap(e) {
    const uniqueID = 'map-' + e;
    const map = document.getElementById(uniqueID);
    map.style.display === "none" ? map.style.display = "block" : map.style.display = "none";
}
