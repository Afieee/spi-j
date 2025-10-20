<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SPI Navigator - Persero Batam</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        html,
        body {
            overflow: hidden;
            height: 100%;
            margin: 0;
        }

        .background {
            background-image: url("{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/backgrounds/perserobg.jpg') }}");
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
        }

        .navbar {
            padding: 2px 5px;
        }

        .logo {
            max-width: 180px;
        }

        .navbar-nav .nav-link {
            font-weight: bold;
            color: #000080;
        }

        .content {
            background-color: white;
            padding: 60px;
            border-radius: 10px;
            color: black;
            text-align: center;
            max-width: 800px;
            margin: auto;
            margin-top: 150px;
        }

        .content h1 {
            font-size: 3rem;
        }

        .content p {
            font-size: 1.25rem;
        }

        .start-button {
            background-color: #ffc107;
            border: none;
            color: black;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 30px;
        }

        .start-button:hover {
            background-color: #e0a800;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/icons/Logo-Persero-Batam.png') }}"
                alt="Persero Batam" class="logo" />
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" style="color: navy;"
                        href="mailto:audit@perserobatam.com">audit@perserobatam.com</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid background d-flex align-items-center justify-content-center">
        <div class="content">
            <h1 class="font-weight-bold" style="color: navy;">SPI NAVIGATOR</h1>
            <p>
                <b>To Be a Trusted Advisor and Strategic Partner</b>
            </p>

            <a href="/login" class="start-button">START NOW</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
