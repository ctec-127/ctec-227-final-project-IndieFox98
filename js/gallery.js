function modalClose(id) {
    var modal = document.getElementById("modal" + id);

    window.onclick = function() {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}