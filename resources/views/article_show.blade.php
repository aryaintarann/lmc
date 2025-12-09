<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article['title'] }} - Legian Medical Clinic</title>
    <link rel="icon" href="{{ asset('img/lmc.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Palette */
            --primary-gradient: linear-gradient(135deg, #0a2540 0%, #1c4966 100%);
            --primary-color: #0a2540;
            --secondary-color: #1c4966;
            --dark-blue: #051626;
            --text-main: #344767;
            --text-muted: #7b809a;
            --bg-soft: #f5f7fa;
            --btn-radius: 50px;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background-color: white;
        }

        .navbar {
            backdrop-filter: blur(20px);
            background-color: rgba(255, 255, 255, 0.85) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            height: 50px;
        }

        .article-header {
            background-color: var(--bg-soft);
            padding: 80px 0;
            text-align: center;
        }

        .article-img {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin-top: -60px;
            margin-bottom: 40px;
        }

        .article-content {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-main);
        }
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    <!-- Simple Navbar -->
    <nav class="navbar navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('img/lmc.png') }}" alt="Legian Medical Clinic">
            </a>
            <a href="{{ route('articles.index') }}" class="btn btn-outline-primary rounded-pill px-4"><i
                    class="bi bi-arrow-left me-2"></i>Back to Articles</a>
        </div>
    </nav>

    <header class="article-header">
        <div class="container">
            <span class="badge bg-primary rounded-pill mb-3 px-3 py-2">{{ $article['date'] }}</span>
            <h1 class="display-4 fw-bold text-dark mb-0">{{ $article['title'] }}</h1>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}"
                    class="img-fluid article-img w-100 object-fit-cover" style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <div class="article-content">
            <p class="lead fw-bold mb-4">{{ $article['excerpt'] }}</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat.</p>

            <h3 class="fw-bold mt-5 mb-3">Understanding the Details</h3>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.</p>

            <blockquote class="blockquote my-5 p-4 bg-light rounded border-start border-4 border-primary">
                <p class="mb-0 fst-italic">"Health is not just about what you're eating. It's also about what you're
                    thinking and saying."</p>
            </blockquote>

            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam
                rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                explicabo.</p>
        </div>
    </div>

    <!-- Minimal Footer -->
    <footer class="bg-dark text-white py-4 mt-5" style="background-color: var(--dark-blue) !important;">
        <div class="container text-center">
            <p class="text-white-50 small mb-0">&copy; 2024 Legian Medical Clinic. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>