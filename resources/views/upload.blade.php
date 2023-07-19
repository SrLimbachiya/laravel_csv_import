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
<form id="upload-form" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" id="fileInput">
    <button type="submit">Upload</button>
</form>
<progress id="uploadProgress" value="0" max="100"></progress>
<div id="status"></div>

<!-- Your other HTML content here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#upload-form').submit(function (e) {
            e.preventDefault(); // Prevent the default form submission behavior

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
                },
                error: function (error) {
                    // Handle the error response here
                    console.log(error.responseJSON);
                }
            });
        });
    });
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
