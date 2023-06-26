(function () {
    let endpoint = '{{endpoint}}';
    if (endpoint.indexOf('{endpoint}') != -1) {
        endpoint = '';
    }
    if (!endpoint) {
        consolog.info('no endpoint')
        return;
    }


    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                loadJs(response.preload_js).then(function () {
                    loadJs(response.js).then(function () {
                        loadJs(response.action)
                    })
                })
                loadCss(response.css).then(function () {

                })
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        }
    };

    xhr.open('GET', endpoint);
    xhr.send();


    function loadJs(urls) {
        const promises = [];
        for (let url of urls) {
            const promise = new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.type = 'text/javascript';
                if (isObject(url)) {
                    script.src = url.url;
                } else {
                    script.src = url;
                }
                script.onload = () => resolve(url);
                script.onerror = () => reject(new Error(`Failed to load ${url}`));
                document.body.appendChild(script);
            });

            promises.push(promise);
        }

        return Promise.all(promises);
    }


    function loadCss(urls) {
        const promises = [];

        for (let url of urls) {
            const promise = new Promise((resolve, reject) => {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                if (isObject(url)) {
                    link.href = url.url;
                } else { 
                    link.href = url;
                }
                link.onload = () => resolve(url);
                link.onerror = () => reject(new Error(`Failed to load ${url}`));
                document.head.appendChild(link);
            });

            promises.push(promise);
        }

        return Promise.all(promises);
    }
    function isObject(value) {
        return Object.prototype.toString.call(value) === '[object Object]';
    }
})();