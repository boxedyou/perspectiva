function getScrollbarWidth() {
    const outer = document.createElement('div');
    outer.style.cssText = 'overflow:scroll;visibility:hidden;position:absolute;width:100px;height:100px;';
    document.body.appendChild(outer);

    const inner = document.createElement('div');
    inner.style.width = '100%';
    outer.appendChild(inner);

    const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
    outer.parentNode.removeChild(outer);

    return scrollbarWidth;
}