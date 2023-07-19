<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CSV File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
    </style>
</head>
<body>
<h1>Upload a CSV File</h1>
<form method="POST" action="{{ route('process-upload') }}" enctype="multipart/form-data" class="upload-form">
    @csrf
    <input type="file" id="csv_file" name="csv_file" accept=".csv" class="upload-input">
    <button type="button" class="upload-button" id="uploadBtn">Upload</button>
</form>
<div id="upload-status"></div>

<!-- Your other HTML content here -->

<script>

    let uploadBtn = document.getElementById('uploadBtn');

    uploadBtn.addEventListener('click', function (e) {
        uploadCsvFile(e)
    });


    function uploadCsvFile(event) {
        event.preventDefault();

        let formData = new FormData();
        let fileInput = document.getElementById('csv_file');

        formData.append('csv_file', fileInput.files[0]);

        // Get the CSRF token
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make the AJAX request
        fetch('{{ route("process-upload") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the request headers
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                // Handle the response data
                console.log(data);
            })
            .catch(error => {
                // Handle any errors
                console.error('Error:', error);
            });
    }
</script>


@if (isset($data))
    <table>
        <thead>
        <tr>
            @foreach ($data[0] as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @for ($i = 1; $i < count($data); $i++)
            <tr>
                @foreach ($data[$i] as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endfor
        </tbody>
    </table>
@endif



@if (session('success'))
<div class="message success">{{ session('success') }}</div>
@elseif (session('error'))
<div class="message error">{{ session('error') }}</div>
@endif
</body>
</html>
