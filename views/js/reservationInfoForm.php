<script>
    function defaultValues()
    {
        console.log();
        var date = new Date();
        var dd = date.getDate() + 2;
        var mm = date.getMonth() + 1;
        var yyyy = date.getFullYear();

        if(dd<10) {
            dd='0'+dd
        } 

        if(mm<10) {
            mm='0'+mm
        } 

        date = yyyy + '-' + mm + '-' + dd;

        document.getElementById("pickup_date").defaultValue = date;
        document.getElementById("dropoff_date").defaultValue = date;

        document.getElementById("pickup_time").defaultValue = "09:00";
        document.getElementById("dropoff_time").defaultValue = "22:00";      
    }

    function form_submit()
    {
        document.getElementById('reservationForm').submit();    
    }

    window.onload = defaultValues();
</script>
