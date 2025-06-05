<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skylink - Home</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Lato:wght@400;700&display=swap">
    <!-- Styles -->
    <style>
       :root {
            --primary-color: #005f73; /* Deep teal */
            --secondary-color: #94d2bd; /* Light mint */
            --accent-color: #ee9b00; /* Warm gold */
            --background-gradient: linear-gradient(to bottom, #d9ed92, #76c893); /* Soft green gradient */
            --text-color: #002f34; /* Dark teal */
            --font-main: 'Roboto', sans-serif;
            --font-sub: 'Lato', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-main);
            color: var(--text-color);
            background: var(--background-gradient);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            animation: fadeIn 2s ease-in-out;
        }

        /* Fade-in animation for the entire page */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        header {
            background: var(--primary-color);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            animation: slideInFromLeft 1s ease-out;
        }

        /* Slide-in animation for the header */
        @keyframes slideInFromLeft {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(0); }
        }

        header h1 {
            font-size: 2rem;
            font-family: var(--font-sub);
        }

        nav {
            margin-top: 1rem;
        }

        nav ul {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            animation: waveIn 2s ease-out;
        }

        /* Wave animation for nav links */
        @keyframes waveIn {
            0% { opacity: 0; transform: translateY(20px); }
            50% { opacity: 0.5; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: var(--accent-color);
            transform: scale(1.1);
            transition: all 0.3s ease;
        }

        .hero {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--secondary-color);
            color: var(--text-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            animation: bounceIn 2s ease-in-out;
        }

        /* Bounce effect for the hero text */
        @keyframes bounceIn {
            0% { transform: translateY(-50px); opacity: 0; }
            50% { transform: translateY(10px); opacity: 0.5; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .hero h2 {
            font-family: var(--font-main);
            font-size: 2.5rem;
        }

        .hero p {
            font-family: var(--font-sub);
            font-size: 1.25rem;
            margin-top: 1rem;
        }

        .cta {
            margin-top: 2rem;
        }

        .cta a {
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            background: var(--accent-color);
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }

        .cta a:hover {
            background: var(--primary-color);
            transform: translateY(-5px);
        }

        footer {
            margin-top: auto;
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1rem;
        }

        footer p {
            font-family: var(--font-sub);
            font-size: 1rem;
        }

        /* Floating background particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            animation: float 10s infinite;
        }

        /* Particle float animation */
        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(100px, 50px); }
            100% { transform: translate(200px, 100px); }
        }

        .particle-1 { width: 15px; height: 15px; top: 20%; left: 30%; animation-delay: 0s; }
        .particle-2 { width: 25px; height: 25px; top: 50%; left: 70%; animation-delay: 2s; }
        .particle-3 { width: 20px; height: 20px; top: 70%; left: 10%; animation-delay: 4s; }

    </style>
</head>
<body>
    <!-- Particles in the background -->
    <div class="particle particle-1"></div>
    <div class="particle particle-2"></div>
    <div class="particle particle-3"></div>

    <header>
        <h1>Welcome to Skylink</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="../users/login.php">Book a Flight</a></li>
                <li><a href="../users/login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h2>Experience the Sky Like Never Before</h2>
        <p>Book your next journey with Skylink. Seamless, secure, and unforgettable.</p>
        <div class="cta">
            <a href="../users/login.php">Start Your Journey</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Skylink. All Rights Reserved.</p>
    </footer>
</body>
</html>
