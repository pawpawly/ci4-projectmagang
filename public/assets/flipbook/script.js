$(function () {
  // Fungsi untuk mengatur posisi hover-menu
  var onScroll = function () {
      var y = $(document).scrollTop();
      $('.hover-menu').css('top', (y < 60 ? 90 - y : 10) + 'px');
  };

  $(document).on('scroll', onScroll);
  onScroll();
});

(function () {
  var wnd = $(window), menu = $('.hover-menu'), base = $('.site>.container');

  wnd.on('resize', function () {
      // Cek apakah elemen base ada di halaman
      if (base.length > 0) {
          var pad = 20, left = (base.offset().left - menu.width() - pad) / 2;
          menu.css('left', left + 'px');
          menu.css('display', left < pad ? 'none' : 'block');
      }
  });

  wnd.trigger('resize');
})();

// Fungsi untuk membuka source code (jika digunakan)
$('.show-source').click(function (e) {
  e.preventDefault();
  var sourceWindow = window.open('', 'Source code', 'height=800,width=800,scrollbars=1,resizable=1');
  if (window.focus) sourceWindow.focus();
  $.get('pages/' + $(e.target).attr('data') + '.php', function (source) {
      source = source.replace(/(<p>|<pre>)(.|\n|\r)*(<\/p>|<\/pre>)/gm, '');
      source = [
          '<!DOCTYPE html>\n<html>\n<head>\n<meta charset="utf-8">\n<title>Source code</title>\n<link rel="stylesheet" href="css/style.css">\n<script src="js/jquery.min.js"></script>\n</head>\n<body>\n',
          source,
          '</body>\n</html>\n'
      ].join('');
      source = source.replace(/</g, "&lt;").replace(/>/g, "&gt;");
      source = ['<pre><code class="html">', source, '</code></pre>'].join('');
      $(sourceWindow.document.body).html(source);
      $.get('css/highlight.min.css', function (s) {
          $(sourceWindow.document.head).append(['<style type="text/css">', s, '</style>'].join(''));
      });
      $.get('js/highlight.min.js', function (s) {
          $('<script>').text(s + 'hljs.initHighlighting();').appendTo(sourceWindow.document.body);
      });
  });
});

// Modal effect
$('.modal .cmd-close').click(function (e) {
  e.preventDefault();
  $('.modal').modal('hide');
});

// Lightbox Effect
var fb3d = {
  activeModal: undefined,
  capturedElement: undefined
};

(function () {
  function findParent(parent, node) {
      while (parent && parent != node) {
          parent = parent.parentNode;
      }
      return parent;
  }

  $('body').on('mousedown', function (e) {
      fb3d.capturedElement = e.target;
  });

  $('body').on('click', function (e) {
      if (fb3d.activeModal && fb3d.capturedElement === e.target) {
          if (
              !findParent(e.target, fb3d.activeModal[0]) ||
              findParent(e.target, fb3d.activeModal.find('.cmd-close')[0])
          ) {
              e.preventDefault();
              fb3d.activeModal.fb3dModal('hide');
          }
      }
      delete fb3d.capturedElement;
  });
})();

// Fungsi untuk menampilkan Flipbook
function initializeFlipbook(pdfPath, containerSelector) {
  console.log("Loading PDF for Flipbook:", pdfPath);

  // Gunakan pdf.js untuk memuat halaman
  const flipbookContainer = document.querySelector(containerSelector);
  if (!flipbookContainer) {
      console.error("Container not found for selector:", containerSelector);
      return;
  }

  // Hapus isi kontainer sebelumnya
  flipbookContainer.innerHTML = "";

  // Tambahkan elemen flipbook
  const flipbook = document.createElement("div");
  flipbook.id = "flipbook";
  flipbookContainer.appendChild(flipbook);

  // Konfigurasi worker PDF.js
  pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js";

  // Muat PDF
  const loadingTask = pdfjsLib.getDocument(pdfPath);
  loadingTask.promise
      .then(function (pdf) {
          console.log("PDF loaded");
          let pagesRendered = 0;

          // Loop melalui semua halaman PDF
          for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
              pdf.getPage(pageNum).then(function (page) {
                  const viewport = page.getViewport({ scale: 2 });
                  const canvas = document.createElement("canvas");
                  const context = canvas.getContext("2d");

                  canvas.width = viewport.width;
                  canvas.height = viewport.height;

                  const renderContext = {
                      canvasContext: context,
                      viewport: viewport,
                  };

                  page.render(renderContext).promise.then(function () {
                      console.log(`Page ${pageNum} rendered`);

                      // Tambahkan halaman ke flipbook
                      const pageWrapper = document.createElement("div");
                      pageWrapper.classList.add("page");
                      pageWrapper.style.width = `${viewport.width}px`;
                      pageWrapper.style.height = `${viewport.height}px`;
                      pageWrapper.appendChild(canvas);

                      flipbook.appendChild(pageWrapper);

                      pagesRendered++;

                      // Inisialisasi Turn.js setelah semua halaman dirender
                      if (pagesRendered === pdf.numPages) {
                          $(flipbook).turn({
                              width: viewport.width * 2, // Atur lebar total
                              height: viewport.height,  // Atur tinggi total
                              autoCenter: true,
                              duration: 1000,           // Waktu animasi dalam ms
                          });
                      }
                  });
              });
          }
      })
      .catch(function (error) {
          console.error("Error loading PDF:", error);
      });
}



$.fn.fb3dModal = function (cmd) {
  setTimeout(
      function () {
          function fb3dModalShow() {
              if (!this.hasClass('visible')) {
                  $('body').addClass('fb3d-modal-shadow');
                  this.addClass('visible');
                  fb3d.activeModal = this;
                  this.trigger('fb3d.modal.show');
              }
          }

          function fb3dModalHide() {
              if (this.hasClass('visible')) {
                  $('body').removeClass('fb3d-modal-shadow');
                  this.removeClass('visible');
                  fb3d.activeModal = undefined;
                  this.trigger('fb3d.modal.hide');
              }
          }

          var mdls = this.filter('.fb3d-modal');
          switch (cmd) {
              case 'show':
                  fb3dModalShow.call(mdls);
                  break;
              case 'hide':
                  fb3dModalHide.call(mdls);
                  break;
          }
      }.bind(this),
      50
  );
};
