function s(s){let a,e,t,r=s[1].header.data+"";return{c(){a=f("div"),e=g(r),this.h()},l(s){a=p(s,"DIV",{slot:!0,class:!0,id:!0});var t=b(a);e=$(t,r),t.forEach(k),this.h()},h(){w(a,"slot","header"),w(a,"class","flex items-center ml-4 h-1/5"),w(a,"id",t=s[1].header.id)},m(s,t){x(s,a,t),j(a,e)},p(s,i){2&i&&r!==(r=s[1].header.data+"")&&y(e,r),2&i&&t!==(t=s[1].header.id)&&w(a,"id",t)},d(s){s&&k(a)}}}function a(s){let a,e;return{c(){a=f("div"),this.h()},l(s){a=p(s,"DIV",{slot:!0,class:!0,id:!0,style:!0}),b(a).forEach(k),this.h()},h(){w(a,"slot","body"),w(a,"class","bg-center bg-no-repeat bg-cover h-4/5"),w(a,"id",e=s[1].img.id),v(a,"background-image","url("+s[1].img.data+")")},m(s,e){x(s,a,e)},p(s,t){2&t&&e!==(e=s[1].img.id)&&w(a,"id",e),2&t&&v(a,"background-image","url("+s[1].img.data+")")},d(s){s&&k(a)}}}function e(){let s;return{c(){s=C()},l(a){s=I(a)},m(a,e){x(a,s,e)},p:D,d(a){a&&k(s)}}}function t(t){let r,i;return r=new S({props:{link:t[0],classes:"lg:w-1/3 md:w-1/2 w-full m-5 lg:m-10 h-60",$$slots:{default:[e],body:[a],header:[s]},$$scope:{ctx:t}}}),{c(){d(r.$$.fragment)},l(s){o(r.$$.fragment,s)},m(s,a){c(r,s,a),i=!0},p(s,[a]){const e={};1&a&&(e.link=s[0]),6&a&&(e.$$scope={dirty:a,ctx:s}),r.$set(e)},i(s){i||(h(r.$$.fragment,s),i=!0)},o(s){m(r.$$.fragment,s),i=!1},d(s){u(r,s)}}}function r(s,a,e){let{href:t=""}=a,{blueprint:r={header:new M("Titel"),img:new T("https://i.stack.imgur.com/y9DpT.jpg")}}=a;return s.$$set=s=>{"href"in s&&e(0,t=s.href),"blueprint"in s&&e(1,r=s.blueprint)},[t,r]}import{S as i,i as n,s as l,c as d,j as o,o as c,p as h,q as m,r as u,e as f,t as g,b as p,d as b,f as $,g as k,k as w,m as x,n as j,C as y,l as v,a as C,h as I,u as D}from"./client.897a0b43.js";import{S as M}from"./ShortText.6bb5c387.js";import{C as S,I as T}from"./Img.2a054bb6.js";class MensaCard extends i{constructor(s){super(),n(this,s,r,t,l,{href:0,blueprint:1})}}export{MensaCard as M};