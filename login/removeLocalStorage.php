<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

    $(function(){
        localStorage.removeItem("branch_cdcommon");
        localStorage.removeItem("branch_cd");
        localStorage.removeItem("room_no");
        localStorage.removeItem("room_cd");
        localStorage.removeItem("room_string");
        localStorage.removeItem("branch_string");

        window.location.href='/login/logout.php';
    })

</script>