<style type="text/css">
    .container {
        background-color: wheat;
        height: 100vh;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #hexagon2 {
        height: 0;
        width: 150px;
        border-top: 150px solid white;
        border-right: 100px solid transparent;
        border-left: 100px solid transparent;
        position: relative;
    }

    #hexagon2::before {
        position: absolute;
        content: '';
        height: 0;
        width: 150px;
        border-bottom: 150px solid white;
        border-right: 100px solid transparent;
        border-left: 100px solid transparent;
        bottom: 150px;
        left: -100px;
    }

    #circle {
        position: absolute;
        width: 250px;
        height: 250px;
        background: white;
        border-radius: 50%;
        border: black 1px solid;
        margin-left: -2px;
        margin-top: -154px;
    }

    #diamond {
        width: 140px;
        height: 140px;
        background-color: white;
        border: black 1px solid;
        position: absolute;
        left: 51%;
        top: 36%;
        transform: translate(-50%, -50%);
        transform: rotate(-45deg);
        transform-origin: 0 100%;

    }
</style>
<div class="container">
    <div id="hexagon2"></div>
    <div id="circle"></div>
    <div id="diamond"></div>
</div>