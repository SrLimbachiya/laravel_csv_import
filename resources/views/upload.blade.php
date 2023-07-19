<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>CSV File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        .upload-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .upload-input {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            max-width: 100%;
        }

        .upload-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-button:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        * {
            border: 0;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        :root {
            --hue: 223;
            --bg: hsl(var(--hue),90%,90%);
            --fg: hsl(var(--hue),90%,10%);
            --primary: hsl(var(--hue),90%,55%);
            --red: hsl(3,90%,50%);
            --orange: hsl(33,90%,50%);
            --green: hsl(153,90%,30%);
            --purple: hsl(273,90%,50%);
            --magenta: hsl(303,90%,50%);
            --trans-dur: 0.3s;
            font-size: calc(16px + (20 - 16) * (100vw - 320px) / (1280 - 320));
        }
        /*body {*/
        /*    background-color: var(--bg);*/
        /*    color: var(--fg);*/
        /*    font: 1em/1.5 "Varela Round", sans-serif;*/
        /*    height: 100vh;*/
        /*    display: grid;*/
        /*    place-items: center;*/
        /*    transition:*/
        /*        background-color var(--trans-dur),*/
        /*        color var(--trans-dur);*/
        /*}*/
        main {
            padding: 1.5em 0;
        }
        .message {
            height: 1.5em;
            position: relative;
            text-align: center;
        }
        .message__line {
            animation: message-fade-in-out 5s linear;
            opacity: 0;
            position: absolute;
            inset: 0;
            text-align: center;
        }
        .message__line:nth-child(2) { animation-delay: 5s; }
        .message__line:nth-child(3) { animation-delay: 10s; }
        .message__line:nth-child(4) { animation-delay: 15s; }
        .message__line:nth-child(5) { animation-delay: 20s; }
        .message__line:nth-child(6) { animation-delay: 25s; }
        .message__line:nth-child(7) { animation-delay: 30s; }

        .message__line:last-child {
            animation-name: message-fade-in;
            animation-delay: 35s;
            animation-fill-mode: forwards;
        }
        .tower,
        .tower__brick,
        .tower__brick-layer,
        .tower__brick-side,
        .tower__brick-stud,
        .tower__group {
            transform-style: preserve-3d;
        }
        .tower {
            margin: 0 auto 1.5em auto;
            position: relative;
            perspective: 800px;
            width: 16em;
            height: 16em;
        }
        .tower__brick,
        .tower__brick-layer,
        .tower__brick-side,
        .tower__brick-stud,
        .tower__group {
            position: absolute;
        }
        .tower__brick,
        .tower__brick-side,
        .tower__group {
            animation-duration: 16s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }
        .tower__brick,
        .tower__brick-side {
            background-color: var(--primary);
        }
        .tower__brick {
            background-image: radial-gradient(100% 100% at center,hsla(0,0%,0%,0.3) 0.3em,hsla(0,0%,0%,0) 0.3em);
            background-size: 1em 1em;
            width: 2em;
            height: 1em;
        }
        .tower__brick-layer--4 {
            transform: translateZ(4.8em);
        }
        .tower__brick-layer--3 {
            transform: translateZ(3.6em);
        }
        .tower__brick-layer--2 {
            transform: translateZ(2.4em);
        }
        .tower__brick-layer--1 {
            transform: translateZ(1.2em);
        }
        .tower__brick-layer---1 {
            transform: translateZ(-1.2em);
        }
        .tower__brick-layer---2 {
            transform: translateZ(-2.4em);
        }
        .tower__brick-layer---3 {
            transform: translateZ(-3.6em);
        }
        .tower__brick-side {
            bottom: 100%;
            left: 0;
            width: 100%;
            height: 1.2em;
            transform: rotateX(90deg);
            transform-origin: 50% 100%;
        }
        .tower__brick-side:nth-child(2) {
            top: 0;
            bottom: auto;
            left: 100%;
            width: 1.2em;
            height: 100%;
            transform: rotateY(90deg);
            transform-origin: 0 50%;
        }
        .tower__brick-side:nth-child(3) {
            top: 100%;
            left: 0;
            width: 100%;
            height: 1.2em;
            transform: rotateX(-90deg);
            transform-origin: 50% 0;
        }
        .tower__brick-side:nth-child(4) {
            top: 0;
            right: 100%;
            bottom: auto;
            left: auto;
            width: 1.2em;
            height: 100%;
            transform: rotateY(-90deg);
            transform-origin: 100% 50%;
        }
        .tower__brick-side:nth-child(even),
        .tower__brick--90 .tower__brick-side:nth-child(odd),
        .tower__brick--135 .tower__brick-side:nth-child(odd),
        .tower__brick--270 .tower__brick-side:nth-child(odd),
        .tower__brick--315 .tower__brick-side:nth-child(odd) {
            animation-name: brick-side-1;
            filter: brightness(0.5);
        }
        .tower__brick-side:nth-child(odd),
        .tower__brick--90 .tower__brick-side:nth-child(even),
        .tower__brick--135 .tower__brick-side:nth-child(even),
        .tower__brick--270 .tower__brick-side:nth-child(even),
        .tower__brick--315 .tower__brick-side:nth-child(even) {
            animation-name: brick-side-2;
            filter: brightness(0.75);
        }
        .tower__brick-stud {
            background-color: inherit;
            border-radius: 50%;
            top: 0.2em;
            left: 0.2em;
            width: 0.6em;
            height: 0.6em;
            transform: translateZ(0.2em);
        }
        .tower__brick-stud:nth-child(6) {
            left: 1.2em;
        }
        .tower__brick--0 {
            transform: translate3d(-1.5em,-1.5em,0);
        }
        .tower__brick--45 {
            transform: translate3d(-0.5em,-1.5em,0);
        }
        .tower__brick--90 {
            transform: translate3d(0,-1em,0) rotateZ(90deg);
        }
        .tower__brick--135 {
            transform: translate3d(0,0,0) rotateZ(90deg);
        }
        .tower__brick--180 {
            transform: translate3d(-0.5em,0.5em,0);
        }
        .tower__brick--225 {
            transform: translate3d(-1.5em,0.5em,0);
        }
        .tower__brick--270 {
            transform: translate3d(-2em,0,0) rotateZ(-90deg);
        }
        .tower__brick--315 {
            transform: translate3d(-2em,-1em,0) rotateZ(-90deg);
        }
        .tower__brick--red,
        .tower__brick--red .tower__brick-side {
            background-color: var(--red);
        }
        .tower__brick--orange,
        .tower__brick--orange .tower__brick-side {
            background-color: var(--orange);
        }
        .tower__brick--green,
        .tower__brick--green .tower__brick-side {
            background-color: var(--green);
        }
        .tower__brick--purple,
        .tower__brick--purple .tower__brick-side {
            background-color: var(--purple);
        }
        .tower__brick--magenta,
        .tower__brick--magenta .tower__brick-side {
            background-color: var(--magenta);
        }
        .tower__brick--move1 { animation-name: brick-move-1; }
        .tower__brick--move2 { animation-name: brick-move-2; }
        .tower__brick--move3 { animation-name: brick-move-3; }
        .tower__brick--move4 { animation-name: brick-move-4; }
        .tower__brick--move5 { animation-name: brick-move-5; }
        .tower__brick--move6 { animation-name: brick-move-6; }
        .tower__brick--move7 { animation-name: brick-move-7; }
        .tower__brick--move8 { animation-name: brick-move-8; }
        .tower__brick--move9 { animation-name: brick-move-9; }
        .tower__brick--move10 { animation-name: brick-move-10; }
        .tower__brick--move11 { animation-name: brick-move-11; }
        .tower__brick--move12 { animation-name: brick-move-12; }
        .tower__brick--move13 { animation-name: brick-move-13; }
        .tower__brick--move14 { animation-name: brick-move-14; }
        .tower__brick--move15 { animation-name: brick-move-15; }
        .tower__brick--move16 { animation-name: brick-move-16; }

        .tower__group {
            animation-name: brick-group;
            top: 50%;
            left: 50%;
            transform: rotateX(45deg) rotateZ(45deg);
        }

        /* Dark theme */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg: hsl(var(--hue),90%,10%);
                --fg: hsl(var(--hue),90%,90%);
            }
        }

        /* Animations */
        @keyframes brick-group {
            from { transform: rotateX(45deg) rotateZ(0.125turn) translateZ(0); }
            to { transform: rotateX(45deg) rotateZ(2.125turn) translateZ(-4.8em); }
        }
        @keyframes brick-side-1 {
            from, 25%, 50%, 75%, to { filter: brightness(0.5); }
            12.5%, 37.5%, 62.5%, 87.5% { filter: brightness(0.75); }
        }
        @keyframes brick-side-2 {
            from, 25%, 50%, 75%, to { filter: brightness(0.75); }
            12.5%, 37.5%, 62.5%, 87.5% { filter: brightness(0.5); }
        }
        @keyframes brick-move-1 {
            from { animation-timing-function: ease-in; transform: translate3d(0,0,0) rotateZ(90deg); }
            1.25% { animation-timing-function: linear; transform: translate3d(0,0,-0.4em) rotateZ(90deg); }
            2.5% { transform: translate3d(2em,0,-0.4em) rotateZ(90deg); }
            3.75% { transform: translate3d(2em,0,10em) rotateZ(90deg); }
            5% { animation-timing-function: ease-out; transform: translate3d(0,0,10em) rotateZ(90deg); }
            6.25%, to { transform: translate3d(0,0,9.6em) rotateZ(90deg); }
        }
        @keyframes brick-move-2 {
            from, 6.25% { animation-timing-function: ease-in; transform: translate3d(-0.5em,-1.5em,0); }
            7.5% { animation-timing-function: linear; transform: translate3d(-0.5em,-1.5em,-0.4em); }
            8.75% { transform: translate3d(-0.5em,-3.5em,-0.4em); }
            10% { transform: translate3d(-0.5em,-3.5em,10em); }
            11.25% { animation-timing-function: ease-out; transform: translate3d(-0.5em,-1.5em,10em); }
            12.5%, to { transform: translate3d(-0.5em,-1.5em,9.6em); }
        }
        @keyframes brick-move-3 {
            from, 12.5% { animation-timing-function: ease-in; transform: translate3d(-2em,-1em,0) rotateZ(-90deg); }
            13.75% { animation-timing-function: linear; transform: translate3d(-2em,-1em,-0.4em) rotateZ(-90deg); }
            15% { transform: translate3d(-4em,-1em,-0.4em) rotateZ(-90deg); }
            16.25% { transform: translate3d(-4em,-1em,10em) rotateZ(-90deg); }
            17.5% { animation-timing-function: ease-out; transform: translate3d(-2em,-1em,10em) rotateZ(-90deg); }
            18.75%, to { transform: translate3d(-2em,-1em,9.6em) rotateZ(-90deg); }
        }
        @keyframes brick-move-4 {
            from, 18.75% { animation-timing-function: ease-in; transform: translate3d(-1.5em,0.5em,0); }
            20% { animation-timing-function: linear; transform: translate3d(-1.5em,0.5em,-0.4em); }
            21.25% { transform: translate3d(-1.5em,2.5em,-0.4em); }
            22.5% { transform: translate3d(-1.5em,2.5em,10em); }
            23.75% { animation-timing-function: ease-out; transform: translate3d(-1.5em,0.5em,10em); }
            25%, to { transform: translate3d(-1.5em,0.5em,9.6em); }
        }
        @keyframes brick-move-5 {
            from, 25% { animation-timing-function: ease-in; transform: translate3d(0,-1em,0) rotateZ(90deg); }
            26.25% { animation-timing-function: linear; transform: translate3d(0,-1em,-0.4em) rotateZ(90deg); }
            27.5% { transform: translate3d(2em,-1em,-0.4em) rotateZ(90deg); }
            28.75% { transform: translate3d(2em,-1em,10em) rotateZ(90deg); }
            30% { animation-timing-function: ease-out; transform: translate3d(0,-1em,10em) rotateZ(90deg); }
            31.25%, to { transform: translate3d(0,-1em,9.6em) rotateZ(90deg); }
        }
        @keyframes brick-move-6 {
            from, 31.25% { animation-timing-function: ease-in; transform: translate3d(-1.5em,-1.5em,0); }
            32.5% { animation-timing-function: linear; transform: translate3d(-1.5em,-1.5em,-0.4em); }
            33.75% { transform: translate3d(-1.5em,-3.5em,-0.4em); }
            35% { transform: translate3d(-1.5em,-3.5em,10em); }
            36.25% { animation-timing-function: ease-out; transform: translate3d(-1.5em,-1.5em,10em); }
            37.5%, to { transform: translate3d(-1.5em,-1.5em,9.6em); }
        }
        @keyframes brick-move-7 {
            from, 37.5% { animation-timing-function: ease-in; transform: translate3d(-2em,0,0) rotateZ(-90deg); }
            38.75% { animation-timing-function: linear; transform: translate3d(-2em,0,-0.4em) rotateZ(-90deg); }
            40% { transform: translate3d(-4em,0,-0.4em) rotateZ(-90deg); }
            41.25% { transform: translate3d(-4em,0,10em) rotateZ(-90deg); }
            42.5% { animation-timing-function: ease-out; transform: translate3d(-2em,0,10em) rotateZ(-90deg); }
            43.75%, to { transform: translate3d(-2em,0,9.6em) rotateZ(-90deg); }
        }
        @keyframes brick-move-8 {
            from, 43.75% { animation-timing-function: ease-in; transform: translate3d(-0.5em,0.5em,0); }
            45% { animation-timing-function: linear; transform: translate3d(-0.5em,0.5em,-0.4em); }
            46.25% { transform: translate3d(-0.5em,2.5em,-0.4em); }
            47.5% { transform: translate3d(-0.5em,2.5em,10em); }
            48.75% { animation-timing-function: ease-out; transform: translate3d(-0.5em,0.5em,10em); }
            50%, to { transform: translate3d(-0.5em,0.5em,9.6em); }
        }
        @keyframes brick-move-9 {
            from, 50% { animation-timing-function: ease-in; transform: translate3d(0,0,0) rotateZ(90deg); }
            51.25% { animation-timing-function: linear; transform: translate3d(0,0,-0.4em) rotateZ(90deg); }
            52.5% { transform: translate3d(2em,0,-0.4em) rotateZ(90deg); }
            53.75% { transform: translate3d(2em,0,10em) rotateZ(90deg); }
            55% { animation-timing-function: ease-out; transform: translate3d(0,0,10em) rotateZ(90deg); }
            56.25%, to { transform: translate3d(0,0,9.6em) rotateZ(90deg); }
        }
        @keyframes brick-move-10 {
            from, 56.25% { animation-timing-function: ease-in; transform: translate3d(-0.5em,-1.5em,0); }
            57.5% { animation-timing-function: linear; transform: translate3d(-0.5em,-1.5em,-0.4em); }
            58.75% { transform: translate3d(-0.5em,-3.5em,-0.4em); }
            60% { transform: translate3d(-0.5em,-3.5em,10em); }
            61.25% { animation-timing-function: ease-out; transform: translate3d(-0.5em,-1.5em,10em); }
            62.5%, to { transform: translate3d(-0.5em,-1.5em,9.6em); }
        }
        @keyframes brick-move-11 {
            from, 62.5% { animation-timing-function: ease-in; transform: translate3d(-2em,-1em,0) rotateZ(-90deg); }
            63.75% { animation-timing-function: linear; transform: translate3d(-2em,-1em,-0.4em) rotateZ(-90deg); }
            65% { transform: translate3d(-4em,-1em,-0.4em) rotateZ(-90deg); }
            66.25% { transform: translate3d(-4em,-1em,10em) rotateZ(-90deg); }
            67.5% { animation-timing-function: ease-out; transform: translate3d(-2em,-1em,10em) rotateZ(-90deg);  }
            68.75%, to { transform: translate3d(-2em,-1em,9.6em) rotateZ(-90deg); }
        }
        @keyframes brick-move-12 {
            from, 68.75% { animation-timing-function: ease-in; transform: translate3d(-1.5em,0.5em,0); }
            70% { animation-timing-function: linear; transform: translate3d(-1.5em,0.5em,-0.4em); }
            71.25% { transform: translate3d(-1.5em,2.5em,-0.4em);  }
            72.5% { transform: translate3d(-1.5em,2.5em,10em); }
            73.75% { animation-timing-function: ease-out; transform: translate3d(-1.5em,0.5em,10em); }
            75%, to { transform: translate3d(-1.5em,0.5em,9.6em); }
        }
        @keyframes brick-move-13 {
            from, 75% { animation-timing-function: ease-in; transform: translate3d(0,-1em,0) rotateZ(90deg); }
            76.25% { animation-timing-function: linear; transform: translate3d(0,-1em,-0.4em) rotateZ(90deg);  }
            77.5% { transform: translate3d(2em,-1em,-0.4em) rotateZ(90deg); }
            78.75% { transform: translate3d(2em,-1em,10em) rotateZ(90deg); }
            80% { animation-timing-function: ease-out; transform: translate3d(0,-1em,10em) rotateZ(90deg); }
            81.25%, to { transform: translate3d(0,-1em,9.6em) rotateZ(90deg); }
        }
        @keyframes brick-move-14 {
            from, 81.25% { animation-timing-function: ease-in; transform: translate3d(-1.5em,-1.5em,0); }
            82.5% { animation-timing-function: linear; transform: translate3d(-1.5em,-1.5em,-0.4em); }
            83.75% { transform: translate3d(-1.5em,-3.5em,-0.4em); }
            85% { transform: translate3d(-1.5em,-3.5em,10em); }
            86.25% { animation-timing-function: ease-out; transform: translate3d(-1.5em,-1.5em,10em); }
            87.5%, to { transform: translate3d(-1.5em,-1.5em,9.6em); }
        }
        @keyframes brick-move-15 {
            from, 87.5% { animation-timing-function: ease-in; transform: translate3d(-2em,0,0) rotateZ(-90deg); }
            88.75% { animation-timing-function: linear; transform: translate3d(-2em,0,-0.4em) rotateZ(-90deg); }
            90% { transform: translate3d(-4em,0,-0.4em) rotateZ(-90deg); }
            91.25% { transform: translate3d(-4em,0,10em) rotateZ(-90deg); }
            92.5% { animation-timing-function: ease-out; transform: translate3d(-2em,0,10em) rotateZ(-90deg); }
            93.75%, to { transform: translate3d(-2em,0,9.6em) rotateZ(-90deg); }
        }
        @keyframes brick-move-16 {
            from, 93.75% { animation-timing-function: ease-in; transform: translate3d(-0.5em,0.5em,0); }
            95% { animation-timing-function: linear; transform: translate3d(-0.5em,0.5em,-0.4em); }
            96.25% { transform: translate3d(-0.5em,2.5em,-0.4em); }
            97.5% { transform: translate3d(-0.5em,2.5em,10em); }
            98.75% { animation-timing-function: ease-out; transform: translate3d(-0.5em,0.5em,10em); }
            to { transform: translate3d(-0.5em,0.5em,9.6em); }
        }
        @keyframes message-fade-in {
            from { opacity: 0; }
            6%, to { opacity: 1; }
        }
        @keyframes message-fade-in-out {
            from, to { opacity: 0; }
            6%, 94% { opacity: 1; }
        }

        #backDrop {
            background-color: rgba(9, 9, 9, 0.5);
            background-size: cover;
            align-items: center;
            display: flex;
            justify-content: center;
            height: 100vh;
            width: 100vw;
            position: absolute;
        }
    </style>
