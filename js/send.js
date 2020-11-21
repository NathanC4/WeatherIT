class Send {

    constructor(childElement) {
        this.parent = childElement.parentElement;
        this.form = new FormData();
    }

    getParent() {
        return this.parent.id;
    }

    createData(postName, postContent) {
        this.form.set(postName, postContent);
    }

    async sendData() {
        let data = await fetch('index.php?destination=favorite', {
            method: 'POST',
            credentials: 'same-origin',
            mode: 'cors',
            body: this.form,
            contentType: "multipart/form-data"
        });
        return await data.text()
    }
}

function favorites(e) {
    const ajax = new Send(e);
    let location = ajax.getParent().split("-");
    let label = e.nextSibling;
    if (label.title === "favorite") {
        ajax.createData("destination", "favorite");
        ajax.createData("favorite", location[1]);
    } else {
        ajax.createData("destination", "favorite");
        ajax.createData("unfavorite", location[1]);
    }
    ajax.sendData().then(r => {
        alert(r);
        window.location.replace("index.php?destination=home");
    });
}
