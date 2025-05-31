const CACHE_NAME = "proapponlinecache-v2";
const ASSETS_TO_CACHE = [
    "/fallback.html",
    "/assets/img/icon-online/48.png",
    "/assets/img/icon-online/50.png",
    "/assets/img/icon-online/55.png",
    "/assets/img/icon-online/57.png",
    "/assets/img/icon-online/58.png",
    "/assets/img/icon-online/60.png",
    "/assets/img/icon-online/64.png",
    "/assets/img/icon-online/66.png",
    "/assets/img/icon-online/72.png",
    "/assets/img/icon-online/76.png",
    "/assets/img/icon-online/80.png",
    "/assets/img/icon-online/87.png",
    "/assets/img/icon-online/88.png",
    "/assets/img/icon-online/92.png",
    "/assets/img/icon-online/100.png",
    "/assets/img/icon-online/102.png",
    "/assets/img/icon-online/108.png",
    "/assets/img/icon-online/114.png",
    "/assets/img/icon-online/120.png",
    "/assets/img/icon-online/128.png",
    "/assets/img/icon-online/144.png",
    "/assets/img/icon-online/152.png",
    "/assets/img/icon-online/167.png",
    "/assets/img/icon-online/172.png",
    "/assets/img/icon-online/180.png",
    "/assets/img/icon-online/192.png",
    "/assets/img/icon-online/196.png",
    "/assets/img/icon-online/216.png",
    "/assets/img/icon-online/234.png",
    "/assets/img/icon-online/256.png",
    "/assets/img/icon-online/258.png",
    "/assets/img/icon-online/512.png",
    "/assets/img/icon-online/1024.png"
];

// 📦 INSTALLATION & MISE EN CACHE
self.addEventListener("install", (event) => {
    console.log("📦 Installation du Service Worker de Probiynah Online...");
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
    self.skipWaiting(); // Activation immédiate
});

// 🚀 ACTIVATION & NETTOYAGE DE L'ANCIEN CACHE
self.addEventListener("activate", (event) => {
    console.log("✅ Service Worker de Probiynah Online activé !");
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log("🗑 Suppression de l'ancien cache :", cache);
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    self.clients.claim(); // Applique immédiatement le SW aux pages ouvertes
});

// 🔍 INTERCEPTION DES REQUÊTES
self.addEventListener("fetch", (event) => {
    console.log("🔍 Requête interceptée :", event.request.url);

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // 📌 Met en cache la réponse si elle est OK
                return caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, response.clone());
                    return response;
                });
            })
            .catch(() => {
                // 📌 Retourne le cache ou la page de secours si hors ligne
                return caches.match(event.request).then((cachedResponse) => {
                    return cachedResponse || caches.match("/fallback.html");
                });
            })
    );
});