</head>
<body>
<main class="text-center">
    <div id="backDrop" style="display: none">
    </div>
    <h1>Upload a CSV File</h1>
    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="fileInput">
        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
    </form>


    <button id="getBranches" class="btn btn-secondary btn-sm">Load Branches</button>
    <div id="dataShow"></div>

</main>
<div id="blocksAnim" style="z-index: 1000; display: none;">
    <div class="tower">
        <div class="tower__group">
            <div class="tower__brick-layer tower__brick-layer--4">
                <div class="tower__brick tower__brick--0">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--90 tower__brick--red">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--180 tower__brick--orange">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--270 tower__brick--purple">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
            <div class="tower__brick-layer tower__brick-layer--3">
                <div class="tower__brick tower__brick--45 tower__brick--magenta">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--135">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--225 tower__brick--green">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--315 tower__brick--orange">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
            <div class="tower__brick-layer tower__brick-layer--2">
                <div class="tower__brick tower__brick--0 tower__brick--red">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--90 tower__brick--green">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--180 tower__brick--purple">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--270">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
            <div class="tower__brick-layer tower__brick-layer--1">
                <div class="tower__brick tower__brick--45 tower__brick--purple">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--135 tower__brick--magenta">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--225 tower__brick--red">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--315 tower__brick--green">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
            <div class="tower__brick-layer">
                <div class="tower__brick tower__brick--0 tower__brick--move14">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--90 tower__brick--red tower__brick--move13">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--180 tower__brick--orange tower__brick--move16">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--270 tower__brick--purple tower__brick--move15">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
            <div class="tower__brick-layer tower__brick-layer---1">
                <div class="tower__brick tower__brick--45 tower__brick--move10 tower__brick--magenta">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--135 tower__brick--move9">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--225 tower__brick--green tower__brick--move12">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--315 tower__brick--orange tower__brick--move11">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
            <div class="tower__brick-layer tower__brick-layer---2">
                <div class="tower__brick tower__brick--0 tower__brick--red tower__brick--move6">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--90 tower__brick--green tower__brick--move5">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--180 tower__brick--purple tower__brick--move8">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--270 tower__brick--move7">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
            <div class="tower__brick-layer tower__brick-layer---3">
                <div class="tower__brick tower__brick--45 tower__brick--purple tower__brick--move2">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--135 tower__brick--magenta tower__brick--move1">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--225 tower__brick--red tower__brick--move4">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
                <div class="tower__brick tower__brick--315 tower__brick--green tower__brick--move3">
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-side"></div>
                    <div class="tower__brick-stud"></div>
                    <div class="tower__brick-stud"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="message">
        <p class="message__line">Loading…</p>
        <p class="message__line">Sorting out the pieces…</p>
        <p class="message__line">Assembling one brick at a time…</p>
        <p class="message__line">Following every step…</p>
        <p class="message__line">Being very careful not to step on the pieces…</p>
        <p class="message__line">Trying not to get finger blisters…</p>
        <p class="message__line">Might take longer to build than the Death Star…</p>
        <p class="message__line">Wrapping it up…</p>
    </div>
