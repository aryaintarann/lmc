<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Articles - Legian Medical Clinic</title>
    <link rel="icon" href="img/lmc.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Reuse styles from landing (in a real app, extract this to a layout file) -->
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
            --card-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            --card-radius: 20px;
            --btn-radius: 50px;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-soft);
        }

        /* Article Cards */
        .article-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
            height: 100%;
        }

        .article-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--card-hover-shadow);
        }

        .article-img-wrapper {
            overflow: hidden;
            height: 240px;
            position: relative;
        }

        .article-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .article-card:hover img {
            transform: scale(1.1);
        }

        .article-date {
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            padding: 6px 15px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.75rem;
            display: inline-block;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        .article-link {
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .article-link i {
            margin-left: 5px;
            transition: margin 0.3s;
        }

        .article-link:hover i {
            margin-left: 10px;
        }

        .navbar {
            backdrop-filter: blur(20px);
            background-color: rgba(255, 255, 255, 0.85) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            height: 50px;
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
                <img src="img/lmc.png" alt="Legian Medical Clinic">
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-primary rounded-pill px-4">Back to Home</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-dark">Health Insights</h1>
            <p class="lead text-muted">Explore our full collection of health articles and updates.</p>
        </div>

        <div class="row g-4">
            @foreach($articles as $article)
                <div class="col-lg-4 col-md-6">
                    <div class="article-card position-relative">
                        <div class="article-img-wrapper">
                            <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image) }}"
                                alt="{{ $article->title }}">
                        </div>
                        <div class="card-body p-4">
                            <span class="article-date">{{ $article->date }}</span>
                            <h5 class="fw-bold mb-3">{{ $article->title }}</h5>
                            <p class="text-muted mb-4">{{ $article->excerpt }}</p>
                            <a href="{{ route('articles.show', $article->id) }}" class="article-link stretched-link">Read
                                More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Minimal Footer -->
    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5" style="background-color: var(--dark-blue) !important;">
        <div class="container">
            <div class="row g-5">
                <div class="col-12 text-center">
                    <img src="{{ asset('img/lmc.png') }}" alt="Logo" class="mb-4"
                        style="height: 60px; filter: brightness(0) invert(1);">
                    <p class="text-white-50 mb-4" style="max-width: 600px; margin: 0 auto;">We are committed to
                        providing the best medical service with a personal
                        touch. Your health is our priority.</p>
                    <p class="text-white-50 small mt-4">&copy; 2024 Legian Medical Clinic. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>