<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOTE-IT | Secure Digital Voting India</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #216eff;
            --accent: #00d2ff;
            --dark: #0f172a;
            --glass: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body { background: #0b0f19; color: white; overflow-x: hidden; }

        /* Advanced Navbar */
        nav {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(15px);
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo { 
            font-size: 32px; 
            font-weight: 800; 
            background: linear-gradient(to right, #216eff, #00d2ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }

        .nav-links a {
            color: #cbd5e1;
            text-decoration: none;
            margin-left: 30px;
            font-size: 15px;
            font-weight: 500;
            transition: 0.3s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0; height: 2px;
            bottom: -5px; left: 0;
            background: var(--accent);
            transition: 0.3s;
        }

        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: white; }

        /* Hero Section with Animation */
        .hero {
            height: 100vh;
            background: radial-gradient(circle at center, rgba(33, 110, 255, 0.15) 0%, transparent 70%),
                        url('https://images.unsplash.com/photo-1540910419892-f0c74b0e53b3?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero h1 { 
            font-size: clamp(40px, 8vw, 80px); 
            line-height: 1.1;
            margin-bottom: 20px;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .hero span { color: var(--accent); }

        .hero p { 
            font-size: clamp(16px, 2vw, 20px); 
            margin-bottom: 40px; 
            max-width: 700px; 
            color: #94a3b8;
        }

        /* Neon Buttons */
        .btn-group { display: flex; gap: 20px; }

        .btn {
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.4s;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-register { 
            background: var(--primary); 
            color: white; 
            box-shadow: 0 0 20px rgba(33, 110, 255, 0.4);
        }

        .btn-login { 
            background: transparent; 
            color: white; 
            border: 2px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }

        .btn:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 30px rgba(33, 110, 255, 0.6);
        }

        /* Info Section (Floating Cards) */
        .info-section {
            padding: 100px 5%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1300px;
            margin: -100px auto 0;
            position: relative;
            z-index: 10;
        }

        .info-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 24px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.1);
            transition: 0.4s;
        }

        .info-card:hover {
            border-color: var(--accent);
            transform: translateY(-10px);
            background: rgba(30, 41, 59, 0.9);
        }

        .info-card i {
            font-size: 45px;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .info-card h3 { font-size: 22px; margin-bottom: 15px; color: white; }
        .info-card p { font-size: 15px; color: #94a3b8; line-height: 1.6; }

        footer {
            background: #020617;
            padding: 40px;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.05);
            color: #64748b;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .info-section { margin-top: 50px; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">VOTE-IT</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="result.php">Results</a>
            <a href="admin/admin_login.php">Admin Portal</a>
        </div>
    </nav>

    <section class="hero">
        <h1 data-aos="fade-up">Apna Vote, <span>Apni Pehchan</span></h1>
        <p>Ghar baithe vote karein aur desh ki unnati mein bhagidari banein. <br>India's Most Secure & Transparent Digital Voting System.</p>
        
        <div class="btn-group">
            <a href="register.php" class="btn btn-register">
                <i class="fas fa-user-plus"></i> Register Now
            </a>
            <a href="login.php" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> Voter Login
            </a>
        </div>
    </section>

    <section class="info-section">
        <div class="info-card">
            <i class="fas fa-user-shield"></i>
            <h3>Surakshit (Secure)</h3>
            <p>End-to-end encryption ke saath aapka har vote hamari database mein ek digital locker ki tarah safe hai.</p>
        </div>
        <div class="info-card">
            <i class="fas fa-mobile-alt"></i>
            <h3>Aasan (Easy UI)</h3>
            <p>User-friendly interface jo har umar ke vyakti ke liye voting ko ek click ka kaam banata hai.</p>
        </div>
        <div class="info-card">
            <i class="fas fa-chart-line"></i>
            <h3>Live Results</h3>
            <p>Live verification system ke saath election results ki transparent monitoring bina kisi hera-pheri ke.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 VOTE-IT Digital India Initiative | Built with ❤️ for Democracy</p>
    </footer>

</body>
</html>