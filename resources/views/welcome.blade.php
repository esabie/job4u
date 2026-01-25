<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Job4U – Where Opportunity Meets Talent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2563eb;
            --light-green: #eef7f2;
            --gray-bg: #f3f4f6;
            --text-dark: #0f172a;
            --text-muted: #475569;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background: #ffffff;
        }

        /* ---------- HEADER ---------- */
        header {
            border-bottom: 1px solid #e5e7eb;
            background: #fff;
        }

        .nav {
            max-width: 1200px;
            margin: auto;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-weight: 800;
            font-size: 22px;
            color: var(--primary-blue);
        }

        nav a {
            margin-left: 32px;
            text-decoration: none;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* ---------- HERO ---------- */
        .hero-wrapper {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 24px;
        }

        .hero {
            background: var(--light-green);
            border-radius: 36px;
            padding: 80px 40px;
            text-align: center;
        }

        .hero h1 {
            font-size: 56px;
            font-weight: 800;
            color: var(--primary-blue);
            line-height: 1.1;
        }

        .hero p {
            margin-top: 18px;
            font-size: 18px;
            color: var(--text-muted);
        }

        .hero .sub {
            margin-top: 10px;
            font-weight: 600;
            color: #111827;
        }

        /* ---------- CTA BAR ---------- */
        .cta-bar {
            background: var(--gray-bg);
            margin: 40px auto;
            max-width: 1200px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            border-radius: 12px;
        }

        .btn {
            background: var(--primary-blue);
            color: #fff;
            border: none;
            padding: 14px 32px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        /* ---------- FEATURES ---------- */
        .features {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: var(--gray-bg);
            padding: 32px;
            border-radius: 12px;
            text-align: center;
        }

        .feature-card h3 {
            color: var(--primary-blue);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .feature-card p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 900px) {
            .features {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 42px;
            }

            .cta-bar {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="nav">
        <div class="logo">Job4U</div>
        <nav>
            <a href="#">My Profile</a>
            <a href="#">For Employers</a>
            <a href="#">Find Jobs</a>
            <a href="#">Candidate</a>
            <a href="#">Employer</a>
        </nav>
    </div>
</header>

<section class="hero-wrapper">
    <div class="hero">
        <h1>Where Opportunity Meets Talent</h1>
        <p>A modern job marketplace built for ambitious professionals and forward-thinking employers.</p>
        <p class="sub">Search smarter. Apply faster. Get hired with confidence.</p>
    </div>
</section>

<div class="cta-bar">
    <button class="btn">Find Jobs</button>
    <button class="btn">Upload CV</button>
    <button class="btn">Post a Job</button>
</div>

<section class="features">
    <div class="feature-card">
        <h3>Fast Applications</h3>
        <p>
            Quick Apply with CV so candidates can move from discovery to submission in minutes.
        </p>
    </div>

    <div class="feature-card">
        <h3>Relevant matches</h3>
        <p>
            Profile-based matching and alerts reduce noise and increase fit.
        </p>
    </div>

    <div class="feature-card">
        <h3>Verified environment</h3>
        <p>
            A verification-led approach that protects candidates and supports fair recruitment.
        </p>
    </div>
</section>

</body>
</html>
