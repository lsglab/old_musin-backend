function e(e){function t(t){e[7].call(null,t)}function s(t){e[8].call(null,t)}let n,i,a,r,f,y,k,S,R,q,C,F,G,H,J={id:"text-"+e[3],classes:"mx-2",type:"text"};void 0!==e[0]&&(J.value=e[0]),n=new V({props:J}),x.push(()=>I(n,"value",t));let K={id:"link-"+e[3],classes:"mx-2",type:"url",placeholder:"Url des Links"};return void 0!==e[1]&&(K.value=e[1]),r=new V({props:K}),x.push(()=>I(r,"value",s)),{c(){l(n.$$.fragment),a=L(),l(r.$$.fragment),y=L(),k=o("div"),S=E("done"),R=L(),q=o("div"),C=E("close"),this.h()},l(e){var t,s;h(n.$$.fragment,e),a=w(e),h(r.$$.fragment,e),y=w(e),k=c(e,"DIV",{class:!0}),t=d(k),S=D(t,"done"),t.forEach(u),R=w(e),q=c(e,"DIV",{class:!0}),s=d(q),C=D(s,"close"),s.forEach(u),this.h()},h(){p(k,"class","material-icons text-cmsSuccessGreen svelte-1gmbzvo"),p(q,"class","material-icons text-cmsErrorRed svelte-1gmbzvo")},m(t,s){$(n,t,s),m(t,a,s),$(r,t,s),m(t,y,s),m(t,k,s),B(k,S),m(t,R,s),m(t,q,s),B(q,C),F=!0,G||(H=[j(k,"click",e[5]),j(q,"click",e[4])],G=!0)},p(e,t){const s={};8&t&&(s.id="text-"+e[3]),!i&&1&t&&(i=!0,s.value=e[0],z(()=>i=!1)),n.$set(s);const a={};8&t&&(a.id="link-"+e[3]),!f&&2&t&&(f=!0,a.value=e[1],z(()=>f=!1)),r.$set(a)},i(e){F||(v(n.$$.fragment,e),v(r.$$.fragment,e),F=!0)},o(e){g(n.$$.fragment,e),g(r.$$.fragment,e),F=!1},d(e){b(n,e),e&&u(a),b(r,e),e&&u(y),e&&u(k),e&&u(R),e&&u(q),G=!1,M(H)}}}function t(t){let s,n,i,a;return n=new r({props:{align:"center",$$slots:{default:[e]},$$scope:{ctx:t}}}),{c(){s=o("div"),l(n.$$.fragment),this.h()},l(e){s=c(e,"DIV",{id:!0,class:!0,style:!0});var t=d(s);h(n.$$.fragment,t),t.forEach(u),this.h()},h(){p(s,"id",t[3]),p(s,"class",i="absolute rounded-sm z-50 cursor-default p-2 origin-center bg-white border border-gray-400 border-solid shadow-md pos "+(t[2]?"opacity-100 pointer-events-auto":"opacity-0 pointer-events-none")),f(s,"transform","translate(-50%,-50%)")},m(e,t){m(e,s,t),$(n,s,null),a=!0},p(e,[t]){const r={};2059&t&&(r.$$scope={dirty:t,ctx:e}),n.$set(r),(!a||8&t)&&p(s,"id",e[3]),(!a||4&t&&i!==(i="absolute rounded-sm z-50 cursor-default p-2 origin-center bg-white border border-gray-400 border-solid shadow-md pos "+(e[2]?"opacity-100 pointer-events-auto":"opacity-0 pointer-events-none")))&&p(s,"class",i)},i(e){a||(v(n.$$.fragment,e),a=!0)},o(e){g(n.$$.fragment,e),a=!1},d(e){e&&u(s),b(n)}}}function s(e,t,s){let{data:n}=t,{id:i}=t,{href:a=""}=t,{document:r}=t;const o=y();let{visible:l=!1}=t;return k(()=>{!function(){const e=r.getElementById(i),t=e.getBoundingClientRect();let s=0;const n=[],a=r.documentElement.scrollHeight,o=r.documentElement.scrollWidth;t.x<0&&(n.push("left"),s=Math.abs(t.x)+10),t.x>o&&(n.push("right"),s=t.x-o+10),t.y<0&&(n.push("top"),s=Math.abs(t.y)+10),t.y>a&&(n.push("bottom"),s=t.y-a+10),n.forEach(t=>{e.style[t]=s+"px"}),0===n.length&&(e.style.left="50%",e.style.top="50%")}()}),e.$$set=e=>{"data"in e&&s(0,n=e.data),"id"in e&&s(3,i=e.id),"href"in e&&s(1,a=e.href),"document"in e&&s(6,r=e.document),"visible"in e&&s(2,l=e.visible)},[n,a,l,i,function(){o("close",{href:!1}),s(2,l=!1)},function(){o("save",{data:n,href:a}),s(2,l=!1)},r,function(e){n=e,s(0,n)},function(e){a=e,s(1,a)}]}import{S as n,i,s as a,F as r,e as o,c as l,b as c,d,j as h,g as u,k as p,l as f,m,o as $,p as v,q as g,r as b,I as y,J as k,K as x,M as I,a as L,t as E,h as w,f as D,n as B,N as j,O as z,P as M}from"./client.897a0b43.js";import{B as S}from"./ShortText.6bb5c387.js";import{I as V}from"./Input.ec502a97.js";class EditLink extends n{constructor(e){super(),i(this,e,s,t,a,{data:0,id:3,href:1,document:6,visible:2})}}class Link extends S{constructor(e="Link",t="https://example.com"){super(e),this.type="link",this.href=t,this.editLinkID="edit-"+this.id}newLink(e,t,s){return new EditLink({props:{data:this.data,document:s,href:this.href,id:t},target:e})}prepareInput(e,t){function s(){i.$set({visible:!1}),a=!0}const n=e.getElementById(this.id),i=this.newLink(n,this.editLinkID,e);let a=!1;n.addEventListener("click",t=>{t.preventDefault(),e.getElementById(this.editLinkID),a?a=!1:i.$set({visible:!0})}),i.$on("close",()=>{s()}),i.$on("save",e=>{this.href=e.detail.href,this.data=e.detail.data,t(),s()})}save(e){const t=super.save(e);return t.href=this.href,t.editLinkID=this.editLinkID,t}deleteInput(e){e.getElementById(this.editLinkID).remove()}}export{Link as L};
