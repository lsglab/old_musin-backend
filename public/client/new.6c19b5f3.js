function t(t,e,n){const s=t.slice();return s[30]=e[n],s[33]=e,s[34]=n,s}function e(t,e,n){const s=t.slice();return s[30]=e[n],s[31]=e,s[32]=n,s}function n(t,e,n){const s=t.slice();return s[27]=e[n],s}function s(t){let e,n,s,o;const a=[r,l],c=[];return e=function(t){return t[3]?0:1}(t),n=c[e]=a[e](t),{c(){n.c(),s=nt()},l(t){n.l(t),s=nt()},m(t,n){c[e].m(t,n),tt(t,s,n),o=!0},p(t,e){n.p(t,e)},i(t){o||(st(n),o=!0)},o(t){lt(n),o=!1},d(t){c[e].d(t),t&&Q(s)}}}function l(t){function e(t){let e={$$slots:{default:[i]},$$scope:{ctx:t}};for(let t=0;t<r.length;t+=1)e=bt(e,r[t]);return{props:e}}let n,s,l;const r=[{component:t[0]},t[0].props];var o=t[0].component;return o&&(n=new o(e(t)),t[10](n)),{c(){n&&mt(n.$$.fragment),s=nt()},l(t){n&&pt(n.$$.fragment,t),s=nt()},m(t,e){n&&ht(n,t,e),tt(t,s,e),l=!0},p(t,l){const a=1&l[0]?$t(r,[{component:t[0]},gt(t[0].props)]):{};if(3&l[0]|16&l[1]&&(a.$$scope={dirty:l,ctx:t}),o!==(o=t[0].component)){if(n){rt();const t=n;lt(t.$$.fragment,1,0,()=>{wt(t,1)}),ot()}o?(n=new o(e(t)),t[10](n),mt(n.$$.fragment),st(n.$$.fragment,1),ht(n,s.parentNode,s)):n=null}else o&&n.$set(a)},i(t){l||(n&&st(n.$$.fragment,t),l=!0)},o(t){n&&lt(n.$$.fragment,t),l=!1},d(e){t[10](null),e&&Q(s),n&&wt(n,e)}}}function r(t){function e(t){let e={$$slots:{default:[m]},$$scope:{ctx:t}};for(let t=0;t<r.length;t+=1)e=bt(e,r[t]);return{props:e}}let n,s,l;const r=[{component:t[0]},{blueprint:t[0].blueprint},t[0].props];var o=t[0].component;return o&&(n=new o(e(t)),t[8](n)),{c(){n&&mt(n.$$.fragment),s=nt()},l(t){n&&pt(n.$$.fragment,t),s=nt()},m(t,e){n&&ht(n,t,e),tt(t,s,e),l=!0},p(t,l){const a=1&l[0]?$t(r,[{component:t[0]},{blueprint:t[0].blueprint},gt(t[0].props)]):{};if(3&l[0]|16&l[1]&&(a.$$scope={dirty:l,ctx:t}),o!==(o=t[0].component)){if(n){rt();const t=n;lt(t.$$.fragment,1,0,()=>{wt(t,1)}),ot()}o?(n=new o(e(t)),t[8](n),mt(n.$$.fragment),st(n.$$.fragment,1),ht(n,s.parentNode,s)):n=null}else o&&n.$set(a)},i(t){l||(n&&st(n.$$.fragment,t),l=!0)},o(t){n&&lt(n.$$.fragment,t),l=!1},d(e){t[8](null),e&&Q(s),n&&wt(n,e)}}}function o(t){function e(e){t[9].call(null,e,t[30],t[33],t[34])}let n,s,l,r={saving:t[1]};return void 0!==t[30]&&(r.component=t[30]),n=new Component({props:r}),ft.push(()=>It(n,"component",e)),n.$on("component_update",t[6]),n.$on("update",t[5]),{c(){mt(n.$$.fragment)},l(t){pt(n.$$.fragment,t)},m(t,e){ht(n,t,e),l=!0},p(e,l){t=e;const r={};2&l[0]&&(r.saving=t[1]),!s&&1&l[0]&&(s=!0,r.component=t[30],vt(()=>s=!1)),n.$set(r)},i(t){l||(st(n.$$.fragment,t),l=!0)},o(t){lt(n.$$.fragment,t),l=!1},d(t){wt(n,t)}}}function a(t){let e,n,s;return n=new kt({props:{classes:"w-full border-4 border-gray-300 border-dashed rounded-lg h-full",justify:"center",align:"center",$$slots:{default:[c]},$$scope:{ctx:t}}}),{c(){e=J("div"),mt(n.$$.fragment),this.h()},l(t){e=K(t,"DIV",{id:!0,class:!0});var s=Y(e);pt(n.$$.fragment,s),s.forEach(Q),this.h()},h(){xt(e,"id",t[4]),xt(e,"class","w-full p-10 h-60")},m(t,l){tt(t,e,l),ht(n,e,null),s=!0},p(t,e){const s={};16&e[1]&&(s.$$scope={dirty:e,ctx:t}),n.$set(s)},i(t){s||(st(n.$$.fragment,t),s=!0)},o(t){lt(n.$$.fragment,t),s=!1},d(t){t&&Q(e),wt(n)}}}function c(){let t,e;return{c(){t=J("div"),e=jt("add"),this.h()},l(n){t=K(n,"DIV",{class:!0,style:!0});var s=Y(t);e=Dt(s,"add"),s.forEach(Q),this.h()},h(){xt(t,"class","text-gray-300 material-icons"),Ht(t,"font-size","5rem")},m(n,s){tt(n,t,s),Vt(t,e)},d(e){e&&Q(t)}}}function i(e){let n,s,l,r=e[0].children,c=[];for(let n=0;n<r.length;n+=1)c[n]=o(t(e,r,n));const i=t=>lt(c[t],1,1,()=>{c[t]=null});let d=!1===e[1]&&0===e[0].children.length&&a(e);return{c(){for(let t=0;t<c.length;t+=1)c[t].c();n=yt(),d&&d.c(),s=yt()},l(t){for(let e=0;e<c.length;e+=1)c[e].l(t);n=Et(t),d&&d.l(t),s=Et(t)},m(t,e){for(let n=0;n<c.length;n+=1)c[n].m(t,e);tt(t,n,e),d&&d.m(t,e),tt(t,s,e),l=!0},p(e,l){if(99&l[0]){let s;for(r=e[0].children,s=0;s<r.length;s+=1){const a=t(e,r,s);c[s]?(c[s].p(a,l),st(c[s],1)):(c[s]=o(a),c[s].c(),st(c[s],1),c[s].m(n.parentNode,n))}for(rt(),s=r.length;s<c.length;s+=1)i(s);ot()}!1===e[1]&&0===e[0].children.length?d?(d.p(e,l),3&l[0]&&st(d,1)):(d=a(e),d.c(),st(d,1),d.m(s.parentNode,s)):d&&(rt(),lt(d,1,1,()=>{d=null}),ot())},i(t){if(!l){for(let t=0;t<r.length;t+=1)st(c[t]);st(d),l=!0}},o(t){c=c.filter(Boolean);for(let t=0;t<c.length;t+=1)lt(c[t]);lt(d),l=!1},d(t){at(c,t),t&&Q(n),d&&d.d(t),t&&Q(s)}}}function d(t){function e(e){t[7].call(null,e,t[30],t[31],t[32])}let n,s,l,r={saving:t[1]};return void 0!==t[30]&&(r.component=t[30]),n=new Component({props:r}),ft.push(()=>It(n,"component",e)),n.$on("component_update",t[6]),n.$on("update",t[5]),{c(){mt(n.$$.fragment)},l(t){pt(n.$$.fragment,t)},m(t,e){ht(n,t,e),l=!0},p(e,l){t=e;const r={};2&l[0]&&(r.saving=t[1]),!s&&1&l[0]&&(s=!0,r.component=t[30],vt(()=>s=!1)),n.$set(r)},i(t){l||(st(n.$$.fragment,t),l=!0)},o(t){lt(n.$$.fragment,t),l=!1},d(t){wt(n,t)}}}function u(t){let e,n,s;return n=new kt({props:{classes:"w-full border-4 border-gray-300 border-dashed rounded-lg h-full",justify:"center",align:"center",$$slots:{default:[f]},$$scope:{ctx:t}}}),{c(){e=J("div"),mt(n.$$.fragment),this.h()},l(t){e=K(t,"DIV",{id:!0,class:!0});var s=Y(e);pt(n.$$.fragment,s),s.forEach(Q),this.h()},h(){xt(e,"id",t[4]),xt(e,"class","w-full p-10 h-60")},m(t,l){tt(t,e,l),ht(n,e,null),s=!0},p(t,e){const s={};16&e[1]&&(s.$$scope={dirty:e,ctx:t}),n.$set(s)},i(t){s||(st(n.$$.fragment,t),s=!0)},o(t){lt(n.$$.fragment,t),s=!1},d(t){t&&Q(e),wt(n)}}}function f(){let t,e;return{c(){t=J("div"),e=jt("add"),this.h()},l(n){t=K(n,"DIV",{class:!0,style:!0});var s=Y(t);e=Dt(s,"add"),s.forEach(Q),this.h()},h(){xt(t,"class","text-gray-300 material-icons"),Ht(t,"font-size","5rem")},m(n,s){tt(n,t,s),Vt(t,e)},d(e){e&&Q(t)}}}function m(t){let n,s,l,r=t[0].children,o=[];for(let n=0;n<r.length;n+=1)o[n]=d(e(t,r,n));const a=t=>lt(o[t],1,1,()=>{o[t]=null});let c=!1===t[1]&&0===t[0].children.length&&u(t);return{c(){for(let t=0;t<o.length;t+=1)o[t].c();n=yt(),c&&c.c(),s=yt()},l(t){for(let e=0;e<o.length;e+=1)o[e].l(t);n=Et(t),c&&c.l(t),s=Et(t)},m(t,e){for(let n=0;n<o.length;n+=1)o[n].m(t,e);tt(t,n,e),c&&c.m(t,e),tt(t,s,e),l=!0},p(t,l){if(99&l[0]){let s;for(r=t[0].children,s=0;s<r.length;s+=1){const a=e(t,r,s);o[s]?(o[s].p(a,l),st(o[s],1)):(o[s]=d(a),o[s].c(),st(o[s],1),o[s].m(n.parentNode,n))}for(rt(),s=r.length;s<o.length;s+=1)a(s);ot()}!1===t[1]&&0===t[0].children.length?c?(c.p(t,l),3&l[0]&&st(c,1)):(c=u(t),c.c(),st(c,1),c.m(s.parentNode,s)):c&&(rt(),lt(c,1,1,()=>{c=null}),ot())},i(t){if(!l){for(let t=0;t<r.length;t+=1)st(o[t]);st(c),l=!0}},o(t){o=o.filter(Boolean);for(let t=0;t<o.length;t+=1)lt(o[t]);lt(c),l=!1},d(t){at(o,t),t&&Q(n),c&&c.d(t),t&&Q(s)}}}function p(){let t;return{c(){t=J("div")},l(e){t=K(e,"DIV",{}),Y(t).forEach(Q)},m(e,n){tt(e,t,n)},p:et,d(e){e&&Q(t)}}}function h(t){let e,l=[],r=[];for(let e=0;e<l.length;e+=1)r[e]=p(n(t,l,e));let o=null;return l.length||(o=s(t)),{c(){for(let t=0;t<r.length;t+=1)r[t].c();e=nt(),o&&o.c()},l(t){for(let e=0;e<r.length;e+=1)r[e].l(t);e=nt(),o&&o.l(t)},m(t,n){for(let e=0;e<r.length;e+=1)r[e].m(t,n);tt(t,e,n),o&&o.m(t,n)},p(t,a){if(127&a[0]){let c;for(l=[],c=0;c<l.length;c+=1){const s=n(t,l,c);r[c]?r[c].p(s,a):(r[c]=p(),r[c].c(),r[c].m(e.parentNode,e))}for(;c<r.length;c+=1)r[c].d(1);r.length=l.length,!l.length&&o?o.p(t,a):l.length?o&&(rt(),lt(o,1,1,()=>{o=null}),ot()):(o=s(t),o.c(),st(o,1),o.m(e.parentNode,e))}},i:et,o:et,d(t){at(r,t),t&&Q(e),o&&o.d(t)}}}function $(t,e,n){function s(t){return f.$$.ctx[function(t){return f.$$.props[t]}(t)]}function l(){c("update",{})}function r(){f.$set({blueprint:s("blueprint")}),n(0,i),c("component_update")}let o,a;ct(t,Yt,t=>n(12,o=t)),ct(t,Qt,t=>n(13,a=t));const c=it();let{component:i}=e,{saving:d=!1}=e;const u=Object.keys(i.blueprint).length>0;let f;const m="slot-"+Date.now();let p=!1;return dt(()=>{!0===p&&(function(){const t=s("blueprint");void 0!==t&&Object.keys(t).forEach(e=>{"children"!==e&&((t,e)=>{o.getColumnPermission(a.id,"blueprint")&&t[e].prepareInput(document,r)})(t,e)})}(),p=!1)}),t.$$set=t=>{"component"in t&&n(0,i=t.component),"saving"in t&&n(1,d=t.saving)},t.$$.update=()=>{1&t.$$.dirty[0]&&async function(){void 0===f&&(await ut(),function(){const t={},e=Object.keys(f.$$.props);for(let l=0;l<e.length;l+=1){const r=e[l];if("blueprint"===r)return void n(0,i.props=t,i);const o=s(r);t[r]=o}}(),null!==document.getElementById(m)&&n(0,i.slot=!0,i),await ut(),function(){const t=s("blueprint");t&&t.children&&t.children.forEach(t=>{i.childrenTypes.push(t.name)})}(),n(0,i.blueprint=s("blueprint"),i),l(),p=!0)}()},[i,d,f,u,m,l,r,function(t,e,s,l){s[l]=t,n(0,i)},function(t){ft[t?"unshift":"push"](()=>{f=t,n(2,f)})},function(t,e,s,l){s[l]=t,n(0,i)},function(t){ft[t?"unshift":"push"](()=>{f=t,n(2,f)})}]}function g(t){let e;const n=t[2].default,s=Lt(n,t,t[1],null);return{c(){s&&s.c()},l(t){s&&s.l(t)},m(t,n){s&&s.m(t,n),e=!0},p(t,[e]){s&&s.p&&2&e&&St(s,n,t,t[1],e,null,null)},i(t){e||(st(s,t),e=!0)},o(t){lt(s,t),e=!1},d(t){s&&s.d(t)}}}function w(t,e,n){let{$$slots:s={},$$scope:l}=e,{blueprint:r={}}=e;return t.$$set=t=>{"blueprint"in t&&n(0,r=t.blueprint),"$$scope"in t&&n(1,l=t.$$scope)},[r,l,s]}function b(t){let e,n,s,l,r,o,a,c,i,d,u,f,m=t[0].header.data+"",p=t[0].content.data+"";return{c(){e=J("div"),n=J("header"),s=J("hr"),l=yt(),r=J("h4"),o=jt(m),c=yt(),i=J("div"),d=jt(p),this.h()},l(t){var a,u,f,h;e=K(t,"DIV",{class:!0,id:!0}),a=Y(e),n=K(a,"HEADER",{}),u=Y(n),s=K(u,"HR",{class:!0}),l=Et(u),r=K(u,"H4",{class:!0,id:!0}),f=Y(r),o=Dt(f,m),f.forEach(Q),u.forEach(Q),c=Et(a),i=K(a,"DIV",{id:!0}),h=Y(i),d=Dt(h,p),h.forEach(Q),a.forEach(Q),this.h()},h(){xt(s,"class","w-12 my-3 text-black border-t-0 border-b-2 border-black"),xt(r,"class","my-4 font-normal"),xt(r,"id",a=t[0].header.id),xt(i,"id",u=t[0].content.id),xt(e,"class","pt-16 m-0 art-content-sect"),xt(e,"id",f=void 0!==t[1]?""+t[1].id:"")},m(t,a){tt(t,e,a),Vt(e,n),Vt(n,s),Vt(n,l),Vt(n,r),Vt(r,o),Vt(e,c),Vt(e,i),Vt(i,d)},p(t,[n]){1&n&&m!==(m=t[0].header.data+"")&&Tt(o,m),1&n&&a!==(a=t[0].header.id)&&xt(r,"id",a),1&n&&p!==(p=t[0].content.data+"")&&Tt(d,p),1&n&&u!==(u=t[0].content.id)&&xt(i,"id",u),2&n&&f!==(f=void 0!==t[1]?""+t[1].id:"")&&xt(e,"id",f)},i:et,o:et,d(t){t&&Q(e)}}}function v(t,e,n){let{blueprint:s={content:new ne("Text..."),header:new Zt("Titel der Section")}}=e,{component:l}=e;return t.$$set=t=>{"blueprint"in t&&n(0,s=t.blueprint),"component"in t&&n(1,l=t.component)},[s,l]}function x(t,e,n){const s=t.slice();return s[18]=e[n],s[20]=n,s}function y(t){let e,n,s;return{c(){e=J("img"),this.h()},l(t){e=K(t,"IMG",{id:!0,class:!0,src:!0,alt:!0}),this.h()},h(){xt(e,"id",n=t[1].img.id),xt(e,"class","object-cover w-full h-full rounded-md shadow-equal lg:w-auto"),e.src!==(s=t[1].img.data)&&xt(e,"src",s),xt(e,"alt","")},m(t,n){tt(t,e,n)},p(t,l){2&l&&n!==(n=t[1].img.id)&&xt(e,"id",n),2&l&&e.src!==(s=t[1].img.data)&&xt(e,"src",s)},d(t){t&&Q(e)}}}function E(t){let e,n,s,l,r,o,a,c,i,d=t[1].header.data+"",u=t[1].subHeader.data+"";return{c(){e=J("div"),n=J("h3"),s=jt(d),r=yt(),o=J("p"),a=jt(u),this.h()},l(t){var l,c,i;e=K(t,"DIV",{class:!0}),l=Y(e),n=K(l,"H3",{class:!0,id:!0}),c=Y(n),s=Dt(c,d),c.forEach(Q),r=Et(l),o=K(l,"P",{class:!0,id:!0}),i=Y(o),a=Dt(i,u),i.forEach(Q),l.forEach(Q),this.h()},h(){xt(n,"class","text-2xl text-heading md:text-2.5xl"),xt(n,"id",l=t[1].header.id),xt(o,"class","mt-3 text-heading2"),xt(o,"id",c=t[1].subHeader.id),xt(e,"class",i="m-8 "+(t[0]?"text-center":"text-left ml-0"))},m(t,l){tt(t,e,l),Vt(e,n),Vt(n,s),Vt(e,r),Vt(e,o),Vt(o,a)},p(t,r){2&r&&d!==(d=t[1].header.data+"")&&Tt(s,d),2&r&&l!==(l=t[1].header.id)&&xt(n,"id",l),2&r&&u!==(u=t[1].subHeader.data+"")&&Tt(a,u),2&r&&c!==(c=t[1].subHeader.id)&&xt(o,"id",c),1&r&&i!==(i="m-8 "+(t[0]?"text-center":"text-left ml-0"))&&xt(e,"class",i)},d(t){t&&Q(e)}}}function I(t){let e,n,s,l,r,o,a,c;return n=new kt({props:{justify:"center",classes:"w-full h-inherit "+(!1===t[0]?"hidden":""),$$slots:{default:[y]},$$scope:{ctx:t}}}),r=new kt({props:{justify:t[0]?"center":"start",align:"center",classes:"w-full h-full",$$slots:{default:[E]},$$scope:{ctx:t}}}),{c(){e=J("div"),mt(n.$$.fragment),s=yt(),l=J("div"),mt(r.$$.fragment),this.h()},l(t){var o,a;e=K(t,"DIV",{class:!0}),o=Y(e),pt(n.$$.fragment,o),s=Et(o),l=K(o,"DIV",{class:!0}),a=Y(l),pt(r.$$.fragment,a),a.forEach(Q),o.forEach(Q),this.h()},h(){xt(l,"class",o=Ot(t[0]?"w-auto":"article-width justify-self-end")+" svelte-1nn7v02"),xt(e,"class",a="flex flex-col-reverse justify-center transition-none align-center article lg:grid "+(t[0]?"lg:grid-cols-2 lg:h-80":"lg:grid-cols-1 h-52"))},m(t,o){tt(t,e,o),ht(n,e,null),Vt(e,s),Vt(e,l),ht(r,l,null),c=!0},p(t,s){const i={};1&s&&(i.classes="w-full h-inherit "+(!1===t[0]?"hidden":"")),8194&s&&(i.$$scope={dirty:s,ctx:t}),n.$set(i);const d={};1&s&&(d.justify=t[0]?"center":"start"),8195&s&&(d.$$scope={dirty:s,ctx:t}),r.$set(d),(!c||1&s&&o!==(o=Ot(t[0]?"w-auto":"article-width justify-self-end")+" svelte-1nn7v02"))&&xt(l,"class",o),(!c||1&s&&a!==(a="flex flex-col-reverse justify-center transition-none align-center article lg:grid "+(t[0]?"lg:grid-cols-2 lg:h-80":"lg:grid-cols-1 h-52")))&&xt(e,"class",a)},i(t){c||(st(n.$$.fragment,t),st(r.$$.fragment,t),c=!0)},o(t){lt(n.$$.fragment,t),lt(r.$$.fragment,t),c=!1},d(t){t&&Q(e),wt(n),wt(r)}}}function k(){let t,e,n,s;return{c(){t=J("h5"),e=jt("INHALTSVERZEICHNIS"),n=yt(),s=J("div"),this.h()},l(l){t=K(l,"H5",{class:!0});var r=Y(t);e=Dt(r,"INHALTSVERZEICHNIS"),r.forEach(Q),n=Et(l),s=K(l,"DIV",{class:!0}),Y(s).forEach(Q),this.h()},h(){xt(t,"class","text-lg truncate text-heading"),xt(s,"class","w-8 h-8 bg-center bg-auto cursor-pointer arrow lg:hidden xl:hidden bg-arrowIcon svelte-1nn7v02")},m(l,r){tt(l,t,r),Vt(t,e),tt(l,n,r),tt(l,s,r)},d(e){e&&Q(t),e&&Q(n),e&&Q(s)}}}function j(t){let e,n=t[2].children,s=[];for(let e=0;e<n.length;e+=1)s[e]=H(x(t,n,e));return{c(){for(let t=0;t<s.length;t+=1)s[t].c();e=nt()},l(t){for(let e=0;e<s.length;e+=1)s[e].l(t);e=nt()},m(t,n){for(let e=0;e<s.length;e+=1)s[e].m(t,n);tt(t,e,n)},p(t,l){if(100&l){let r;for(n=t[2].children,r=0;r<n.length;r+=1){const o=x(t,n,r);s[r]?s[r].p(o,l):(s[r]=H(o),s[r].c(),s[r].m(e.parentNode,e))}for(;r<s.length;r+=1)s[r].d(1);s.length=n.length}},d(t){at(s,t),t&&Q(e)}}}function D(t){let e,n,s,l,r,o,a,c=t[20]+1+"",i=t[18].blueprint.header.data+"";return{c(){e=J("a"),n=jt(c),s=jt(". "),l=jt(i),this.h()},l(t){e=K(t,"A",{class:!0,href:!0});var r=Y(e);n=Dt(r,c),s=Dt(r,". "),l=Dt(r,i),r.forEach(Q),this.h()},h(){xt(e,"class","lg:text-sm"),xt(e,"href",r=window.location.href+"/#"+t[18].id)},m(r,c){tt(r,e,c),Vt(e,n),Vt(e,s),Vt(e,l),o||(a=_t(e,"click",t[12]),o=!0)},p(t,n){4&n&&i!==(i=t[18].blueprint.header.data+"")&&Tt(l,i),4&n&&r!==(r=window.location.href+"/#"+t[18].id)&&xt(e,"href",r)},d(t){t&&Q(e),o=!1,a()}}}function H(t){let e,n,s,l,r=void 0!==t[18].blueprint.header&&D(t);return{c(){e=J("li"),r&&r.c(),n=yt(),this.h()},l(t){e=K(t,"LI",{class:!0,id:!0});var s=Y(e);r&&r.l(s),n=Et(s),s.forEach(Q),this.h()},h(){xt(e,"class",s="my-4 lg:my-3 font-semibold list-none cursor-pointer tracking-wide\n\t\t\t\t\t\t\t\t\t\t\t"+(t[5]!==t[20]?"":"text-blue-400 list-square")),xt(e,"id",l=t[20])},m(t,s){tt(t,e,s),r&&r.m(e,null),Vt(e,n)},p(t,l){void 0!==t[18].blueprint.header?r?r.p(t,l):(r=D(t),r.c(),r.m(e,n)):r&&(r.d(1),r=null),32&l&&s!==(s="my-4 lg:my-3 font-semibold list-none cursor-pointer tracking-wide\n\t\t\t\t\t\t\t\t\t\t\t"+(t[5]!==t[20]?"":"text-blue-400 list-square"))&&xt(e,"class",s)},d(t){t&&Q(e),r&&r.d()}}}function V(t){let e,n,s,l,r;n=new kt({props:{justify:"between",wrap:"true",align:"center",$$slots:{default:[k]},$$scope:{ctx:t}}});let o=!1!==t[2]&&j(t);return{c(){e=J("label"),mt(n.$$.fragment),s=yt(),l=J("ul"),o&&o.c(),this.h()},l(t){var r,a;e=K(t,"LABEL",{for:!0,class:!0}),r=Y(e),pt(n.$$.fragment,r),r.forEach(Q),s=Et(t),l=K(t,"UL",{class:!0}),a=Y(l),o&&o.l(a),a.forEach(Q),this.h()},h(){xt(e,"for","table-checkbox"),xt(e,"class","cursor-pointer svelte-1nn7v02"),xt(l,"class","pl-4 overflow-hidden opacity-0 content-table-ul transition-300 lg:opacity-100 xl:opacity-100 max-h-0 lg:max-h-full xl:max-h-full svelte-1nn7v02")},m(t,a){tt(t,e,a),ht(n,e,null),tt(t,s,a),tt(t,l,a),o&&o.m(l,null),r=!0},p(t,e){const s={};8192&e&&(s.$$scope={dirty:e,ctx:t}),n.$set(s),!1!==t[2]?o?o.p(t,e):(o=j(t),o.c(),o.m(l,null)):o&&(o.d(1),o=null)},i(t){r||(st(n.$$.fragment,t),r=!0)},o(t){lt(n.$$.fragment,t),r=!1},d(t){t&&Q(e),wt(n),t&&Q(s),t&&Q(l),o&&o.d()}}}function L(){let t,e,n,s,l,r=function(){let t="";Object.values(document.getElementsByClassName("art-content-sect")).forEach(e=>{t+=e.innerHtml});const e=t.replace(/[^\w ]/g,"").split(/\s+/).length;return Math.floor(e/228)+1+" Min. Lesezeit"}()+"";return{c(){t=J("div"),e=jt("schedule"),n=yt(),s=J("p"),l=jt(r),this.h()},l(o){var a,c;t=K(o,"DIV",{class:!0}),a=Y(t),e=Dt(a,"schedule"),a.forEach(Q),n=Et(o),s=K(o,"P",{}),c=Y(s),l=Dt(c,r),c.forEach(Q),this.h()},h(){xt(t,"class","mr-1.5 material-icons")},m(r,o){tt(r,t,o),Vt(t,e),tt(r,n,o),tt(r,s,o),Vt(s,l)},p:et,d(e){e&&Q(t),e&&Q(n),e&&Q(s)}}}function S(t){let e,n,s,l,r,o,a,c,i,d,u,f,m,p,h,$,g,w;r=new Ct({props:{customStyles:t[3]?"":"padding: 0px",classes:"lg:px-unset xl:px-unset 2xl:px-unset",$$slots:{default:[V]},$$scope:{ctx:t}}}),u=new kt({props:{align:"center",classes:"border-b border-solid border-gray-500 pb-1",$$slots:{default:[L]},$$scope:{ctx:t}}});const b=t[8].default,v=Lt(b,t,t[13],null);return{c(){e=J("div"),n=J("input"),s=yt(),l=J("div"),mt(r.$$.fragment),c=yt(),i=J("div"),d=J("div"),mt(u.$$.fragment),f=yt(),m=J("p"),p=jt("Letzte Aktualisierung am 28.10.2020"),h=yt(),v&&v.c(),this.h()},l(t){var o,a,$,g,w;e=K(t,"DIV",{class:!0,id:!0}),o=Y(e),n=K(o,"INPUT",{class:!0,type:!0,id:!0}),s=Et(o),l=K(o,"DIV",{class:!0}),a=Y(l),pt(r.$$.fragment,a),a.forEach(Q),o.forEach(Q),c=Et(t),i=K(t,"DIV",{class:!0}),$=Y(i),d=K($,"DIV",{class:!0}),g=Y(d),pt(u.$$.fragment,g),f=Et(g),m=K(g,"P",{class:!0}),w=Y(m),p=Dt(w,"Letzte Aktualisierung am 28.10.2020"),w.forEach(Q),g.forEach(Q),h=Et($),v&&v.l($),$.forEach(Q),this.h()},h(){xt(n,"class","hidden"),xt(n,"type","checkbox"),xt(n,"id","table-checkbox"),xt(l,"class",o=Ot(t[3]?"relative left-center lg:left-0 w-screen lg:w-auto mobile-sticky top-0 bg-white lg:py-0 py-2 table-transition shadow-xl lg:shadow-none":"")+" svelte-1nn7v02"),xt(e,"class",a="sticky lg:mr-4 top-0 z-10 w-full bg-white rounded-md table-transition lg:max-w-1/3 lg:top-4 lg:p-4 lg:shadow-equal lg:m-0 lg:w-auto h-min-content "+(t[3]?"py-0":"py-4")+"  svelte-1nn7v02"),xt(e,"id","content-table"),xt(m,"class","text-sm text-gray-700"),xt(d,"class","mt-2 -mb-5"),xt(i,"class","article-width lg:ml-4 svelte-1nn7v02")},m(o,a){tt(o,e,a),Vt(e,n),n.checked=t[6],Vt(e,s),Vt(e,l),ht(r,l,null),tt(o,c,a),tt(o,i,a),Vt(i,d),ht(u,d,null),Vt(d,f),Vt(d,m),Vt(m,p),Vt(i,h),v&&v.m(i,null),$=!0,g||(w=_t(n,"change",t[11]),g=!0)},p(t,s){64&s&&(n.checked=t[6]);const c={};8&s&&(c.customStyles=t[3]?"":"padding: 0px"),8292&s&&(c.$$scope={dirty:s,ctx:t}),r.$set(c),(!$||8&s&&o!==(o=Ot(t[3]?"relative left-center lg:left-0 w-screen lg:w-auto mobile-sticky top-0 bg-white lg:py-0 py-2 table-transition shadow-xl lg:shadow-none":"")+" svelte-1nn7v02"))&&xt(l,"class",o),(!$||8&s&&a!==(a="sticky lg:mr-4 top-0 z-10 w-full bg-white rounded-md table-transition lg:max-w-1/3 lg:top-4 lg:p-4 lg:shadow-equal lg:m-0 lg:w-auto h-min-content "+(t[3]?"py-0":"py-4")+"  svelte-1nn7v02"))&&xt(e,"class",a);const i={};8192&s&&(i.$$scope={dirty:s,ctx:t}),u.$set(i),v&&v.p&&8192&s&&St(v,b,t,t[13],s,null,null)},i(t){$||(st(r.$$.fragment,t),st(u.$$.fragment,t),st(v,t),$=!0)},o(t){lt(r.$$.fragment,t),lt(u.$$.fragment,t),lt(v,t),$=!1},d(t){t&&Q(e),wt(r),t&&Q(c),t&&Q(i),wt(u),v&&v.d(t),g=!1,w()}}}function T(t){let e,n,s;return n=new kt({props:{justify:"between",wrap:"true",classes:"m-auto lg:flex-nowrap",$$slots:{default:[S]},$$scope:{ctx:t}}}),{c(){e=J("div"),mt(n.$$.fragment),this.h()},l(t){e=K(t,"DIV",{class:!0});var s=Y(e);pt(n.$$.fragment,s),s.forEach(Q),this.h()},h(){xt(e,"class","w-full svelte-1nn7v02")},m(t,l){tt(t,e,l),ht(n,e,null),s=!0},p(t,e){const s={};8300&e&&(s.$$scope={dirty:e,ctx:t}),n.$set(s)},i(t){s||(st(n.$$.fragment,t),s=!0)},o(t){lt(n.$$.fragment,t),s=!1},d(t){t&&Q(e),wt(n)}}}function N(t){let e,n,s,l,r,o,a,c=!1,i=()=>{c=!1};return Nt(t[10]),n=new Ct({props:{classes:"mb-10 mt-5",$$slots:{default:[I]},$$scope:{ctx:t}}}),l=new Ct({props:{classes:"dashedTopBorder pb-20",$$slots:{default:[T]},$$scope:{ctx:t}}}),{c(){mt(n.$$.fragment),s=yt(),mt(l.$$.fragment)},l(t){pt(n.$$.fragment,t),s=Et(t),pt(l.$$.fragment,t)},m(d,u){ht(n,d,u),tt(d,s,u),ht(l,d,u),r=!0,o||(a=[_t(re,"scroll",t[9]),_t(re,"scroll",()=>{c=!0,clearTimeout(e),e=setTimeout(i,100),t[10]()})],o=!0)},p(t,[s]){16&s&&!c&&(c=!0,clearTimeout(e),scrollTo(re.pageXOffset,t[4]),e=setTimeout(i,100));const r={};8195&s&&(r.$$scope={dirty:s,ctx:t}),n.$set(r);const o={};8300&s&&(o.$$scope={dirty:s,ctx:t}),l.$set(o)},i(t){r||(st(n.$$.fragment,t),st(l.$$.fragment,t),r=!0)},o(t){lt(n.$$.fragment,t),lt(l.$$.fragment,t),r=!1},d(t){wt(n,t),t&&Q(s),wt(l,t),o=!1,At(a)}}}function C(t){let e=0,n=t;for(;n;)e+=n.offsetTop,n=n.offsetParent;return e}function _(t,e,n){function s(){p&&(null==l?l=C(document.getElementById("content-table")):r>=l&&!1===u?n(3,u=!0):r<=l&&!0===u&&n(3,u=!1),function(){let t=document.body.scrollTop||document.documentElement.scrollTop;const e=document.getElementsByClassName("art-content-sect");t+=Math.max(document.documentElement.clientHeight||0,window.innerHeight||0)/4;for(let s=0;s<Object.keys(e).length;s+=1){const l=C(e[s.toString()]),r=s!==Object.keys(e).length-1?C(e[""+(s+1)]):t+1;if(t>l&&t<r)return void n(5,f=s)}}())}let l,r,{$$slots:o={},$$scope:a}=e,{img:c=!0}=e,{blueprint:i={children:[ArticleSection],header:new Zt("Titel"),img:new te("https://i.stack.imgur.com/y9DpT.jpg"),subHeader:new Zt("sub Header")}}=e,{component:d=!1}=e,u=!1,f=0,m=!1,p=!1;return zt(()=>{p=!0}),t.$$set=t=>{"img"in t&&n(0,c=t.img),"blueprint"in t&&n(1,i=t.blueprint),"component"in t&&n(2,d=t.component),"$$scope"in t&&n(13,a=t.$$scope)},[c,i,d,u,r,f,m,s,o,()=>{s()},function(){n(4,r=re.pageYOffset)},function(){m=this.checked,n(6,m)},()=>{n(6,m=!1)},a]}function A(t){let e,n,s;return{c(){e=J("img"),this.h()},l(t){e=K(t,"IMG",{src:!0,id:!0,alt:!0,class:!0}),this.h()},h(){e.src!==(n=t[0].img.data)&&xt(e,"src",n),xt(e,"id",s=t[0].img.id),xt(e,"alt",""),xt(e,"class","svelte-15qde7z")},m(t,n){tt(t,e,n)},p(t,[l]){1&l&&e.src!==(n=t[0].img.data)&&xt(e,"src",n),1&l&&s!==(s=t[0].img.id)&&xt(e,"id",s)},i:et,o:et,d(t){t&&Q(e)}}}function z(t,e,n){let{blueprint:s={img:new te("https://lsg.musin.de/homepage/images/LOGOsorsmc_SCREEN_80mm_RGB_mini.jpg")}}=e;return t.$$set=t=>{"blueprint"in t&&n(0,s=t.blueprint)},[s]}function B(t){let e,n,s,l,r=t[0].button.data+"";return{c(){e=J("a"),n=jt(r),this.h()},l(t){e=K(t,"A",{id:!0,href:!0,class:!0});var s=Y(e);n=Dt(s,r),s.forEach(Q),this.h()},h(){xt(e,"id",s=t[0].button.id),xt(e,"href",l=t[0].button.href),xt(e,"class","inline-block w-full text-xs text-white svelte-1lk48pw")},m(t,s){tt(t,e,s),Vt(e,n)},p(t,o){1&o&&r!==(r=t[0].button.data+"")&&Tt(n,r),1&o&&s!==(s=t[0].button.id)&&xt(e,"id",s),1&o&&l!==(l=t[0].button.href)&&xt(e,"href",l)},d(t){t&&Q(e)}}}function O(t){let e,n,s,l,r,o,a,c,i,d,u,f,m,p,h,$,g,w,b,v,x,y,E=t[0].header.data+"",I=t[0].subHeader.data+"",k=t[0].note.data+"";return f=new Gt({props:{classes:"min-w-40",$$slots:{default:[B]},$$scope:{ctx:t}}}),{c(){e=J("header"),n=J("div"),s=J("div"),l=J("h1"),r=jt(E),a=yt(),c=J("h3"),i=jt(I),u=yt(),mt(f.$$.fragment),m=yt(),p=J("p"),h=jt(k),g=yt(),w=J("div"),b=J("div"),v=J("img"),this.h()},l(t){var o,d,$,x,y,j,D,H;e=K(t,"HEADER",{class:!0,style:!0}),o=Y(e),n=K(o,"DIV",{class:!0}),d=Y(n),s=K(d,"DIV",{class:!0,style:!0}),$=Y(s),l=K($,"H1",{class:!0,id:!0}),x=Y(l),r=Dt(x,E),x.forEach(Q),a=Et($),c=K($,"H3",{class:!0,style:!0,id:!0}),y=Y(c),i=Dt(y,I),y.forEach(Q),u=Et($),pt(f.$$.fragment,$),m=Et($),p=K($,"P",{class:!0,style:!0,id:!0}),j=Y(p),h=Dt(j,k),j.forEach(Q),$.forEach(Q),d.forEach(Q),g=Et(o),w=K(o,"DIV",{class:!0}),D=Y(w),b=K(D,"DIV",{class:!0}),H=Y(b),v=K(H,"IMG",{id:!0,class:!0,alt:!0,style:!0}),H.forEach(Q),D.forEach(Q),o.forEach(Q),this.h()},h(){xt(l,"class","text-3xl leading-9 break-normal text-heading svelte-1lk48pw"),xt(l,"id",o=t[0].header.id),xt(c,"class","my-4 text-xl leading-5 svelte-1lk48pw"),Ht(c,"font-weight","900"),xt(c,"id",d=t[0].subHeader.id),xt(p,"class","mt-6 text-gray-700 svelte-1lk48pw"),Ht(p,"font-size","14px"),xt(p,"id",$=t[0].note.id),xt(s,"class","mt-12 lg:m-12 lg:ml-0 lg:mr-24 svelte-1lk48pw"),Ht(s,"max-width","500px"),xt(n,"class","z-20 flex flex-col justify-center w-full md:mt-10 lg:mt-0 lg:items-center lg:w-1/2 svelte-1lk48pw"),xt(v,"id",x=t[0].img.id),xt(v,"class","w-full h-full bg-cover shadow-lg rounded-xl svelte-1lk48pw"),xt(v,"alt",""),Ht(v,"background-image","url('"+t[0].img.data+"')"),xt(b,"class","w-full my-10 h-52 md:my-16 lg:my-0 md:h-80 lg:py-10vh lg:h-85vh svelte-1lk48pw"),xt(w,"class","z-10 flex flex-col items-center justify-center w-full svelte-1lk48pw"),xt(e,"class","flex flex-col w-full lg:justify-between flex-nowrap lg:flex-row svelte-1lk48pw"),Ht(e,"min-height","80vh"),Ht(e,"padding-top","40px")},m(t,o){tt(t,e,o),Vt(e,n),Vt(n,s),Vt(s,l),Vt(l,r),Vt(s,a),Vt(s,c),Vt(c,i),Vt(s,u),ht(f,s,null),Vt(s,m),Vt(s,p),Vt(p,h),Vt(e,g),Vt(e,w),Vt(w,b),Vt(b,v),y=!0},p(t,e){(!y||1&e)&&E!==(E=t[0].header.data+"")&&Tt(r,E),(!y||1&e&&o!==(o=t[0].header.id))&&xt(l,"id",o),(!y||1&e)&&I!==(I=t[0].subHeader.data+"")&&Tt(i,I),(!y||1&e&&d!==(d=t[0].subHeader.id))&&xt(c,"id",d);const n={};5&e&&(n.$$scope={dirty:e,ctx:t}),f.$set(n),(!y||1&e)&&k!==(k=t[0].note.data+"")&&Tt(h,k),(!y||1&e&&$!==($=t[0].note.id))&&xt(p,"id",$),(!y||1&e&&x!==(x=t[0].img.id))&&xt(v,"id",x),(!y||1&e)&&Ht(v,"background-image","url('"+t[0].img.data+"')")},i(t){y||(st(f.$$.fragment,t),y=!0)},o(t){lt(f.$$.fragment,t),y=!1},d(t){t&&Q(e),wt(f)}}}function M(t){let e,n;const s=t[1].default,l=Lt(s,t,t[2],null);return{c(){e=J("div"),l&&l.c(),this.h()},l(t){e=K(t,"DIV",{class:!0});var n=Y(e);l&&l.l(n),n.forEach(Q),this.h()},h(){xt(e,"class","flex flex-row justify-between flex-grow w-full bg-transparent awards svelte-1lk48pw")},m(t,s){tt(t,e,s),l&&l.m(e,null),n=!0},p(t,e){l&&l.p&&4&e&&St(l,s,t,t[2],e,null,null)},i(t){n||(st(l,t),n=!0)},o(t){lt(l,t),n=!1},d(t){t&&Q(e),l&&l.d(t)}}}function G(t){let e,n,s,l,r,o,a;return document.title=e="Startseite | Louise Schroeder Gymnasium",l=new Ct({props:{$$slots:{default:[O]},$$scope:{ctx:t}}}),o=new Ct({props:{customStyles:"padding-bottom: 30px;",classes:"dashedTopBorder hidden md:block",$$slots:{default:[M]},$$scope:{ctx:t}}}),{c(){n=yt(),s=J("div"),mt(l.$$.fragment),r=yt(),mt(o.$$.fragment),this.h()},l(t){Mt('[data-svelte="svelte-1heqhp5"]',document.head).forEach(Q),n=Et(t),s=K(t,"DIV",{style:!0,class:!0});var e=Y(s);pt(l.$$.fragment,e),r=Et(e),pt(o.$$.fragment,e),e.forEach(Q),this.h()},h(){Ht(s,"margin-top","-80px"),xt(s,"class","bg-backgroundDark svelte-1lk48pw")},m(t,e){tt(t,n,e),tt(t,s,e),ht(l,s,null),Vt(s,r),ht(o,s,null),a=!0},p(t,[e]){const n={};5&e&&(n.$$scope={dirty:e,ctx:t}),l.$set(n);const s={};4&e&&(s.$$scope={dirty:e,ctx:t}),o.$set(s)},i(t){a||(st(l.$$.fragment,t),st(o.$$.fragment,t),a=!0)},o(t){lt(l.$$.fragment,t),lt(o.$$.fragment,t),a=!1},d(t){t&&Q(n),t&&Q(s),wt(l),wt(o)}}}function P(t,e,n){let{$$slots:s={},$$scope:l}=e,{blueprint:r={button:new Ft,children:[AwardImage],header:new Zt("Städtisches Louise Schroeder Gymnasium München"),img:new te("https://lsg.musin.de/homepage/images/header-images/schulhof_mini.jpg"),note:new Zt("Referenzschule der TU München"),subHeader:new Zt("Naturwissenschaftlich-technologisches und sprachliches Gymnasium.")}}=e;return t.$$set=t=>{"blueprint"in t&&n(0,r=t.blueprint),"$$scope"in t&&n(2,l=t.$$scope)},[r,s,l]}function R(t){let e,n,s;var l=t[4];return l&&(n=new l({})),{c(){e=J("div"),n&&mt(n.$$.fragment),this.h()},l(t){e=K(t,"DIV",{class:!0});var s=Y(e);n&&pt(n.$$.fragment,s),s.forEach(Q),this.h()},h(){xt(e,"class","m-4 pointer-events-none")},m(t,l){tt(t,e,l),n&&ht(n,e,null),s=!0},p(t,s){if(l!==(l=t[4])){if(n){rt();const t=n;lt(t.$$.fragment,1,0,()=>{wt(t,1)}),ot()}l?(n=new l({}),mt(n.$$.fragment),st(n.$$.fragment,1),ht(n,e,null)):n=null}},i(t){s||(n&&st(n.$$.fragment,t),s=!0)},o(t){n&&lt(n.$$.fragment,t),s=!1},d(t){t&&Q(e),n&&wt(n)}}}function q(t){function e(e){t[6].call(null,e)}let n,s,l,r,o,a,c;n=new Pt({});let i={saving:t[2]};return void 0!==t[3]&&(i.component=t[3]),l=new Component({props:i}),ft.push(()=>It(l,"component",e)),l.$on("update",t[5]),a=new Rt({}),{c(){mt(n.$$.fragment),s=yt(),mt(l.$$.fragment),o=yt(),mt(a.$$.fragment)},l(t){pt(n.$$.fragment,t),s=Et(t),pt(l.$$.fragment,t),o=Et(t),pt(a.$$.fragment,t)},m(t,e){ht(n,t,e),tt(t,s,e),ht(l,t,e),tt(t,o,e),ht(a,t,e),c=!0},p(t,e){const n={};4&e&&(n.saving=t[2]),!r&&8&e&&(r=!0,n.component=t[3],vt(()=>r=!1)),l.$set(n)},i(t){c||(st(n.$$.fragment,t),st(l.$$.fragment,t),st(a.$$.fragment,t),c=!0)},o(t){lt(n.$$.fragment,t),lt(l.$$.fragment,t),lt(a.$$.fragment,t),c=!1},d(t){wt(n,t),t&&Q(s),wt(l,t),t&&Q(o),wt(a,t)}}}function U(t){function e(t){return!0===t[0]&&!1===t[1]&&!1===t[4]?0:!1!==t[4]?1:-1}let n,s,l,r;const o=[q,R],a=[];return~(n=e(t))&&(s=a[n]=o[n](t)),{c(){s&&s.c(),l=nt()},l(t){s&&s.l(t),l=nt()},m(t,e){~n&&a[n].m(t,e),tt(t,l,e),r=!0},p(t,[r]){let c=n;n=e(t),n===c?~n&&a[n].p(t,r):(s&&(rt(),lt(a[c],1,1,()=>{a[c]=null}),ot()),~n?(s=a[n],s||(s=a[n]=o[n](t),s.c()),st(s,1),s.m(l.parentNode,l)):s=null)},i(t){r||(st(s),r=!0)},o(t){lt(s),r=!1},d(t){~n&&a[n].d(t),t&&Q(l)}}}function F(t,e,n){const s=[Article,ArticleSection,Xt,TestHero,AwardImage,Empty,Ut,Wt,Jt,se,Kt];let l,r=!1,o=!1,a=!1,c=!1;return zt(()=>{n(3,l=void 0);const t=Object.fromEntries(new URLSearchParams(window.location.search).entries());if(void 0!==t.component)return void n(4,(e=t.component,c=s.find(t=>t.name===e)));var e;window.document.addEventListener("c_created",t=>{n(3,l=t.detail)},!1),window.document.addEventListener("c_resume",t=>{const e=t.detail.blueprint;n(3,l=new le(t.detail.table,t.detail.page.id).createFromData(e,s,null)),n(0,r=!0)},!1),window.document.addEventListener("c_new",()=>{n(3,l=new le(Empty,void 0)),n(0,r=!0)},!1),window.document.addEventListener("c_fetched",t=>{Yt.set(t.detail.table),Qt.set(t.detail.page)},!1),window.document.addEventListener("c_start_saving",()=>{n(2,a=!0)},!1),window.document.addEventListener("c_stop_saving",()=>{n(2,a=!1)},!1),window.document.addEventListener("c_reload",async()=>{n(1,o=!0),await ut(),n(1,o=!1)},!1),async function(){const t=await qt("/api/files?_norelations=true&public=true","get",{},!0);t.error||ee.set(t.data.files)}();const i=new CustomEvent("components",{detail:s});window.parent.document.dispatchEvent(i);const d=new CustomEvent("iframe_mounted",{detail:{}});window.parent.document.dispatchEvent(d)}),[r,o,a,l,c,function(){const t=new CustomEvent("c_update",{detail:l});window.parent.document.dispatchEvent(t)},function(t){l=t,n(3,l)}]}import{S as Z,i as W,s as X,e as J,b as K,d as Y,g as Q,m as tt,u as et,y as nt,p as st,q as lt,G as rt,H as ot,z as at,Z as ct,I as it,aa as dt,a6 as ut,K as ft,c as mt,j as pt,o as ht,W as $t,X as gt,r as wt,V as bt,O as vt,k as xt,a as yt,h as Et,M as It,F as kt,t as jt,f as Dt,l as Ht,n as Vt,D as Lt,E as St,C as Tt,a1 as Nt,w as Ct,N as _t,P as At,J as zt,a2 as Bt,x as Ot,A as Mt,B as Gt,ab as Pt,ac as Rt,$ as qt}from"./client.b007dbf1.js";import{C as Ut}from"./Calender.c0570c16.js";import"./Input.9fb47177.js";import"./time.4604e9c6.js";import{L as Ft}from"./Link.6aef1317.js";import{S as Zt}from"./ShortText.0394cb61.js";import{S as Wt}from"./sectionWrapper.c54178d4.js";import{B as Xt,A as Jt,S as Kt}from"./staffCard.1426063d.js";import"./Card.35ee62b6.js";import"./EntriesFound.0de26394.js";import"./Button.b1699f39.js";import{p as Yt,a as Qt,I as te,f as ee}from"./Img.58920e98.js";import{L as ne}from"./LongText.c4f18048.js";import{M as se}from"./MensaCard.141f1d6a.js";import{E as le}from"./EditComponent.2b321085.js";class Component extends Z{constructor(t){super(),W(this,t,$,h,X,{component:0,saving:1},[-1,-1])}}class Empty extends Z{constructor(t){super(),W(this,t,w,g,X,{blueprint:0})}}class ArticleSection extends Z{constructor(t){super(),W(this,t,v,b,X,{blueprint:0,component:1})}}const{window:re}=Bt;class Article extends Z{constructor(t){super(),W(this,t,_,N,X,{img:0,blueprint:1,component:2})}}class AwardImage extends Z{constructor(t){super(),W(this,t,z,A,X,{blueprint:0})}}class TestHero extends Z{constructor(t){super(),W(this,t,P,G,X,{blueprint:0})}}export default class New extends Z{constructor(t){super(),W(this,t,F,U,X,{})}}