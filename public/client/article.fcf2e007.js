function t(t,e,n){const s=t.slice();return s[19]=e[n],s[21]=n,s}function e(t){let e,s;return e=new D({props:{justify:"center",classes:"w-full h-inherit",$$slots:{default:[n]},$$scope:{ctx:t}}}),{c(){w(e.$$.fragment)},l(t){x(e.$$.fragment,t)},m(t,n){S(e,t,n),s=!0},p(t,n){const s={};16386&n&&(s.$$scope={dirty:n,ctx:t}),e.$set(s)},i(t){s||(I(e.$$.fragment,t),s=!0)},o(t){z(e.$$.fragment,t),s=!1},d(t){G(e,t)}}}function n(t){let e,n,s;return{c(){e=H("img"),this.h()},l(t){e=N(t,"IMG",{id:!0,class:!0,src:!0,alt:!0}),this.h()},h(){P(e,"id",n=t[1].img.id),P(e,"class","object-cover w-full h-full rounded-md shadow-equal lg:w-auto"),e.src!==(s=t[1].img.data)&&P(e,"src",s),P(e,"alt","")},m(t,n){k(t,e,n)},p(t,a){2&a&&n!==(n=t[1].img.id)&&P(e,"id",n),2&a&&e.src!==(s=t[1].img.data)&&P(e,"src",s)},d(t){t&&L(e)}}}function s(t){let e,n,s,a,r,l,i,c,o,d=t[1].header.data+"",g=t[1].subHeader.data+"";return{c(){e=H("div"),n=H("h3"),s=V(d),r=y(),l=H("p"),i=V(g),this.h()},l(t){var a,c,o;e=N(t,"DIV",{class:!0}),a=F(e),n=N(a,"H3",{class:!0,id:!0}),c=F(n),s=_(c,d),c.forEach(L),r=v(a),l=N(a,"P",{class:!0,id:!0}),o=F(l),i=_(o,g),o.forEach(L),a.forEach(L),this.h()},h(){P(n,"class","text-2xl text-heading md:text-2.5xl"),P(n,"id",a=t[1].header.id),P(l,"class","mt-3 text-heading2"),P(l,"id",c=t[1].subHeader.id),P(e,"class",o="m-8 "+(t[0]?"text-center":"text-left ml-0"))},m(t,a){k(t,e,a),C(e,n),C(n,s),C(e,r),C(e,l),C(l,i)},p(t,r){2&r&&d!==(d=t[1].header.data+"")&&q(s,d),2&r&&a!==(a=t[1].header.id)&&P(n,"id",a),2&r&&g!==(g=t[1].subHeader.data+"")&&q(i,g),2&r&&c!==(c=t[1].subHeader.id)&&P(l,"id",c),1&r&&o!==(o="m-8 "+(t[0]?"text-center":"text-left ml-0"))&&P(e,"class",o)},d(t){t&&L(e)}}}function a(t){let n,a,r,l,i,c,o,d=!1!==t[0]&&e(t);return l=new D({props:{justify:t[0]?"center":"start",align:"center",classes:"w-full h-full",$$slots:{default:[s]},$$scope:{ctx:t}}}),{c(){n=H("div"),d&&d.c(),a=y(),r=H("div"),w(l.$$.fragment),this.h()},l(t){var e,s;n=N(t,"DIV",{class:!0}),e=F(n),d&&d.l(e),a=v(e),r=N(e,"DIV",{class:!0}),s=F(r),x(l.$$.fragment,s),s.forEach(L),e.forEach(L),this.h()},h(){P(r,"class",i=B(t[0]?"w-auto":"article-width justify-self-end")+" svelte-1nn7v02"),P(n,"class",c="flex flex-col-reverse justify-center transition-none align-center article lg:grid "+(t[0]?"lg:grid-cols-2 lg:h-80":"lg:grid-cols-1 h-52"))},m(t,e){k(t,n,e),d&&d.m(n,null),C(n,a),C(n,r),S(l,r,null),o=!0},p(t,s){!1!==t[0]?d?(d.p(t,s),1&s&&I(d,1)):(d=e(t),d.c(),I(d,1),d.m(n,a)):d&&(J(),z(d,1,1,()=>{d=null}),M());const g={};1&s&&(g.justify=t[0]?"center":"start"),16387&s&&(g.$$scope={dirty:s,ctx:t}),l.$set(g),(!o||1&s&&i!==(i=B(t[0]?"w-auto":"article-width justify-self-end")+" svelte-1nn7v02"))&&P(r,"class",i),(!o||1&s&&c!==(c="flex flex-col-reverse justify-center transition-none align-center article lg:grid "+(t[0]?"lg:grid-cols-2 lg:h-80":"lg:grid-cols-1 h-52")))&&P(n,"class",c)},i(t){o||(I(d),I(l.$$.fragment,t),o=!0)},o(t){z(d),z(l.$$.fragment,t),o=!1},d(t){t&&L(n),d&&d.d(),G(l)}}}function r(){let t,e,n,s;return{c(){t=H("h5"),e=V("INHALTSVERZEICHNIS"),n=y(),s=H("div"),this.h()},l(a){t=N(a,"H5",{class:!0});var r=F(t);e=_(r,"INHALTSVERZEICHNIS"),r.forEach(L),n=v(a),s=N(a,"DIV",{class:!0}),F(s).forEach(L),this.h()},h(){P(t,"class","text-lg truncate text-heading"),P(s,"class","w-8 h-8 bg-center bg-auto cursor-pointer arrow lg:hidden xl:hidden bg-arrowIcon svelte-1nn7v02")},m(a,r){k(a,t,r),C(t,e),k(a,n,r),k(a,s,r)},d(e){e&&L(t),e&&L(n),e&&L(s)}}}function l(t){let e,n,s,a,r,l,i,c,o,d,g,h=t[21]+1+"",p=t[19].header+"";return{c(){e=H("li"),n=H("a"),s=V(h),a=V(". "),r=V(p),i=y(),this.h()},l(t){var l,c;e=N(t,"LI",{class:!0,id:!0}),l=F(e),n=N(l,"A",{class:!0,href:!0}),c=F(n),s=_(c,h),a=_(c,". "),r=_(c,p),c.forEach(L),i=v(l),l.forEach(L),this.h()},h(){P(n,"class","lg:text-sm"),P(n,"href",l="article/#sect"+t[21]),P(e,"class",c="my-4 lg:my-3 font-semibold list-none cursor-pointer tracking-wide\n\t\t\t\t\t\t\t\t\t\t"+(t[4]!==t[21]?"":"text-blue-400 list-square")),P(e,"id",o=t[21])},m(l,c){k(l,e,c),C(e,n),C(n,s),C(n,a),C(n,r),C(e,i),d||(g=E(n,"click",t[13]),d=!0)},p(t,n){16&n&&c!==(c="my-4 lg:my-3 font-semibold list-none cursor-pointer tracking-wide\n\t\t\t\t\t\t\t\t\t\t"+(t[4]!==t[21]?"":"text-blue-400 list-square"))&&P(e,"class",c)},d(t){t&&L(e),d=!1,g()}}}function i(e){let n,s,a,i,c;s=new D({props:{justify:"between",wrap:"true",align:"center",$$slots:{default:[r]},$$scope:{ctx:e}}});let o=e[6],d=[];for(let n=0;n<o.length;n+=1)d[n]=l(t(e,o,n));return{c(){n=H("label"),w(s.$$.fragment),a=y(),i=H("ul");for(let t=0;t<d.length;t+=1)d[t].c();this.h()},l(t){var e,r;n=N(t,"LABEL",{for:!0,class:!0}),e=F(n),x(s.$$.fragment,e),e.forEach(L),a=v(t),i=N(t,"UL",{class:!0}),r=F(i);for(let t=0;t<d.length;t+=1)d[t].l(r);r.forEach(L),this.h()},h(){P(n,"for","table-checkbox"),P(n,"class","cursor-pointer svelte-1nn7v02"),P(i,"class","pl-4 overflow-hidden opacity-0 content-table-ul transition-300 lg:opacity-100 xl:opacity-100 max-h-0 lg:max-h-full xl:max-h-full svelte-1nn7v02")},m(t,e){k(t,n,e),S(s,n,null),k(t,a,e),k(t,i,e);for(let t=0;t<d.length;t+=1)d[t].m(i,null);c=!0},p(e,n){const a={};if(16384&n&&(a.$$scope={dirty:n,ctx:e}),s.$set(a),112&n){let s;for(o=e[6],s=0;s<o.length;s+=1){const a=t(e,o,s);d[s]?d[s].p(a,n):(d[s]=l(a),d[s].c(),d[s].m(i,null))}for(;s<d.length;s+=1)d[s].d(1);d.length=o.length}},i(t){c||(I(s.$$.fragment,t),c=!0)},o(t){z(s.$$.fragment,t),c=!1},d(t){t&&L(n),G(s),t&&L(a),t&&L(i),U(d,t)}}}function c(t){let e,n,s,a,r,l,i,c=function(t){let e;t.forEach(t=>{e+=t.html});const n=e.replace(/[^\w ]/g,"").split(/\s+/).length;return Math.floor(n/228)+1+" Min. Lesezeit"}(t[6])+"";return{c(){e=R("svg"),n=R("path"),s=R("path"),a=R("path"),r=y(),l=H("p"),i=V(c),this.h()},l(t){var o,d;e=N(t,"svg",{class:!0,xmlns:!0,height:!0,viewBox:!0,width:!0},1),o=F(e),n=N(o,"path",{d:!0,fill:!0},1),F(n).forEach(L),s=N(o,"path",{d:!0},1),F(s).forEach(L),a=N(o,"path",{d:!0},1),F(a).forEach(L),o.forEach(L),r=v(t),l=N(t,"P",{}),d=F(l),i=_(d,c),d.forEach(L),this.h()},h(){P(n,"d","M0 0h24v24H0z"),P(n,"fill","none"),P(s,"d","M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"),P(a,"d","M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"),P(e,"class","w-5 h-5 mr-1"),P(e,"xmlns","http://www.w3.org/2000/svg"),P(e,"height","24"),P(e,"viewBox","0 0 24 24"),P(e,"width","24")},m(t,c){k(t,e,c),C(e,n),C(e,s),C(e,a),k(t,r,c),k(t,l,c),C(l,i)},p:W,d(t){t&&L(e),t&&L(r),t&&L(l)}}}function o(t){let e,n,s,a,r,l,o,d,g,h,p,u,f,m,$,T,j,A;r=new b({props:{customStyles:t[2]?"":"padding: 0px",classes:"lg:px-unset xl:px-unset 2xl:px-unset",$$slots:{default:[i]},$$scope:{ctx:t}}}),p=new D({props:{align:"center",classes:"border-b border-solid border-gray-500 pb-1",$$slots:{default:[c]},$$scope:{ctx:t}}});const J=t[9].default,M=K(J,t,t[14],tt);return{c(){e=H("div"),n=H("input"),s=y(),a=H("div"),w(r.$$.fragment),d=y(),g=H("div"),h=H("div"),w(p.$$.fragment),u=y(),f=H("p"),m=V("Letzte Aktualisierung am 28.10.2020"),$=y(),M&&M.c(),this.h()},l(t){var l,i,c,o,b;e=N(t,"DIV",{class:!0,id:!0}),l=F(e),n=N(l,"INPUT",{class:!0,type:!0,id:!0}),s=v(l),a=N(l,"DIV",{class:!0}),i=F(a),x(r.$$.fragment,i),i.forEach(L),l.forEach(L),d=v(t),g=N(t,"DIV",{class:!0}),c=F(g),h=N(c,"DIV",{class:!0}),o=F(h),x(p.$$.fragment,o),u=v(o),f=N(o,"P",{class:!0}),b=F(f),m=_(b,"Letzte Aktualisierung am 28.10.2020"),b.forEach(L),o.forEach(L),$=v(c),M&&M.l(c),c.forEach(L),this.h()},h(){P(n,"class","hidden"),P(n,"type","checkbox"),P(n,"id","table-checkbox"),P(a,"class",l=B(t[2]?"relative left-center lg:left-0 w-screen lg:w-auto mobile-sticky top-0 bg-white lg:py-0 py-2 table-transition shadow-xl lg:shadow-none":"")+" svelte-1nn7v02"),P(e,"class",o="sticky lg:mr-4 top-0 z-10 w-full bg-white rounded-md table-transition lg:top-4 lg:p-4 lg:shadow-equal lg:m-0 lg:w-auto h-min-content "+(t[2]?"py-0":"py-4")+"  svelte-1nn7v02"),P(e,"id","content-table"),P(f,"class","text-sm text-gray-700"),P(h,"class","mt-2 -mb-5"),P(g,"class","article-width lg:ml-4 svelte-1nn7v02")},m(l,i){k(l,e,i),C(e,n),n.checked=t[5],C(e,s),C(e,a),S(r,a,null),k(l,d,i),k(l,g,i),C(g,h),S(p,h,null),C(h,u),C(h,f),C(f,m),C(g,$),M&&M.m(g,null),T=!0,j||(A=E(n,"change",t[12]),j=!0)},p(t,s){32&s&&(n.checked=t[5]);const i={};4&s&&(i.customStyles=t[2]?"":"padding: 0px"),16432&s&&(i.$$scope={dirty:s,ctx:t}),r.$set(i),(!T||4&s&&l!==(l=B(t[2]?"relative left-center lg:left-0 w-screen lg:w-auto mobile-sticky top-0 bg-white lg:py-0 py-2 table-transition shadow-xl lg:shadow-none":"")+" svelte-1nn7v02"))&&P(a,"class",l),(!T||4&s&&o!==(o="sticky lg:mr-4 top-0 z-10 w-full bg-white rounded-md table-transition lg:top-4 lg:p-4 lg:shadow-equal lg:m-0 lg:w-auto h-min-content "+(t[2]?"py-0":"py-4")+"  svelte-1nn7v02"))&&P(e,"class",o);const c={};16384&s&&(c.$$scope={dirty:s,ctx:t}),p.$set(c),M&&M.p&&16384&s&&O(M,J,t,t[14],s,Q,tt)},i(t){T||(I(r.$$.fragment,t),I(p.$$.fragment,t),I(M,t),T=!0)},o(t){z(r.$$.fragment,t),z(p.$$.fragment,t),z(M,t),T=!1},d(t){t&&L(e),G(r),t&&L(d),t&&L(g),G(p),M&&M.d(t),j=!1,A()}}}function d(t){let e,n,s;return n=new D({props:{justify:"between",wrap:"true",classes:"m-auto lg:flex-nowrap",$$slots:{default:[o]},$$scope:{ctx:t}}}),{c(){e=H("div"),w(n.$$.fragment),this.h()},l(t){e=N(t,"DIV",{class:!0});var s=F(e);x(n.$$.fragment,s),s.forEach(L),this.h()},h(){P(e,"class","w-full svelte-1nn7v02")},m(t,a){k(t,e,a),S(n,e,null),s=!0},p(t,e){const s={};16436&e&&(s.$$scope={dirty:e,ctx:t}),n.$set(s)},i(t){s||(I(n.$$.fragment,t),s=!0)},o(t){z(n.$$.fragment,t),s=!1},d(t){t&&L(e),G(n)}}}function g(t){let e,n,s,r,l,i,c,o=!1,g=()=>{o=!1};return $(t[11]),n=new b({props:{classes:"mb-10 mt-5",$$slots:{default:[a]},$$scope:{ctx:t}}}),r=new b({props:{classes:"dashedTopBorder pb-20",$$slots:{default:[d]},$$scope:{ctx:t}}}),{c(){w(n.$$.fragment),s=y(),w(r.$$.fragment)},l(t){x(n.$$.fragment,t),s=v(t),x(r.$$.fragment,t)},m(a,d){S(n,a,d),k(a,s,d),S(r,a,d),l=!0,i||(c=[E(Y,"scroll",t[10]),E(Y,"scroll",()=>{o=!0,clearTimeout(e),e=setTimeout(g,100),t[11]()})],i=!0)},p(t,[s]){8&s&&!o&&(o=!0,clearTimeout(e),scrollTo(Y.pageXOffset,t[3]),e=setTimeout(g,100));const a={};16387&s&&(a.$$scope={dirty:s,ctx:t}),n.$set(a);const l={};16436&s&&(l.$$scope={dirty:s,ctx:t}),r.$set(l)},i(t){l||(I(n.$$.fragment,t),I(r.$$.fragment,t),l=!0)},o(t){z(n.$$.fragment,t),z(r.$$.fragment,t),l=!1},d(t){G(n,t),t&&L(s),G(r,t),i=!1,T(c)}}}function h(t){let e=0,n=t;for(;n;)e+=n.offsetTop,n=n.offsetParent;return e}function p(t,e,n){function s(){f&&(null==a?a=h(document.getElementById("content-table")):r>=a&&!1===g?n(2,g=!0):r<=a&&!0===g&&n(2,g=!1),function(){let t=document.body.scrollTop||document.documentElement.scrollTop;const e=document.getElementsByClassName("art-content-sect");t+=Math.max(document.documentElement.clientHeight||0,window.innerHeight||0)/4;for(let s=0;s<Object.keys(e).length;s+=1){const a=h(e[s.toString()]),r=s!==Object.keys(e).length-1?h(e[""+(s+1)]):t+1;if(t>a&&t<r)return void n(4,p=s)}}())}let a,r,l,{$$slots:i={},$$scope:c}=e,{img:o=!0}=e,{blueprint:d={header:new Z("Titel"),img:new X("https://i.stack.imgur.com/y9DpT.jpg"),subHeader:new Z("sub Header")}}=e,g=!1,p=0,u=!1,f=!1;return j(()=>{f=!0}),t.$$set=t=>{"img"in t&&n(0,o=t.img),"blueprint"in t&&n(1,d=t.blueprint),"$$scope"in t&&n(14,c=t.$$scope)},console.log("slotBlueprint",l),[o,d,g,r,p,u,[{header:"Ausbildungsrichtungen",html:'<meta itemprop="inLanguage" content="de-DE"><div class="page-header"></div><div itemprop="articleBody"><p>Am LSG werden die Ausbildungsrichtung Naturwissenschaftlich-Technologisches Gymnasium (NTG) mit der Sprachenfolge Englisch-Französisch oder Englisch-Latein und die Ausbildungsrichtung Sprachliches Gymnasium (SG) mit der Sprachenfolge Englisch-Latein-Italienisch oder Englisch-Französisch-Italienisch angeboten. <a href="http://www.isb.bayern.de/schulartspezifisches/lehrplan/gymnasium/" target="_blank">(Lehrpläne)<br></a>Die (<a href="/homepage/images/schulverwaltung/unterricht/wahlzweitefremdspracheFranz.pdf" target="_blank">Französisch</a> oder <a href="/homepage/images/schulverwaltung/unterricht/WahlzweiteFremdspracheLatein.pdf" target="_blank">Latein</a>) wird in Jahrgangsstufe 5, die Ausbildungsrichtung (NTG, SG) in Jahrgangsstufe 7 gewählt.</p><br><p><strong><span>Unterschiede</span>:</strong></p><p>In den Jahrgangsstufen 6 und 7 unterscheiden sich SG und NTG am LSG in der 2. Fremdsprache <a href="/homepage/images/schulverwaltung/unterricht/WahlzweiteFremdspracheLatein.pdf" target="_blank">Latein</a> oder <a href="/homepage/images/schulverwaltung/unterricht/wahlzweitefremdspracheFranz.pdf" target="_blank">Französisch</a>. Ab Jahrgangstufe 8 beginnt die eigentliche Differenzierung der Ausbildungsrichtungen.</p><table style="" border="1"><caption>&nbsp;</caption><tbody style="text-align: left;"><tr style="text-align: left;"><td style="text-align: left;"><span><strong>Unterschied</strong> in Wochenstunden</span><br><span>(am LSG)</span></td><td style="text-align: left;"><span><strong>Sprachliches Gymnasium </strong></span><span><strong>SG</strong></span></td><td colspan="3" style="text-align: left;"><span><strong>Naturwissenschaftlich - technologisches&nbsp; Gymnasium </strong></span><span><strong>NTG</strong></span></td></tr><tr style="text-align: left;"><td style="text-align: center;"><span>Jahrgangsstufe </span><span> (JgSt.)</span></td><td style="text-align: center;"><span><strong>Italienisch</strong></span></td><td style="text-align: center;"><span><strong>Physik</strong></span><span>(Profilstunde)</span></td><td style="text-align: center;"><span><strong>Chemie</strong></span><span>(Profilstunde)</span></td><td style="text-align: center;"><span><strong>Informatik</strong></span></td></tr><tr style="text-align: left;"><td style="text-align: center;"><span><strong>8</strong></span></td><td style="text-align: center;"><span>4 Std</span></td><td style="text-align: center;"><span>1 Std</span></td><td style="text-align: center;"><span>3 Std</span></td><td style="text-align: center;"><span>./.</span></td></tr><tr style="text-align: left;"><td style="text-align: center;"><span><strong>9</strong></span></td><td style="text-align: center;"><span>4 Std</span></td><td style="text-align: center;"><span>1 Std</span></td><td style="text-align: center;"><span>1 Std</span></td><td style="text-align: center;"><span>2 Std</span></td></tr><tr style="text-align: left;"><td style="text-align: center;"><span><strong>10</strong></span></td><td style="text-align: center;"><span>4 Std</span></td><td style="text-align: center;"><span>1 Std</span></td><td style="text-align: center;"><span>1 Std</span></td><td style="text-align: center;"><span>2 Std</span></td></tr></tbody></table><p>&nbsp;</p><p><strong><span>Anmerkungen </span></strong>(Stundentafeln<span class="external"> </span><a href="http://www.gesetze-bayern.de/Content/Document/BayGSO-ANL_1" target="_blank" rel="noopener noreferrer" class="external">Mittelstufe</a> und <a href="http://www.gymnasiale-oberstufe.bayern.de/faecherwahl-und-belegung/faecherwahl-q1112/erlaeuterungen-zur-stundentafel.html" target="_blank">Oberstufe</a>):</p><br><p><strong>Informatik</strong> wird in der 6. und 7. JgSt. in beiden Ausbildungsrichtungen innerhalb des Faches Natur- und Technik jeweils einstündig unterrichtet.</p><p><strong>Phys<span>ik</span></strong><span> wird in den JgSt. 8 bis 10 in beiden Ausbildungsrichtungen zweistündig unterrichtet. Für das NTG gibt es jeweils eine zusätzliche Profilstunde mit besonderen Inhalten und Möglichkeiten zum Experimentieren.</span></p><p><span><strong>Chemie</strong> wird am SG nur in den JgSt. 9 und 10 zweistündig unterrichtet.&nbsp;Für das NTG gibt es jeweils eine zusätzliche Profilstunde mit besonderen Inhalten und Möglichkeiten zum Experimentieren.In der 8. Jg.St. ist Chemie 3-stündig.</span></p>'},{header:"Schriftliche Leisungsnachweise",html:'<table><tbody><tr style="vertical-align: top;"><td><span><strong>Italienisch:</strong></span></td><td><span>Als 3. Fremdsprache ist Italienisch 4-stündiges Kernfach im SG. Damit werden 4&nbsp;Schulaufgaben (große Leistungsnachweise) verlangt, wovon i.d.R. eine mündlich ist.</span></td></tr><tr style="vertical-align: top;"><td><span><strong>Physik</strong>: </span></td><td><span>Da Physik in beiden Ausbildungsrichtungen Kernfach ist, werden jeweils 2&nbsp;Schulaufgaben im Schuljahr geschrieben.</span></td></tr><tr style="vertical-align: top;"><td><span><strong>Chemie</strong>:</span></td><td><span>Ist nur im NTG Kernfach, so dass nur im NTG 2 Schulaufgaben geschrieben werden.&nbsp; Im SG werden kleine Leistungsnachweise (Stegreifaufgabe und/oder Kurzarbeit) verlangt.</span></td></tr><tr style="vertical-align: top;"><td><span><strong>Informatik: &nbsp;&nbsp; <br></strong></span></td><td><span>Informatik ist kein Kernfach, es werden kleine Leistungsnachweise (z. B. Stegreifaufgabe und/oder Kurzarbeit) verlangt.</span></td></tr></tbody></table>'},{header:"Allgemeine Hochschulreife",html:'<p>Innerhalb aller Ausbildungsrichtungen wird nach BayEUG Art 9 die allgemeine Hochschulreife verliehen.</p><p><a href="/homepage/images/Dokumente/ausbildungsrichtungenamlsg.pdf" target="_self">PDF zu den Ausbildungsrichtungen am LSG</a></p></div>'}],l,s,i,()=>{s()},function(){n(3,r=Y.pageYOffset)},function(){u=this.checked,n(5,u)},()=>{n(5,u=!1)},c]}import{S as u,i as f,s as m,a1 as $,w as b,c as w,a as y,j as x,h as v,o as S,m as k,N as E,p as I,q as z,r as G,g as L,P as T,J as j,a2 as A,F as D,e as H,b as N,d as F,k as P,x as B,n as C,G as J,H as M,t as V,f as _,C as q,D as K,E as O,z as U,a3 as R,u as W}from"./client.b007dbf1.js";import{S as Z}from"./ShortText.0394cb61.js";import"./EntriesFound.0de26394.js";import"./Button.b1699f39.js";import{I as X}from"./Img.58920e98.js";const{window:Y}=A,Q=()=>({}),tt=t=>({blueprint:t[7]});export default class Article extends u{constructor(t){super(),f(this,t,p,g,m,{img:0,blueprint:1})}}