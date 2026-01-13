<?php include __DIR__ . '/partials/header.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizNest - Online Examination System</title>
    
    <style>
        /* --- CSS Variables and Global Styles --- */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        :root {
            --color-bg-dark: #0F172A; /* Slate 900 */
            --color-text-light: #F8FAFC; /* Slate 50 */
            --color-text-muted: #94A3B8; /* Slate 400 */
            --color-card-bg: #1E293B; /* Slate 800 */
            --color-border-primary: rgba(59, 130, 246, 0.2);
            --color-indigo-600: #4F46E5; /* Primary Button */
            --color-indigo-700: #4338CA;
            --color-purple-400: #C084FC;
            --color-indigo-400: #818CF8;
            --color-cyan-400: #22D3EE;
            --color-success: #4ADE80; /* Green */
            --color-deep-blue: #1E40AF;
            --color-yellow-400: #FACC15; /* Added for uniqueness */
            --color-red-400: #F87171; /* Added for uniqueness */
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--color-bg-dark);
            color: var(--color-text-light);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Subtle Gradient Background Effect */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: radial-gradient(at 10% 10%, rgba(13, 23, 42, 0.4), transparent 50%),
                              radial-gradient(at 90% 90%, rgba(20, 30, 50, 0.6), transparent 50%);
        }

        /* --- Keyframes for Gradient Animation --- */
        @keyframes subtle-gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Sections */
        section {
            padding: 60px 16px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        section h2 {
            font-size: 2.25rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 40px;
            /* Applying gradient to H2s */
            background-image: linear-gradient(to right, var(--color-purple-400), var(--color-indigo-400));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* --- Banner/Header Section --- */
        .banner {
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
            border-bottom: 1px solid var(--color-border-primary);
        }

        .banner-content h1 {
            font-size: 3rem; /* text-5xl */
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 16px;
            /* Main Gradient Applied Here */
            background-image: linear-gradient(to right, var(--color-purple-400), var(--color-indigo-400), var(--color-cyan-400));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        @media (min-width: 768px) {
            .banner-content h1 {
                font-size: 4.5rem; /* md:text-7xl */
            }
        }

        .banner-content p {
            font-size: 1.25rem;
            color: var(--color-text-muted);
            margin-bottom: 32px;
        }

        .get-started-btn {
            background-color: var(--color-indigo-600);
            color: white;
            font-weight: 700;
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            transition: background-color 0.3s, transform 0.2s;
        }

        .get-started-btn:hover {
            background-color: var(--color-indigo-700);
            transform: translateY(-2px);
        }
        
        /* --- Feature Cards (Used for both feature sections) --- */
        .feature-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        /* Mobile Layout for Feature Cards 1 and Uniqueness Section */
        .features .feature-cards, .uniqueness .feature-cards {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        /* MODERN CARD STYLES */
        .feature-card {
            background-color: var(--color-card-bg);
            padding: 30px;
            border-radius: 12px;
            border: 1px solid rgba(51, 65, 85, 0.5);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.4s ease, transform 0.4s ease, background-color 0.4s ease;
            position: relative; 
            overflow: hidden; 
        }

        .feature-card:hover {
            transform: translateY(-8px);
            background-color: #26334a; 
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.5), 0 0 15px rgba(129, 140, 248, 0.6); 
        }

        /* ICON CONTAINER STYLES */
        .feature-images {
            height: 100px;
            width: 100px;
            background-color: rgba(15, 23, 42, 0.7); 
            background-image: radial-gradient(circle at center, rgba(129, 140, 248, 0.1) 0%, transparent 70%);
            border-radius: 8px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem; 
            border: 2px dashed rgba(129, 140, 248, 0.3);
            transition: transform 0.4s ease;
        }

        .feature-card:hover .feature-images {
            transform: scale(1.05); 
        }
        
        /* Consistent Icon Color Styling (for features section 1) */
        .features .feature-card:nth-child(1) .feature-images { color: var(--color-indigo-400); }
        .features .feature-card:nth-child(2) .feature-images { color: var(--color-success); }
        .features .feature-card:nth-child(3) .feature-images { color: var(--color-purple-400); }

        /* Consistent Icon Color Styling (for features section 2 - Refactored below for strip) */
        /* The strip uses inline styles for diverse colors, so this block is less critical here. */


        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        .feature-card p {
            color: var(--color-text-muted);
            font-size: 1rem;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .card-button {
            width: 100%;
            padding: 10px;
            background-color: transparent;
            color: var(--color-indigo-400);
            border: 1px solid var(--color-indigo-400);
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .card-button:hover {
            background-color: var(--color-indigo-600); 
            color: var(--color-text-light);
        }

        /* --- Statistics Section (New Strip Style) --- */
        .statistics {
            background-color: #111827; 
            border-radius: 16px;
            margin-top: 40px;
            margin-bottom: 40px;
            padding: 40px 0; /* Adjusted padding for full width strip */
            overflow: hidden; /* Hide the scrollbar container */
        }
        
        .statistics h2 {
            margin-bottom: 20px;
        }

        /* Horizontal Scrolling Container for Stats */
        .stat-strip {
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 10px 16px; /* Add padding for mobile overflow look */
            gap: 20px;
            justify-content: flex-start;
            align-items: center;
            white-space: nowrap;
        }
        
        /* Individual Stat Item */
        .stat-item {
            flex-shrink: 0;
            width: 250px; /* Fixed width for better strip effect */
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            padding: 20px;
            
            /* Animated Gradient Border/Background */
            background: var(--color-card-bg);
            border: 1px solid rgba(51, 65, 85, 0.5);
            
            /* Text Styling */
            font-size: 1.25rem;
            color: var(--color-text-light);
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(129, 140, 248, 0.4);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 5px;
            /* Gradient for the value text */
            background-image: linear-gradient(to right, var(--color-cyan-400), var(--color-indigo-400));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .stat-description {
            font-size: 0.9rem;
            color: var(--color-text-muted);
            font-weight: 500;
        }

        /* Hide Scrollbar for Cleaner Strip Look (Optional) */
        .stat-strip::-webkit-scrollbar {
            display: none;
        }
        .stat-strip {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        /* --- Feature Section 2 (New Animated Strip Style) --- */
        .feature-section {
            padding-bottom: 0;
        }

        .animated-feature-strip {
            display: flex;
            overflow-x: scroll;
            -webkit-overflow-scrolling: touch;
            padding: 10px 16px 40px 16px; /* Padding for horizontal scroll on mobile */
            gap: 30px;
            justify-content: flex-start;
            
            /* Hide Scrollbar */
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .animated-feature-strip::-webkit-scrollbar {
            display: none;
        }

        /* Feature Card within the Strip */
        .animated-feature-strip .feature-card {
            flex-shrink: 0;
            width: 320px; /* Fixed width for strip items */
            min-height: 350px;
            position: relative;
            
            /* Gradient Animated Border (Container) */
            background-image: linear-gradient(45deg, var(--color-card-bg), var(--color-card-bg));
            background-size: 200% 200%;
            border: 2px solid transparent;
            animation: subtle-gradient-shift 20s ease-in-out infinite;
        }

        .animated-feature-strip .feature-card:before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            border-radius: 12px;
            background: linear-gradient(
                135deg, 
                var(--color-indigo-400) 0%, 
                transparent 20%, 
                transparent 80%, 
                var(--color-purple-400) 100%
            );
            z-index: -1;
            margin: -2px; /* Border thickness */
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .animated-feature-strip .feature-card:hover:before {
            opacity: 1; /* Show gradient border on hover */
            animation: subtle-gradient-shift 10s linear infinite;
        }

        /* Ensure feature content stacks properly on mobile inside the strip */
        .animated-feature-strip .feature-card h3 {
             text-align: left;
        }
        .animated-feature-strip .feature-card p {
             text-align: left;
             flex-grow: 1;
        }
        .animated-feature-strip .feature-images {
            margin-left: 0;
        }
        
        /* --- Uniqueness Section Styling (Responsive Grid) --- */
        .uniqueness h2 {
            margin-top: 40px;
            margin-bottom: 50px;
        }
        
        .uniqueness .feature-card {
            /* Override strip styles for the grid */
            flex-shrink: 1;
            min-height: auto;
        }
        
        /* Unique Feature Icon Colors */
        .uniqueness .feature-card:nth-child(1) .feature-images { color: var(--color-red-400); }
        .uniqueness .feature-card:nth-child(2) .feature-images { color: var(--color-yellow-400); }


    </style>
</head>
<body>
    
    <!-- NAVIGATION BAR Placeholder -->
    <!-- <nav class="navbar">...</nav> -->

    <!-- Main Header Section -->
    <header class="banner">
        <div class="banner-content">
            <h1>Crafting Futures Through Quality Testing.</h1>
            <p>Every Exam, a Step Towards Greatness</p>
            <a href="/">
                <button class="get-started-btn">Get Started</button>
            </a>
        </div>
    </header>

    <!-- Features Section 1 (Kept original responsive grid) -->
    <section class="features">
        <h2>Core Capabilities</h2>
        <div class="feature-cards">
            
            <!-- Feature Card 1 -->
            <div class="feature-card">
                <div class="feature-images">
                    &#x1F4DD;
                </div>
                <h3>Easy Exam Setup</h3>
                <p>Set up exams with ease and simplicity, whether for a small group or large scale.</p>
                <a href="/">
                    <button class="card-button">Learn More</button>
                </a>
            </div>
            
            <!-- Feature Card 2 -->
            <div class="feature-card">
                <div class="feature-images">
                    &#x1F512;
                </div>
                <h3>Secure Environment</h3>
                <p>Our platform ensures that all exams are conducted in a secure and fair environment.</p>
                <button class="card-button">Learn More</button>
            </div>
            
            <!-- Feature Card 3 -->
            <div class="feature-card">
                <div class="feature-images">
                    &#x1F3C1;
                </div>
                <h3>Instant Results</h3>
                <p>Get instant feedback and results after completing your exams.</p>
                <button class="card-button">Learn More</button>
            </div>
            
        </div>
    </section>

    <!-- Statistics Section (New Horizontal Strip) -->
    <section class="statistics">
        <h2>QuizNest by the Numbers</h2>
        <div class="stat-strip">
            
            <div class="stat-item">
                <div class="stat-value">15K+</div>
                <div class="stat-description">Students</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">75%</div>
                <div class="stat-description">Total Success</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">35</div>
                <div class="stat-description">Main Questions</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">26</div>
                <div class="stat-description">Chief Experts</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">16</div>
                <div class="stat-description">Years of Experience</div>
            </div>

        </div>
    </section>

    <!-- Feature Section 2 (All-In-One Animated Horizontal Strip) -->
    <section class="feature-section">
        <h2>Comprehensive Examination Platform</h2>
        <div class="animated-feature-strip">
            
            <!-- Feature Card 4: Online Registration -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-purple-400);">
                    &#x1F464;
                </div>
                <h3>Online Registration</h3>
                <p>Allow users to register and manage their profiles easily.</p>
                <button class="card-button">Explore</button>
            </div>
            
            <!-- Feature Card 5: Attendance Tracking -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-indigo-400);">
                    &#x1F4C4;
                </div>
                <h3>Attendance Tracking</h3>
                <p>Keep detailed records of student attendance during exams.</p>
                <button class="card-button">Explore</button>
            </div>
            
            <!-- Feature Card 6: Exam Creation Tools -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-success);">
                    &#x2699;
                </div>
                <h3>Exam Creation Tools </h3>
                <p>Design exams, add questions, set formats, and manage time limits.</p>
                <button class="card-button">Explore</button>
            </div>
            
            <!-- Feature Card 7: Secure Payments -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-cyan-400);">
                    &#x1F4B8;
                </div>
                <h3>Secure Payments</h3>
                <p>Integrate seamless and secure payment gateways for exam fees.</p>
                <button class="card-button">Explore</button>
            </div>

            <!-- Feature Card 8: AI-Powered Question Generation -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-purple-400);">
                    &#x1F916;
                </div>
                <h3>AI Question Generator</h3>
                <p>Leverage AI to generate diverse, high-quality questions instantly.</p>
                <button class="card-button">Explore</button>
            </div>

            <!-- Feature Card 9: Detailed Analytics & Reporting -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-indigo-400);">
                    &#x1F4CA;
                </div>
                <h3>Detailed Analytics</h3>
                <p>Receive comprehensive reports on performance, gaps, and trends.</p>
                <button class="card-button">Explore</button>
            </div>

        </div>
    </section>

    <!-- Teacher's Role Section -->
    <section class="teacher-role">
        <h2>Teacher's Role</h2>
        <div class="feature-cards">
            
            <!-- 1. Exam Creation -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-indigo-600);">
                   &#x270F;
                </div>
                <h3>Exam Creation</h3>
                <p>Design question papers (MCQs, descriptive), set parameters, and randomize questions.</p>
                <button class="card-button">Manage Exams</button>
            </div>

            <!-- 2. Question Bank -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-purple-400);">
                    &#x1F5C3;
                </div>
                <h3>Question Bank</h3>
                <p>Maintain a reusable question bank categorized by subject, topic, and difficulty.</p>
                <button class="card-button">View Bank</button>
            </div>

            <!-- 3. Student Management -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-cyan-400);">
                    &#x1F465;
                </div>
                <h3>Student Management</h3>
                <p>Register students, assign exams to classes, and monitor attendance.</p>
                <button class="card-button">Manage Students</button>
            </div>

            <!-- 4. Monitoring -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-red-400);">
                    &#x1F441;
                </div>
                <h3>Monitoring</h3>
                <p>Track live exam progress and use anti-cheating features like IP tracking.</p>
                <button class="card-button">Start Invigilation</button>
            </div>

            <!-- 5. Evaluation -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-success);">
                    &#x2705;
                </div>
                <h3>Evaluation</h3>
                <p>Auto-grade objective questions and providing feedback on subjective answers.</p>
                <button class="card-button">Grade Exams</button>
            </div>

            <!-- 6. Analytics -->
            <div class="feature-card">
                <div class="feature-images" style="color: var(--color-yellow-400);">
                    &#x1F4C8;
                </div>
                <h3>Analytics</h3>
                <p>View class-wide performance statistics and identify weak areas.</p>
                <button class="card-button">View Reports</button>
            </div>

             <!-- 7. Communication -->
             <div class="feature-card">
                <div class="feature-images" style="color: var(--color-indigo-400);">
                    &#x1F4E3;
                </div>
                <h3>Communication</h3>
                <p>Send announcements, clarify doubts, and share study resources.</p>
                <button class="card-button">Send Updates</button>
            </div>

        </div>
    </section>

    <!-- New Uniqueness Section (Responsive Grid) -->
    <section class="uniqueness">
        <h2>Our Unique Edge</h2>
        <div class="feature-cards">
            
            <!-- Unique Feature 1: AI Proctoring -->
            <div class="feature-card">
                <div class="feature-images">
                    &#x1F440;
                </div>
                <h3>Unrivaled AI Proctoring</h3>
                <p>State-of-the-art behavioral monitoring detects unauthorized access, screen sharing, and identity fraud in real-time. Zero tolerance for cheating.</p>
                <button class="card-button" style="color: var(--color-red-400); border-color: var(--color-red-400);">See Security</button>
            </div>
            
            <!-- Unique Feature 2: Content Marketplace -->
            <div class="feature-card">
                <div class="feature-images">
                    &#x1F4DA;
                </div>
                <h3>Curated Content Marketplace</h3>
                <p>Access thousands of validated, subject-specific question banks created by 26+ chief experts, ready for instant deployment.</p>
                <button class="card-button" style="color: var(--color-yellow-400); border-color: var(--color-yellow-400);">View Library</button>
            </div>
            
        </div>
    </section>

    <!-- Footer -->
    <!-- <footer style="padding: 30px 16px; text-align: center; color: var(--color-text-muted); border-top: 1px solid rgba(51, 65, 85, 0.3);">
        <p>&copy; 2024 QuizNest. All rights reserved.</p>
    </footer> -->
    
</body>
</html̇

<?php include __DIR__ . '/partials/footer.php'; ?>