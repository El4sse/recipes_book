<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Book</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        .fade-out {
            transition: opacity 1s ease-in-out;
            opacity: 0;
        }

        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            width: 300px;
            font-size: 0.9em;
        }

        .fixed-card {
            height: 450px;
            /* Set your desired fixed height */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
            /* Add padding for better readability */
            overflow: hidden;
            /* Ensure content doesn't overflow the card */
        }

        .card-title {
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 1.25rem;
            /* Increase font size */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-text {
            padding-top: 10px;
            padding-bottom: 10px;
            height: 150px;
            /* Increase height to allow more content */
            overflow-y: auto;
            /* Add vertical scroll bar */
            scrollbar-width: thin;
            /* For Firefox */
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
            /* For Firefox */
        }

        .card-text::-webkit-scrollbar {
            width: 8px;
            /* Width of the scrollbar */
        }

        .card-text::-webkit-scrollbar-track {
            background: transparent;
            /* Transparent track */
        }

        .card-text::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            /* Color of the scrollbar */
            border-radius: 10px;
            /* Rounded corners */
        }

        .btn-primary {
            margin-top: auto;
        }

        .custom-image {
            max-height: 200px;
            object-fit: cover;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('recipes.index') }}">Recipe Book</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('recipes.create') }}">Add Recipe</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <div class="notification">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').addClass('fade-out');
            }, 4000); // Start fading out after 4 seconds

            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000); // Remove alert after 5 seconds
        });
    </script>
</body>

</html>
