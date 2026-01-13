<?php include __DIR__ . '/partials/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    
    <div style="margin-bottom: 3rem; text-align: center;">
        <h1 class="page-title">Teacher Dashboard</h1>
        <p class="page-subtitle">Manage your exams, students, and evaluation in one place.</p>
    </div>

    <!-- Feature Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">

        <!-- 1. Exam Creation -->
        <div class="stat-card" style="display: block; cursor: pointer;" onclick="window.location.href='/teacher/create-exam'">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="stat-icon" style="color: var(--primary-color);">✎</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0;">Exam Creation</h3>
            </div>
            <p style="color: #94a3b8; font-size: 0.95rem;">Design question papers (MCQs, descriptive), set parameters (time, attempts), and randomize questions.</p>
        </div>

        <!-- 2. Question Bank -->
        <div class="stat-card" style="display: block; cursor: pointer;" onclick="window.location.href='/teacher/question-bank'">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="stat-icon" style="color: var(--secondary-color);">🗃️</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0;">Question Bank</h3>
            </div>
            <p style="color: #94a3b8; font-size: 0.95rem;">Manage reusable questions categorized by subject, topic, difficulty, and learning outcomes.</p>
        </div>

        <!-- 3. Student Management -->
        <div class="stat-card" style="display: block; cursor: pointer;" onclick="window.location.href='/teacher/students'">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="stat-icon" style="color: #22d3ee;">👥</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0;">Student Manager</h3>
            </div>
            <p style="color: #94a3b8; font-size: 0.95rem;">Register students, approve enrollments, assign exams to classes, and monitor attendance.</p>
        </div>

        <!-- 4. Monitoring -->
        <div class="stat-card" style="display: block; cursor: pointer;" onclick="window.location.href='/teacher/monitoring'">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="stat-icon" style="color: #ef4444;">👁️</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0;">Live Monitoring</h3>
            </div>
            <p style="color: #94a3b8; font-size: 0.95rem;">Track live exam progress, view active users, and detect irregularities with anti-cheating tools.</p>
        </div>

        <!-- 5. Evaluation -->
        <div class="stat-card" style="display: block; cursor: pointer;" onclick="window.location.href='/teacher/evaluation'">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="stat-icon" style="color: #10b981;">✅</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0;">Evaluation</h3>
            </div>
            <p style="color: #94a3b8; font-size: 0.95rem;">Auto-grade objective answers, manually grade essays, and provide detailed feedback to students.</p>
        </div>

        <!-- 6. Analytics -->
        <div class="stat-card" style="display: block; cursor: pointer;" onclick="window.location.href='/teacher/analytics'">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="stat-icon" style="color: #facc15;">📊</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0;">Analytics</h3>
            </div>
            <p style="color: #94a3b8; font-size: 0.95rem;">View class-wide performance stats, identify weak areas, and export results for reports.</p>
        </div>

        <!-- 7. Communication -->
        <div class="stat-card" style="display: block; cursor: pointer;" onclick="window.location.href='/teacher/communication'">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="stat-icon" style="color: #818cf8;">📢</div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: #f8fafc; margin: 0;">Communication</h3>
            </div>
            <p style="color: #94a3b8; font-size: 0.95rem;">Send announcements, exam instructions, reminders, and clarify doubts with students.</p>
        </div>

    </div>
</div>

</div> <!-- End Wrapper -->
</body>
</html>
