!function(){"use strict";const e=1625302603478,n="cache"+e,t=["/client/inject_styles.fe622066.js","/client/index.0ed6d511.js","/client/sectionWrapper.e85f03a0.js","/client/Hero.a4dd34a4.js","/client/ShortText.6bb5c387.js","/client/Calender.abadf40a.js","/client/Link.e4419525.js","/client/artcollection.672ce656.js","/client/foerderverein.45f283c8.js","/client/smallHero.a9df3ce4.js","/client/elternbeirat.18fb10c6.js","/client/schule.b949b1bd.js","/client/Input.ec502a97.js","/client/staffCard.9df1c169.js","/client/LongText.8459f99d.js","/client/EntriesFound.b7e247b4.js","/client/Button.a01b7f4c.js","/client/[slug].be279eb7.js","/client/Img.2a054bb6.js","/client/termine.404780f7.js","/client/mensa.06bef91d.js","/client/MensaCard.67229a5b.js","/client/article.16bf9465.js","/client/index.c926f223.js","/client/login.c6ed0475.js","/client/TopNav.2681359b.js","/client/TableEntries.974dd934.js","/client/table.8f7a7926.js","/client/index.c04bf46b.js","/client/client.897a0b43.js","/client/object.b0e10dc7.js","/client/index.23968c92.js","/client/EditComponent.373e5091.js","/client/[slug].cdd0b20b.js","/client/[slug].5427d597.js","/client/new.e522bb47.js","/client/index.7d664e3f.js","/client/ckeditor.76d5d8dc.js"].concat(["/service-worker-index.html","/162ed75b","/1f29596f","/2c2b2443","/4127dc36","/41310c11","/49d4de6c","/4ee78b79","/58c6a345","/613b0bb1","/6493ce02","/67e553c7","/706b4a03","/7427e59d","/7633e03c","/839fe223","/8862e994","/88ae0548","/8abcd42e","/8b442c34","/91e304f6","/94c596f6","/a2c45ab4","/a541bad7","/a76e8ca4","/aa50055c","/android-chrome-144x144.png","/android-chrome-36x36.png","/android-chrome-48x48.png","/android-chrome-72x72.png","/android-chrome-96x96.png","/apple-touch-icon-120x120-precomposed.png","/apple-touch-icon-120x120.png","/apple-touch-icon-60x60-precomposed.png","/apple-touch-icon-60x60.png","/apple-touch-icon-76x76-precomposed.png","/apple-touch-icon-76x76.png","/apple-touch-icon-precomposed.png","/apple-touch-icon.png","/arrow.svg","/browserconfig.xml","/c2ed2894","/c46d8f91","/c9b4bfdc","/ccb285","/cdf8fa6c","/ce302a5","/d2a6b98","/d335fea3","/design.svg","/diamond-pattern.png","/eff8c507","/emoji_events.svg","/f7b6747d","/f93690f6","/favicon-16x16.png","/favicon-32x32.png","/favicon.ico","/MaterialIcons-Regular.ttf","/mstile-144x144.png","/mstile-150x150.png","/mstile-310x150.png","/mstile-310x310.png","/mstile-70x70.png","/open-sans-v17-latin-300.eot","/open-sans-v17-latin-300.svg","/open-sans-v17-latin-300.ttf","/open-sans-v17-latin-300.woff","/open-sans-v17-latin-300.woff2","/open-sans-v17-latin-300italic.eot","/open-sans-v17-latin-300italic.svg","/open-sans-v17-latin-300italic.ttf","/open-sans-v17-latin-300italic.woff","/open-sans-v17-latin-300italic.woff2","/open-sans-v17-latin-600.eot","/open-sans-v17-latin-600.svg","/open-sans-v17-latin-600.ttf","/open-sans-v17-latin-600.woff","/open-sans-v17-latin-600.woff2","/open-sans-v17-latin-600italic.eot","/open-sans-v17-latin-600italic.svg","/open-sans-v17-latin-600italic.ttf","/open-sans-v17-latin-600italic.woff","/open-sans-v17-latin-600italic.woff2","/open-sans-v17-latin-italic.eot","/open-sans-v17-latin-italic.svg","/open-sans-v17-latin-italic.ttf","/open-sans-v17-latin-italic.woff","/open-sans-v17-latin-italic.woff2","/open-sans-v17-latin-regular.eot","/open-sans-v17-latin-regular.svg","/open-sans-v17-latin-regular.ttf","/open-sans-v17-latin-regular.woff","/open-sans-v17-latin-regular.woff2","/paid.svg","/rect-pattern.png","/safari-pinned-tab.svg","/site.webmanifest","/sort.svg"]),a=new Set(t);self.addEventListener("install",e=>{e.waitUntil(caches.open(n).then(e=>e.addAll(t)).then(()=>{self.skipWaiting()}))}),self.addEventListener("activate",e=>{e.waitUntil(caches.keys().then(async e=>{e.forEach(async e=>{e!==n&&await caches.delete(e)}),self.clients.claim()}))}),self.addEventListener("fetch",n=>{if("GET"!==n.request.method||n.request.headers.has("range"))return;const t=new URL(n.request.url);t.protocol.startsWith("http")&&(t.hostname===self.location.hostname&&t.port!==self.location.port||(t.host===self.location.host&&a.has(t.pathname)?n.respondWith(caches.match(n.request)):"only-if-cached"!==n.request.cache&&n.respondWith(caches.open("offline"+e).then(async e=>{try{const t=await fetch(n.request);return e.put(n.request,t.clone()),t}catch(t){const a=await e.match(n.request);if(a)return a;throw t}}))))})}();
