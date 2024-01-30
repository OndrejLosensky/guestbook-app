function confirmLogout() {
    console.log("logging out!");
    var logoutConfirmed = confirm("Are you sure you want to log out?");
    if (logoutConfirmed) {
        window.location.href = 'log_out.php';
    }
}