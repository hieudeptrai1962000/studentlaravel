<html lang="en">

<style>

    body {
        font-family: "Orbitron", sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background: #dde4da;
        margin: 0px;
    }
    #myClock {
        background: #627b65;
        border-radius: 100px;
        width: 420px;
        text-align: center;
        padding: 35px 25px;
        font-size: 50px;
        color: #fff;
        box-shadow: 0 1px 1px 0 rgb(66 66 66 / 8%), 0 1px 3px 1px rgb(66 66 66 / 16%);
        letter-spacing: 5px;
    }
    #myClock #seconds {
        animation: blinker 1s linear infinite;
    }
    @keyframes blinker {
        0% {
            opacity: 0;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            opacity: 1;
        }
    }


</style>

<script>

    function addZero(number) {
        if (number < 10) {
            return "0" + number.toString();
        } else {
            return number.toString();
        }
    }
    window.setInterval(function () {
        var currentDateis = new Date();
        document.getElementById("hours").innerHTML = addZero(
            currentDateis.getHours()
        );
        document.getElementById("minutes").innerHTML = addZero(
            currentDateis.getMinutes()
        );
        document.getElementById("seconds").innerHTML = addZero(
            currentDateis.getSeconds()
        );
    }, 1000);

</script>
<head>
    <title>Realtime Clock - Java Script</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
</head>

<body>
<div id="myClock">
    <a href="{{route('students.index')}}">Back to Main Page</a>
    <span id="hours">00</span> :
    <span id="minutes">00</span> :
    <span id="seconds">00</span>
</div>

</body>

</html>
