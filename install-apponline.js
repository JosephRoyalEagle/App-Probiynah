// ✅ Enregistrer le Service Worker
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw-apponline/sw-apponline.js', { scope: '/' })
    .then(reg => console.log("✅ Service Worker de Probiynah Online enregistré !", reg))
    .catch(err => console.error("❌ Erreur Service Worker de Probiynah Online :", err));
}

// ✅ Ajouter les styles globaux (une seule fois)
let style = document.createElement('style');
style.innerHTML = `
    @keyframes borderGlow {
        0% { border-color: #f3951f; } /* Orange */
        100% { border-color: #56b8e6; } /* Bleu */
    }
    .install-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 400px;
        padding: 20px;
        background: #1b2f45;
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        text-align: center;
        font-family: Arial, sans-serif;
        border: 3px solid transparent;
        animation: borderGlow 1.5s infinite alternate;
        z-index: 9999;
    }
    .install-title {
        margin: 0;
        color: #f3951f;
        font-size: 18px;
    }
    .install-text {
        font-size: 14px;
        margin: 10px 0;
    }
    .install-btn {
        background: linear-gradient(45deg, #f3951f, #56b8e6);
        color: #fff;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s ease, opacity 0.3s ease;
    }
    .install-btn:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }
    .install-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
        color: #fff;
        opacity: 0.7;
    }
`;
document.head.appendChild(style);

// ✅ Détecter iOS et afficher une bannière d'information
function isIos() {
    return /iphone|ipad|ipod|macintosh/i.test(navigator.userAgent) && /AppleWebKit/i.test(navigator.userAgent);
}

function isInStandaloneMode() {
    return ('standalone' in window.navigator) && (window.navigator.standalone);
}

if (isIos() && !isInStandaloneMode()) {
    showIosInstallBanner();
}

// ✅ Gérer l'installation en PWA pour Android & Chrome
let deferredPrompt = null;
if (window.matchMedia('(display-mode: standalone)').matches) {
    console.log("✅ L'application Probiynah Online est déjà installée !");
} else {
    console.log("ℹ️ L'application Probiynah Online n'est pas installée, attente d'une interaction utilisateur...");

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        deferredPrompt = event;

        if (!localStorage.getItem("pwaInstalled-proapponline")) {
            document.addEventListener("click", triggerInstallPrompt, { once: true });
            document.addEventListener("scroll", triggerInstallPrompt, { once: true });
        }
    });
}

function triggerInstallPrompt() {
    console.log("📢 Interaction détectée, affichage de la bannière !");
    showInstallPwaRestoPrompt();
}

// ✅ Créer une bannière générique
function createInstallBanner(message, buttonText, buttonAction) {
    let installContainer = document.createElement('div');
    installContainer.classList.add("install-container");

    let title = document.createElement('h3');
    title.classList.add("install-title");
    title.innerText = "⚡ APP PROBIYNAH ONLINE";

    let text = document.createElement('p');
    text.classList.add("install-text");
    text.innerHTML = message;

    let installButton = document.createElement('button');
    installButton.innerText = buttonText;
    installButton.classList.add("install-btn");
    installButton.addEventListener('click', () => {
        buttonAction();
        installContainer.remove();
    });

    let closeButton = document.createElement('span');
    closeButton.innerHTML = "&times;";
    closeButton.classList.add("install-close");
    closeButton.addEventListener('click', () => {
        installContainer.remove();
    });

    installContainer.appendChild(closeButton);
    installContainer.appendChild(title);
    installContainer.appendChild(text);
    installContainer.appendChild(installButton);
    document.body.appendChild(installContainer);
}

// ✅ Afficher la bannière d'installation Android/Chrome
function showInstallPwaRestoPrompt() {
    if (!deferredPrompt) return;

    createInstallBanner(
        "Installez l'application Probiynah Online sur votre appareil pour gerer vos actifs en un clic !",
        "📲 Installer l'App",
        () => {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log("✅ L'utilisateur a installé l'App !");
                    localStorage.setItem("pwaInstalled-proapponline", "true");
                }
            });
        }
    );
}

// ✅ Afficher la fausse bannière iOS
function showIosInstallBanner() {
    createInstallBanner(
        "📲 <b>Ajoutez l'application Probiynah Online à votre écran d'accueil pour gerer vos actifs en un clic !</b><br>Dans votre navigateur, cliquez sur l'icône <b>Partager</b> et sélectionnez <b>« Ajouter à l’écran d’accueil »</b>.",
        "✅ J'ai compris",
        () => console.log("ℹ️ Bannière iOS fermée")
    );
}