/**
 * Teznevisan Single Post Enhancements
 * Version: 3.0.0
 */
(function(){
    'use strict';
    if(!document.body.classList.contains('single-post'))return;

    /* ===== READING PROGRESS BAR ===== */
    function initReadingProgress(){
        var bar=document.getElementById('tez-reading-progress-bar');
        if(!bar)return;
        var article=document.querySelector('.tez-post-content-main')||document.querySelector('.entry-content')||document.querySelector('article');
        if(!article)return;
        function update(){
            var r=article.getBoundingClientRect();
            var aTop=r.top+window.pageYOffset;
            var aH=article.offsetHeight;
            var wH=window.innerHeight;
            var sT=window.pageYOffset;
            var start=aTop-wH;
            var end=aTop+aH;
            var cur=sT-start;
            var total=end-start;
            var pct=Math.min(100,Math.max(0,(cur/total)*100));
            bar.style.width=pct+'%';
        }
        window.addEventListener('scroll',update,{passive:true});
        update();
    }

    /* ===== TABLE OF CONTENTS ===== */
    function initTOC(){
        var toc=document.getElementById('tez-toc');
        var toggle=document.getElementById('tez-toc-toggle');
        var list=document.getElementById('tez-toc-list');
        if(!toc||!toggle||!list)return;
        toggle.addEventListener('click',function(){
            var exp=this.getAttribute('aria-expanded')==='true';
            this.setAttribute('aria-expanded',!exp);
            list.classList.toggle('collapsed',exp);
        });
        var headings=document.querySelectorAll('.tez-heading-anchor');
        var links=list.querySelectorAll('a');
        if(!headings.length||!links.length)return;
        function highlight(){
            var pos=window.pageYOffset+150;
            var idx=0;
            headings.forEach(function(h,i){if(h.offsetTop<=pos)idx=i;});
            links.forEach(function(l,i){l.classList.toggle('active',i===idx);});
        }
        window.addEventListener('scroll',highlight,{passive:true});
        highlight();
        links.forEach(function(link){
            link.addEventListener('click',function(e){
                e.preventDefault();
                var id=this.getAttribute('href').slice(1);
                var el=document.getElementById(id);
                if(el){window.scrollTo({top:el.offsetTop-100,behavior:'smooth'});}
            });
        });
    }

    /* ===== FAQ ACCORDION ===== */
    function initFAQ(){
        document.querySelectorAll('.tez-faq-item').forEach(function(item){
            var q=item.querySelector('.tez-faq-question');
            if(!q)return;
            q.addEventListener('click',function(){
                var active=item.classList.contains('active');
                document.querySelectorAll('.tez-faq-item.active').forEach(function(o){
                    if(o!==item){o.classList.remove('active');var oq=o.querySelector('.tez-faq-question');if(oq)oq.setAttribute('aria-expanded','false');}
                });
                item.classList.toggle('active',!active);
                this.setAttribute('aria-expanded',!active);
            });
        });
    }

    /* ===== SHARE BUTTONS ===== */
    function initShare(){
        document.querySelectorAll('.tez-copy-link').forEach(function(btn){
            btn.addEventListener('click',function(e){
                e.preventDefault();
                var c=this.closest('[data-post-url]');
                var url=c?c.dataset.postUrl:window.location.href;
                navigator.clipboard.writeText(url).then(function(){notify('\u0644\u06cc\u0646\u06a9 \u06a9\u067e\u06cc \u0634\u062f!');}).catch(function(){
                    var ta=document.createElement('textarea');ta.value=url;document.body.appendChild(ta);ta.select();document.execCommand('copy');document.body.removeChild(ta);notify('\u0644\u06cc\u0646\u06a9 \u06a9\u067e\u06cc \u0634\u062f!');
                });
            });
        });
        document.querySelectorAll('.tez-share-btn:not(.tez-copy-link)').forEach(function(link){
            link.addEventListener('click',function(e){
                if(this.getAttribute('target')==='_blank'){
                    e.preventDefault();
                    var w=600,h=400,l=(screen.width-w)/2,t=(screen.height-h)/2;
                    window.open(this.getAttribute('href'),'share','width='+w+',height='+h+',left='+l+',top='+t+',toolbar=no,menubar=no,scrollbars=yes');
                }
            });
        });
    }

    function notify(msg){
        var old=document.querySelector('.tez-copy-notification');
        if(old)old.remove();
        var el=document.createElement('div');
        el.className='tez-copy-notification';
        el.innerHTML='<i class="fa-solid fa-check-circle"></i>'+msg;
        document.body.appendChild(el);
        requestAnimationFrame(function(){el.classList.add('show');});
        setTimeout(function(){el.classList.remove('show');setTimeout(function(){el.remove();},300);},2000);
    }

    /* ===== HEADING LINKS ===== */
    function initHeadingLinks(){
        document.querySelectorAll('.tez-heading-link').forEach(function(link){
            link.addEventListener('click',function(e){
                e.preventDefault();
                var url=window.location.href.split('#')[0]+this.getAttribute('href');
                navigator.clipboard.writeText(url).then(function(){notify('\u0644\u06cc\u0646\u06a9 \u0628\u062e\u0634 \u06a9\u067e\u06cc \u0634\u062f!');});
            });
        });
    }

    /* ===== EXTERNAL LINKS ===== */
    function initExternalLinks(){
        var content=document.querySelector('.tez-post-content-main')||document.querySelector('.entry-content');
        if(!content)return;
        var host=window.location.hostname;
        content.querySelectorAll('a[href^="http"]').forEach(function(link){
            try{
                var u=new URL(link.href);
                if(u.hostname!==host){
                    link.setAttribute('target','_blank');
                    link.setAttribute('rel','noopener noreferrer');
                    if(!link.querySelector('.fa-arrow-up-right-from-square')){
                        var i=document.createElement('i');
                        i.className='fa-solid fa-arrow-up-right-from-square';
                        i.style.cssText='font-size:.75em;margin-right:.25rem;opacity:.7;';
                        link.appendChild(i);
                    }
                }
            }catch(e){}
        });
    }

    /* ===== INIT ===== */
    function init(){
        initReadingProgress();
        initTOC();
        initFAQ();
        initShare();
        initHeadingLinks();
        initExternalLinks();
    }
    if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',init);}else{init();}
})();
