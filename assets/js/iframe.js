(function () {

    // create the iframe element
    const iframe = document.createElement('iframe');
    let unique_class = ;

    // set the iframe attributes
    iframe.setAttribute('src', 'https://wintercms122.xiaofuwu.wpjs.cc/backend/wpjscc/js/index/html/WoQXvJPilB');
    iframe.setAttribute('width', '100%');
    iframe.setAttribute('height', '500px');
    iframe.setAttribute('frameborder', '0');

    const p = document.createElement('p');
    p.textContent = 'This is a paragraph element';
    iframe.contentDocument.body.appendChild(p);


    iframe.classList.add(unique_class);

    // append the iframe to the document body
    document.body.appendChild(iframe);

    // target elements with the "draggable" class
    interact('.' + unique_class)
        .draggable({
            // enable inertial throwing
            inertia: true,
            // keep the element within the area of it's parent
            modifiers: [
                interact.modifiers.restrictRect({
                    restriction: 'parent',
                    endOnly: true
                })
            ],
            // enable autoScroll
            autoScroll: true,

            listeners: {
                // call this function on every dragmove event
                move: dragMoveListener,

                // call this function on every dragend event
                end(event) {
                    var textEl = event.target.querySelector('p')

                    textEl && (textEl.textContent =
                        'moved a distance of ' +
                        (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
                            Math.pow(event.pageY - event.y0, 2) | 0))
                            .toFixed(2) + 'px')
                }
            }
        })

    function dragMoveListener(event) {
        var target = event.target
        // keep the dragged position in the data-x/data-y attributes
        var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
        var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy

        // translate the element
        target.style.transform = 'translate(' + x + 'px, ' + y + 'px)'

        // update the posiion attributes
        target.setAttribute('data-x', x)
        target.setAttribute('data-y', y)
    }

})()