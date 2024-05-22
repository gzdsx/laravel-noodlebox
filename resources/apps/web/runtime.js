import NoodleBoxApp from "./components/NoodleBoxApp.vue";

new Vue({
    el: '#noodlebox',
    render: function (h) {
        return h(NoodleBoxApp)
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const config = {
        rootMargin: '0px 0px 50px 0px', // 页面底部50px处开始加载
        threshold: 0
    };

    const observer = new IntersectionObserver(function(entries, self) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                self.unobserve(img); // 停止观察这个图片
            }
        });
    }, config);

    const images = document.querySelectorAll('img[data-src]');
    images.forEach(function(img) {
        observer.observe(img);
    });
});