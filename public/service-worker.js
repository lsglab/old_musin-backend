!(function () {
    "use strict";
    const e = 1630316266513,
        n = "cache" + e,
        t = [
            "/client/inject_styles.fe622066.js",
            "/client/index.24bd224e.js",
            "/client/Hero.9748ec6f.js",
            "/client/sectionWrapper.021a7167.js",
            "/client/ShortText.a7f2201b.js",
            "/client/Calender.b1fcdbf4.js",
            "/client/Link.22fe7699.js",
            "/client/Calender.8059e875.js",
            "/client/Link.031e03ed.js",
            "/client/EditLink.3b2ee2e0.js",
            "/client/Input.4008d043.js",
            "/client/time.4604e9c6.js",
            "/client/artcollection.53d855b7.js",
            "/client/foerderverein.05179c81.js",
            "/client/smallHero.e3f45f5c.js",
            "/client/task.5ef6c252.js",
            "/client/Img.0fbc29a2.js",
            "/client/EntriesFound.43f98531.js",
            "/client/Button.2bcc924f.js",
            "/client/SelectMedia.b05e5081.js",
            "/client/Button.b7be2151.js",
            "/client/elternbeirat.e65af9d8.js",
            "/client/schule.51ff66e3.js",
            "/client/staffCard.66799a74.js",
            "/client/Card.f7d30f22.js",
            "/client/LongText.2bd23b13.js",
            "/client/bioCard.1d2c34a5.js",
            "/client/Card.51317e65.js",
            "/client/ckeditor.2d30aedc.js",
            "/client/[slug].e4f96bb3.js",
            "/client/Input.4fa681f6.js",
            "/client/article.284b9341.js",
            "/client/client.d318fd62.js",
            "/client/mensa.5b6c746d.js",
            "/client/termine.a222a5b7.js",
            "/client/MensaCard.025c8ceb.js",
            "/client/Footer.914e3f26.js",
            "/client/base.c039ad26.js",
            "/client/test.8e251b76.js",
            "/client/index.cf7b1b51.js",
            "/client/TopNav.46e45292.js",
            "/client/login.eee33ab7.js",
            "/client/index.be8536b0.js",
            "/client/index.15f7d5f8.js",
            "/client/[slug].9d4111c0.js",
            "/client/TableEntries.d496c925.js",
            "/client/GoBack.06029f74.js",
            "/client/EditComponent.c760dda3.js",
            "/client/table.04872dd2.js",
            "/client/index.b323a715.js",
            "/client/SiteBuilder.1003339a.js",
            "/client/object.eaba1416.js",
            "/client/[slug].8ba011f4.js",
            "/client/[slug].5ec7c950.js",
            "/client/index.420b64e3.js",
            "/client/index.5f47af04.js",
            "/client/new.9c16e0e5.js",
            "/client/ckeditor.0b681da3.js",
        ].concat([
            "/service-worker-index.html",
            "/android-chrome-144x144.png",
            "/android-chrome-36x36.png",
            "/android-chrome-48x48.png",
            "/android-chrome-72x72.png",
            "/android-chrome-96x96.png",
            "/apple-touch-icon-120x120-precomposed.png",
            "/apple-touch-icon-120x120.png",
            "/apple-touch-icon-60x60-precomposed.png",
            "/apple-touch-icon-60x60.png",
            "/apple-touch-icon-76x76-precomposed.png",
            "/apple-touch-icon-76x76.png",
            "/apple-touch-icon-precomposed.png",
            "/apple-touch-icon.png",
            "/arrow.svg",
            "/browserconfig.xml",
            "/design.svg",
            "/diamond-pattern.png",
            "/emoji_events.svg",
            "/favicon-16x16.png",
            "/favicon-32x32.png",
            "/favicon.ico",
            "/MaterialIcons-Regular.ttf",
            "/mstile-144x144.png",
            "/mstile-150x150.png",
            "/mstile-310x150.png",
            "/mstile-310x310.png",
            "/mstile-70x70.png",
            "/open-sans-v17-latin-300.eot",
            "/open-sans-v17-latin-300.svg",
            "/open-sans-v17-latin-300.ttf",
            "/open-sans-v17-latin-300.woff",
            "/open-sans-v17-latin-300.woff2",
            "/open-sans-v17-latin-300italic.eot",
            "/open-sans-v17-latin-300italic.svg",
            "/open-sans-v17-latin-300italic.ttf",
            "/open-sans-v17-latin-300italic.woff",
            "/open-sans-v17-latin-300italic.woff2",
            "/open-sans-v17-latin-600.eot",
            "/open-sans-v17-latin-600.svg",
            "/open-sans-v17-latin-600.ttf",
            "/open-sans-v17-latin-600.woff",
            "/open-sans-v17-latin-600.woff2",
            "/open-sans-v17-latin-600italic.eot",
            "/open-sans-v17-latin-600italic.svg",
            "/open-sans-v17-latin-600italic.ttf",
            "/open-sans-v17-latin-600italic.woff",
            "/open-sans-v17-latin-600italic.woff2",
            "/open-sans-v17-latin-italic.eot",
            "/open-sans-v17-latin-italic.svg",
            "/open-sans-v17-latin-italic.ttf",
            "/open-sans-v17-latin-italic.woff",
            "/open-sans-v17-latin-italic.woff2",
            "/open-sans-v17-latin-regular.eot",
            "/open-sans-v17-latin-regular.svg",
            "/open-sans-v17-latin-regular.ttf",
            "/open-sans-v17-latin-regular.woff",
            "/open-sans-v17-latin-regular.woff2",
            "/paid.svg",
            "/pdf.svg",
            "/rect-pattern.png",
            "/safari-pinned-tab.svg",
            "/site.webmanifest",
            "/sort.svg",
        ]),
        s = new Set(t);
    self.addEventListener("install", (e) => {
        e.waitUntil(
            caches
                .open(n)
                .then((e) => e.addAll(t))
                .then(() => {
                    self.skipWaiting();
                })
        );
    }),
        self.addEventListener("activate", (e) => {
            e.waitUntil(
                caches.keys().then(async (e) => {
                    e.forEach(async (e) => {
                        e !== n && (await caches.delete(e));
                    }),
                        self.clients.claim();
                })
            );
        }),
        self.addEventListener("fetch", (n) => {
            if ("GET" !== n.request.method || n.request.headers.has("range"))
                return;
            const t = new URL(n.request.url);
            t.protocol.startsWith("http") &&
                ((t.hostname === self.location.hostname &&
                    t.port !== self.location.port) ||
                    (t.host === self.location.host && s.has(t.pathname)
                        ? n.respondWith(caches.match(n.request))
                        : "only-if-cached" !== n.request.cache &&
                          n.respondWith(
                              caches.open("offline" + e).then(async (e) => {
                                  try {
                                      const t = await fetch(n.request);
                                      return e.put(n.request, t.clone()), t;
                                  } catch (t) {
                                      const s = await e.match(n.request);
                                      if (s) return s;
                                      throw t;
                                  }
                              })
                          )));
        });
})();
