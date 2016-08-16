function loadPage() {
    if (document.getElementById("optionsRadios1").checked == true) {
        clickURL();
    } else {
        clickFile();
    }
}

function clickURL() {
    document.getElementById("URL1").disabled        = false;
    document.getElementById("URL2").disabled        = false;
    document.getElementById("fileInput").disabled   = true;
}

function clickFile() {
    document.getElementById("URL1").disabled        = true;
    document.getElementById("URL2").disabled        = true;
    document.getElementById("fileInput").disabled   = false;
}