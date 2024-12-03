<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    
    <!-- Include CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/3/turn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

</head>
<body>
    <!-- Kontainer Flipbook -->
    <div id="flipbook-container">
        <div id="flipbook"></div>
    </div>

    <!-- Tombol Navigasi -->
    <div class="navigation">
        <button id="prev-page">Previous</button>
        <button id="next-page">Next</button>
    </div>

    <script>
        function initializeFlipbook(pdfPath, containerSelector) {
            console.log("Loading PDF for Flipbook:", pdfPath);

            const flipbook = document.querySelector(containerSelector);
            if (!flipbook) {
                console.error("Flipbook container not found!");
                return;
            }

            flipbook.innerHTML = ""; // Reset kontainer
            pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js";

            const loadingTask = pdfjsLib.getDocument(pdfPath);
            loadingTask.promise
                .then(function (pdf) {
                    console.log("PDF loaded");
                    let pagesRendered = 0;

                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        pdf.getPage(pageNum).then(function (page) {
                            const viewport = page.getViewport({ scale: 2 });
                            const canvas = document.createElement("canvas");
                            const context = canvas.getContext("2d");

                            canvas.width = viewport.width;
                            canvas.height = viewport.height;

                            const renderContext = { canvasContext: context, viewport: viewport };
                            page.render(renderContext).promise.then(function () {
                                console.log(`Page ${pageNum} rendered`);

                                // Bungkus halaman
                                const pageWrapper = document.createElement("div");
                                pageWrapper.classList.add("page");
                                pageWrapper.style.width = `${viewport.width}px`;
                                pageWrapper.style.height = `${viewport.height}px`;
                                pageWrapper.appendChild(canvas);

                                flipbook.appendChild(pageWrapper);
                                pagesRendered++;

                                // Inisialisasi Turn.js setelah semua halaman selesai dirender
                                if (pagesRendered === pdf.numPages) {
                                    adjustFlipbookSize(viewport.width, viewport.height);
                                    $(flipbook).turn({
                                        width: viewport.width * 2,
                                        height: viewport.height,
                                        autoCenter: true,
                                        duration: 1000,
                                    });
                                    console.log("Turn.js initialized.");
                                }
                            });
                        });
                    }
                })
                .catch(function (error) {
                    console.error("Error loading PDF:", error);
                });
        }

        function adjustFlipbookSize(pageWidth, pageHeight) {
            const flipbookContainer = document.getElementById("flipbook-container");
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight * 0.9; // Adjust for navigation height

            // Calculate scale to fit two pages within the window
            const scale = Math.min(windowWidth / (pageWidth * 2), windowHeight / pageHeight);

            const adjustedWidth = Math.floor(pageWidth * 2 * scale);
            const adjustedHeight = Math.floor(pageHeight * scale);

            const flipbook = document.getElementById("flipbook");
            flipbook.style.width = `${adjustedWidth}px`;
            flipbook.style.height = `${adjustedHeight}px`;
        }

        const pdfPath = "<?= $pdfPath ?>";
        initializeFlipbook(pdfPath, "#flipbook");

        // Navigasi Halaman
        $("#prev-page").click(function () {
            $("#flipbook").turn("previous");
        });

        $("#next-page").click(function () {
            $("#flipbook").turn("next");
        });

        // Adjust size on window resize
        window.addEventListener("resize", () => {
            const flipbook = $("#flipbook");
            if (flipbook.data("page") > 0) {
                const pageWidth = flipbook.turn("size").width / 2;
                const pageHeight = flipbook.turn("size").height;
                adjustFlipbookSize(pageWidth, pageHeight);
            }
        });
    </script>
</body>
</html>
