// Markdownを適用
let content_dom = document.querySelectorAll('.content');
content_dom.forEach(function(dom) {
  // console.log(dom);
  let html = marked.parse(dom.textContent);
  // console.log(html);
  dom.innerHTML = html;
});

// スムーズスクロール
window.addEventListener('DOMContentLoaded', () => {
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  const anchorLinksArr = Array.prototype.slice.call(anchorLinks);

  anchorLinksArr.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const targetId = link.hash;
      const targetElement = document.querySelector(targetId);
      const targetOffsetTop =
        window.pageYOffset + targetElement.getBoundingClientRect().top;
      window.scrollTo({
        top: targetOffsetTop,
        behavior: 'smooth'
      });
    });
  });
});
