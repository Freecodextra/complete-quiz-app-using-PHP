
function snackBar() {
    var toast = document.getElementById("snackbar");
    toast.className = "show";
    setTimeout(() => {
       toast.className = toast.className.replace("show", "");
    }, 3000);
}