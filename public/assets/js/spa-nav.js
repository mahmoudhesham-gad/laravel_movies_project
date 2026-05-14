(function () {
    'use strict';

    var mainSel = '#app-content';

    function isLoopbackHost(hostname) {
        if (!hostname) return false;
        var h = String(hostname).toLowerCase();
        return h === 'localhost' || h === '127.0.0.1' || h === '[::1]';
    }

    function spaFetchUrl(url) {
        try {
            if (url.pathname.indexOf('/storage/') === 0) return null;
            if (url.origin === location.origin) return url.href;
            if (
                url.protocol === location.protocol &&
                String(url.port) === String(location.port) &&
                isLoopbackHost(url.hostname) &&
                isLoopbackHost(location.hostname)
            ) {
                return location.origin + url.pathname + url.search + url.hash;
            }
        } catch (e) {}
        return null;
    }

    function updateNavActive(pathname) {
        var links = document.querySelectorAll('.nav-links a');
        for (var i = 0; i < links.length; i++) links[i].classList.remove('active');
        var home = document.getElementById('nav-home');
        var movies = document.getElementById('nav-movies');
        var fav = document.getElementById('nav-favorites');
        if (pathname === '/' || pathname === '') {
            if (home) home.classList.add('active');
            if (movies) movies.classList.add('active');
        } else if (pathname.indexOf('/favorites') === 0) {
            if (fav) fav.classList.add('active');
        }
    }

    function titleFromDoc(doc) {
        var t = doc.querySelector('title');
        return t ? t.textContent.trim() : document.title;
    }

    function runScriptsFromFetchedDocument(doc) {
        var scripts = doc.body.querySelectorAll('script');
        if (!window.__spaExecutedSrc) window.__spaExecutedSrc = new Set();
        for (var i = 0; i < scripts.length; i++) {
            var old = scripts[i];
            if (old.hasAttribute('data-spa-ignore')) continue;
            if (old.src && old.src.indexOf('spa-nav.js') !== -1) continue;
            if (old.src) {
                var abs = new URL(old.getAttribute('src'), location.origin).href;
                if (window.__spaExecutedSrc.has(abs)) continue;
                window.__spaExecutedSrc.add(abs);
                var ext = document.createElement('script');
                ext.src = old.getAttribute('src');
                ext.async = false;
                document.body.appendChild(ext);
                continue;
            }
            var inline = document.createElement('script');
            inline.textContent = old.textContent;
            document.body.appendChild(inline);
        }
    }

    function navigate(url, opts) {
        opts = opts || {};
        var push = opts.push !== false;
        var main = document.querySelector(mainSel);
        if (!main) return Promise.reject(new Error('no main'));

        return fetch(url, {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'text/html',
            },
        })
            .then(function (res) {
                if (!res.ok) {
                    if (res.status === 401 || res.status === 403) {
                        window.location.href = url;
                        return null;
                    }
                    throw new Error(String(res.status));
                }
                var finalUrl = res.url || url;
                return res.text().then(function (html) {
                    return { html: html, finalUrl: finalUrl };
                });
            })
            .then(function (payload) {
                if (!payload || !payload.html) return;
                var html = payload.html;
                var finalUrl = payload.finalUrl;
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var nextMain = doc.querySelector(mainSel);
                if (!nextMain) {
                    window.location.href = finalUrl;
                    return;
                }
                main.innerHTML = nextMain.innerHTML;
                document.title = titleFromDoc(doc);
                runScriptsFromFetchedDocument(doc);
                try {
                    updateNavActive(new URL(finalUrl, location.href).pathname);
                } catch (err) {
                    updateNavActive(location.pathname);
                }
                if (push) {
                    history.pushState({ spa: 1 }, '', finalUrl);
                }
                window.scrollTo(0, 0);
            })
            .catch(function () {
                window.location.href = url;
            });
    }

    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        var a = e.target.closest && e.target.closest('a[href]');
        if (!a || a.target === '_blank') return;
        if (a.hasAttribute('download')) return;
        var href = a.getAttribute('href');
        if (!href || href.charAt(0) === '#') return;
        var url = new URL(a.href, location.href);
        var fetchUrl = spaFetchUrl(url);
        if (!fetchUrl) return;
        e.preventDefault();
        navigate(fetchUrl, { push: true });
    }, true);

    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form || form.tagName !== 'FORM') return;
        if ((form.method || '').toLowerCase() !== 'get') return;
        if (form.hasAttribute('data-no-spa')) return;
        var url = new URL(form.action, location.href);
        var fd = new FormData(form);
        var keys = [];
        fd.forEach(function (_, k) {
            if (keys.indexOf(k) === -1) keys.push(k);
        });
        for (var j = 0; j < keys.length; j++) {
            url.searchParams.delete(keys[j]);
        }
        fd.forEach(function (v, k) {
            if (v != null && String(v) !== '') url.searchParams.set(k, v);
        });
        var fetchUrl = spaFetchUrl(url);
        if (!fetchUrl) return;
        e.preventDefault();
        navigate(fetchUrl, { push: true });
    }, true);

    window.addEventListener('popstate', function () {
        navigate(location.href, { push: false });
    });

    if (history.replaceState) {
        history.replaceState({ spa: 1 }, '', location.href);
    }
})();
