<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>CSV File Upload</title>
    <style>
        * {
            border: 0;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --hue: 223;
            --bg: hsl(var(--hue), 90%, 90%);
            --fg: hsl(var(--hue), 90%, 10%);
            --primary: hsl(var(--hue), 90%, 55%);
            --red: hsl(3, 90%, 50%);
            --orange: hsl(33, 90%, 50%);
            --green: hsl(153, 90%, 30%);
            --purple: hsl(273, 90%, 50%);
            --magenta: hsl(303, 90%, 50%);
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

        #backDrop {
            background-color: rgba(9, 9, 9, 0.75);
            background-size: cover;
            align-items: center;
            display: flex;
            justify-content: center;
            height: 100vh;
            width: 100vw;
            position: absolute;
        }

        body {
            /*background: linear-gradient(to top, #09203f 0%, #537895 100%);*/
            /*background: linear-gradient(190deg, rgb(0, 0, 0) -10.7%, rgb(53, 92, 125) 88.8%);*/
            /*background-image: linear-gradient(#07a3b2, #d9ecc7);*/
            /*background-image: linear-gradient(#0c7bb3, #f2bae8);*/
            /*background-image: linear-gradient(180deg,#121c84, #8278da);*/
            /*background-image: linear-gradient(#014871, #d7ede2);*/

            background: rgb(83,120,149);
            background: radial-gradient(circle, rgba(83,120,149,1) 10%, rgba(9,32,63,1) 100%);

            background-repeat: no-repeat;
            background-size: 100vw 100vh;
            font-family: "Rubik", sans-serif;
        }

        #submitBtn {
            background-color: #537895;
        }

        form {
            background-color: #dedede;
            border-radius: 12px;
        }

        .funspinner__box {
            width: 25vw;
            height: 25vw;
            display: flex;
            align-items: center;
            box-sizing: border-box;
            justify-content: center;
            position: absolute;
            z-index: 100;

        }

        .funspinner {
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
            width: 100vw;
            position: absolute;
            justify-content: center;
            align-items: center;

        }

        .funspinner__box > div {
            width: 20%;
            height: 20%;
            text-align: center;
        }

        .funspinner__box svg {
            width: 100%;
            height: 100%;
            margin: 0 auto;
        }

        .hourglass {
            transform: rotate(360deg);
            animation: hourglass 2s 1s infinite;
        }

        .hourglass .st0 {
            fill: none;
            stroke: #ffffff;
            stroke-width: 3;
            stroke-miterlimit: 10;
        }

        .hourglass .st1, .hourglass .st2 {
            fill: #000000;
            transform-origin: 50% 50%;
            animation: hourglass1 2s infinite;
        }

        .hourglass .st2 {
            transform: scale(0);
            animation: hourglass2 2s infinite;
        }

        @keyframes hourglass {
            0% {
                transform: rotate(0deg);
            }
            20% {
                transform: rotate(180deg);
            }
            45% {
                transform: rotate(180deg);
            }
            65% {
                transform: rotate(360deg);
            }
            90% {
                transform: rotate(360deg);
            }
        }

        @keyframes hourglass1 {
            10% {
                transform: scale(1);
            }
            40% {
                transform: scale(0);
            }
            60% {
                transform: scale(0);
            }
            90% {
                transform: scale(1);
            }
        }

        @keyframes hourglass2 {
            10% {
                transform: scale(0);
            }
            40% {
                transform: scale(1);
            }
            60% {
                transform: scale(1);
            }
            90% {
                transform: scale(0);
            }
        }
    </style>
</head>
<body>

<div
    id="backDrop"
    style="z-index: 1; display: none"
>
</div>


<div
    style="display: none"
    id="blocksAnim"
    class="funspinner bg-info">
    <div class="funspinner__box">
        <div class="hourglass">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 43.8 72.7"
                 style="enable-background:new 0 0 43.8 72.7;" xml:space="preserve">
        <path class="st0" d="M21.9,36.4c0,0-19.4-3-19.4-22.4V2.5h38.8V14C41.3,33.4,21.9,36.4,21.9,36.4z"/>
                <path class="st1" d="M21.9,30.6C18.6,29.8,8.2,26.4,8.2,14V8.2h27.5V14C35.6,26.4,25.1,29.8,21.9,30.6z"/>
                <path class="st0" d="M21.9,36.4c0,0-19.4,3-19.4,22.4v11.5h38.8V58.7C41.3,39.4,21.9,36.4,21.9,36.4z"/>
                <path class="st2" d="M8.2,64.5v-5.8c0-12.5,10.6-15.9,13.7-16.6c3.3,0.8,13.7,4.2,13.7,16.6v5.8H8.2z"/>
      </svg>

        </div>
    </div>
    <h2 class="z-10 mt-36 text-white">Importing Data</h2>
</div>


<div class="flex items-center justify-center p-12">
    <div class="mx-auto w-full max-w-[450px] bg-white rounded-xl drop-shadow-lg">
        <form
            class="py-6 px-5"
            method="POST"
            id="upload-form"
        >

            <div class="mb-6 pt-4">
                <label class="text-center mb-5 block text-xl font-semibold text-[#07074D]">
                    Import CSV
                </label>

                <div class="mb-8">
                    <input type="file" name="file" id="file" class="sr-only fileInput"/>
                    <label
                        for="file"
                        id="fileLabel"
                        class="cursor-pointer shadow-md relative flex min-h-[200px] items-center justify-center rounded-md border border-dashed border-[#a4b2be] p-12 text-center"
                    >
                        <div>
              <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                Drop files here
              </span>
                            <span class="mb-2 block text-base font-medium text-[#6B7280]">
                Or
              </span>
                            <span
                                class="shadow-sm inline-flex rounded border border-[#a4b2be] py-2 px-7 text-base font-medium text-[#07074D]"
                            >
                Browse
              </span>
                        </div>
                    </label>
                </div>


            </div>


            <div>
                <button
                    id="submitBtn"
                    class="shadow-xl hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
                >
                    Upload Data
                </button>
            </div>
            <div id="errorBox" style="display: none">
                <p class="text-sm" id="messageBox">Message Here</p>
            </div>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"
        integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {

        $('#file').on('change', function () {
            // Get the selected file name
            var fileName = $(this).val().split('\\').pop();

            // Update the label text with the selected file name
            $('#fileLabel').text(fileName);
        });

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
                    $('#messageBox').text('');
                    $('#errorBox').show();
                },
                error: function (error) {
                    // Handle the error response here
                    console.log(error.responseJSON);
                    $('#backDrop').hide();
                    $('#blocksAnim').hide();
                    $('#messageBox').text(response.message);
                    $('#errorBox').show();
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