</div>

<!-- Your other HTML content here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('#upload-form').submit(function (e) {
            e.preventDefault(); // Prevent the default form submission behavior
            $('#backDrop').show();
            $('#blocksAnim').show();
            // Get the CSRF token from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Get the form data
            var formData = new FormData(this);

            // Append the CSRF token to the form data
            formData.append('_token', csrfToken);

            // Make the AJAX request
            $.ajax({
                type: 'POST',
                url: '{{ route("upload.process") }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Handle the success response here
                    console.log(response);
                    $('#backDrop').hide();
                    $('#blocksAnim').hide();
                },
                error: function (error) {
                    // Handle the error response here
                    console.log(error.responseJSON);
                    $('#backDrop').hide();
                    $('#blocksAnim').hide();
                }
            });
        });




        $('#getBranches').on('click', function () {
            console.log('clicked');
            $.ajax({
                type: 'GET',
                url: '{{ route("branches") }}',
                processData: false,
                contentType: false,
                success: function (response) {
                    // Handle the success response here
                    console.log(response);
                    $('#backDrop').hide();
                    $('#blocksAnim').hide();
                },
                error: function (error) {
                    // Handle the error response here
                    console.log(error.responseJSON);
                    $('#backDrop').hide();
                    $('#blocksAnim').hide();
                }
            });
        });


    });
</script>


@if (session('success'))
<div class="message success">{{ session('success') }}</div>
@elseif (session('error'))
<div class="message error">{{ session('error') }}</div>
@endif
</body>
</html>
