document.addEventListener('DOMContentLoaded', () => {
    // Animated background with enhanced visuals
    const canvas = document.getElementById('animated-bg');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let width, height, dpr;
        const particles = [];
        const PARTICLE_COUNT = 45; // More particles for richer background
        // Use a more vivid palette
        const COLOR1 = '#f3951f';
        const COLOR2 = '#ffd88a';
        const COLOR3 = '#ffc528';
        const COLOR4 = '#fff1db';
        const BG_GRADIENT = [
            { offset: 0, color: '#ffcf8b' },
            { offset: 0.5, color: '#fff4e6' },
            { offset: 1, color: '#ffe6cb' }
        ];
        const PARTICLE_RADIUS = [19, 38]; // Larger particles

        function resize() {
            dpr = window.devicePixelRatio || 1;
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width * dpr;
            canvas.height = height * dpr;
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(dpr, dpr);
        }

        function randomBetween(a, b) {
            return a + Math.random() * (b - a);
        }

        function randomColor() {
            const colorChoices = [COLOR1, COLOR2, COLOR3, COLOR4];
            return colorChoices[Math.floor(Math.random() * colorChoices.length)];
        }

        function createParticle() {
            const r = randomBetween(PARTICLE_RADIUS[0], PARTICLE_RADIUS[1]);
            return {
                x: randomBetween(0, width),
                y: randomBetween(0, height),
                r,
                baseR: r,
                pulse: randomBetween(0.7, 1.7),
                color: randomColor(),
                border: Math.random() > 0.7,
                speed: randomBetween(0.11, 0.46) * (Math.random() > 0.5 ? 1 : -1),
                angle: randomBetween(0, Math.PI * 2),
                vx: randomBetween(-0.14, 0.19),
                vy: randomBetween(-0.09, 0.12),
                floatFactor: randomBetween(0.6, 1.5)
            };
        }

        function drawGradientBg() {
            const grad = ctx.createLinearGradient(0, 0, width, height);
            BG_GRADIENT.forEach(stop => grad.addColorStop(stop.offset, stop.color));
            ctx.fillStyle = grad;
            ctx.fillRect(0, 0, width, height);

            // Add subtle radial highlights
            for (let i = 0; i < 3; i++) {
                const rx = width * randomBetween(0.1, 0.87);
                const ry = height * randomBetween(0.2, 0.7);
                const rMax = width * randomBetween(0.18, 0.27);
                const lightGrad = ctx.createRadialGradient(
                    rx, ry, 0,
                    rx, ry, rMax
                );
                lightGrad.addColorStop(0, '#fffdf5cc');
                lightGrad.addColorStop(1, '#ffffff00');
                ctx.beginPath();
                ctx.arc(rx, ry, rMax, 0, Math.PI * 2);
                ctx.fillStyle = lightGrad;
                ctx.fill();
            }
        }

        function drawParticle(p, t) {
            // Animate radius for organic effect
            let animR = p.baseR + Math.sin(t / 700 + p.angle + p.pulse) * (2.6 + p.pulse);

            ctx.save();
            ctx.globalAlpha = 0.31 + 0.23 * Math.sin(0.8 * t / 800 + p.r);
            // Glow
            const grad = ctx.createRadialGradient(
                p.x, p.y, 0,
                p.x, p.y, animR
            );
            grad.addColorStop(0, p.color + 'ff');
            grad.addColorStop(0.6, p.color + '77');
            grad.addColorStop(1, p.color + '00');
            ctx.beginPath();
            ctx.arc(
                p.x + Math.sin(t / 2300 * p.floatFactor + p.r) * 9,
                p.y + Math.cos(t / 3200 * p.floatFactor + p.r) * 10,
                animR,
                0, Math.PI * 2
            );
            ctx.fillStyle = grad;
            ctx.shadowColor = p.color;
            ctx.shadowBlur = 27;
            ctx.fill();
            ctx.restore();

            // Optionally draw border
            if (p.border) {
                ctx.save();
                ctx.beginPath();
                ctx.arc(
                    p.x + Math.sin(t / 2300 * p.floatFactor + p.r) * 9,
                    p.y + Math.cos(t / 3200 * p.floatFactor + p.r) * 10,
                    animR + 1.8,
                    0, Math.PI * 2
                );
                ctx.strokeStyle = '#fffbe7bb';
                ctx.lineWidth = 2.2;
                ctx.shadowColor = '#fffbe7';
                ctx.shadowBlur = 7;
                ctx.globalAlpha = 0.16;
                ctx.stroke();
                ctx.restore();
            }
        }

        function animate(t = 0) {
            drawGradientBg();
            for (const p of particles) {
                drawParticle(p, t);

                p.x += Math.sin(p.angle) * p.vx + 0.10 * p.speed;
                p.y += Math.cos(p.angle) * p.vy + Math.sin(t / 1700 + p.r) * 0.04;
                p.angle += 0.0006 * (Math.random() - 0.5);

                // Wrap: allow more gentle respawn for large particles
                if (p.x < -p.r) p.x = width + p.r * randomBetween(0.4, 1.1);
                if (p.x > width + p.r) p.x = -p.r * randomBetween(0.4, 1.1);
                if (p.y < -p.r) p.y = height + p.r * randomBetween(0.4, 1.1);
                if (p.y > height + p.r) p.y = -p.r * randomBetween(0.4, 1.1);
            }
            requestAnimationFrame(animate);
        }

        function initParticles() {
            particles.length = 0;
            for (let i = 0; i < PARTICLE_COUNT; i++) {
                particles.push(createParticle());
            }
        }

        window.addEventListener('resize', () => {
            resize();
            initParticles();
        });
        resize();
        initParticles();
        animate();
    }

    // Password visibility toggle
    const passwordInput = document.getElementById('password-pro-app');
    const togglePassword = document.getElementById('togglePassword');
    if (passwordInput && togglePassword) {
        const eyeIcon = togglePassword.querySelector('svg');
        const pupil = eyeIcon.querySelector('.pupil');
        const slash = eyeIcon.querySelector('.slash');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            // Animate icon: show/hide slash across the eye
            if (!isPassword) {
                slash.style.display = 'none';
                pupil.setAttribute('opacity', '0.55');
                togglePassword.title = "Afficher le mot de passe";
                togglePassword.setAttribute("aria-label", "Afficher le mot de passe");
            } else {
                slash.style.display = '';
                pupil.setAttribute('opacity', '0.34');
                togglePassword.title = "Masquer le mot de passe";
                togglePassword.setAttribute("aria-label", "Masquer le mot de passe");
            }
        });

        // Prevents loosing focus when clicking icon
        togglePassword.addEventListener('mousedown', e => e.preventDefault());
    }

    const passwordConfirmInput = document.getElementById('pass-confirm-pro-app');
    const togglePasswordConfirm = document.getElementById('toggleConfirmPassword');
    if (passwordConfirmInput && togglePasswordConfirm) {
        const eyeIcon = togglePasswordConfirm.querySelector('svg');
        const pupil = eyeIcon.querySelector('.pupil');
        const slash = eyeIcon.querySelector('.slash');

        togglePasswordConfirm.addEventListener('click', () => {
            const isPassword = passwordConfirmInput.type === 'password';
            passwordConfirmInput.type = isPassword ? 'text' : 'password';
            // Animate icon: show/hide slash across the eye
            if (!isPassword) {
                slash.style.display = 'none';
                pupil.setAttribute('opacity', '0.55');
                togglePasswordConfirm.title = "Afficher le mot de passe";
                togglePasswordConfirm.setAttribute("aria-label", "Afficher le mot de passe");
            } else {
                slash.style.display = '';
                pupil.setAttribute('opacity', '0.34');
                togglePasswordConfirm.title = "Masquer le mot de passe";
                togglePasswordConfirm.setAttribute("aria-label", "Masquer le mot de passe");
            }
        });

        // Prevents loosing focus when clicking icon
        togglePasswordConfirm.addEventListener('mousedown', e => e.preventDefault());
    }
});

// Loading animation
window.addEventListener('load', function () {
    setTimeout(function () {
        document.getElementById('preloader').style.opacity = '0';
        setTimeout(function () {
            document.getElementById('preloader').style.display = 'none';
        }, 500);
    }, 1000);
});

// Disable data copy
$(document).ready(function () {
    $('body').bind("cut copy", function (e) {
        e.preventDefault();
    });
})

// Prevent form submit on enter
$(document).on('keydown', function(e) {
    const tag = e.target.tagName.toLowerCase();
    const form = $(e.target).closest('form');

    if (e.key === 'Enter') {
      if (tag === 'input' || tag === 'select') {
        e.preventDefault();
        return false;
      }

      if (form.attr('id') === 'loginForm') {
        e.preventDefault();
        return false;
      }
    }
});