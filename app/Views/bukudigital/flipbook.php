<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>

    <!-- PDF.js dari CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        #pdf-container {
            width: 80%;
            height: 90%;
            overflow: auto;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            border-radius: 8px;
        }

        canvas {
            display: block;
            margin: 10px auto;
        }
    </style>
</head>

<body>
    <div id="pdf-container"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const pdfContainer = document.getElementById("pdf-container");
            const pdfFilePath = "<?= $pdf_file; ?>"; // Path ke file PDF

            if (!pdfFilePath) {
                alert("File PDF tidak ditemukan!");
                return;
            }

            // Inisialisasi PDF.js
            const loadingTask = pdfjsLib.getDocument(pdfFilePath);
            loadingTask.promise.then(function (pdf) {
                console.log(`PDF berhasil dimuat: ${pdf.numPages} halaman.`);

                // Render setiap halaman
                for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                    pdf.getPage(pageNumber).then(function (page) {
                        const viewport = page.getViewport({ scale: 1.5 });

                        // Buat elemen canvas untuk setiap halaman
                        const canvas = document.createElement("canvas");
                        const context = canvas.getContext("2d");

                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        pdfContainer.appendChild(canvas);

                        // Render halaman ke canvas
                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport,
                        };
                        page.render(renderContext).promise.then(function () {
                            console.log(`Halaman ${pageNumber} berhasil dirender.`);
                        });
                    });
                }
            }).catch(function (error) {
                console.error("Error saat memuat PDF:", error);
                alert("Gagal memuat file PDF.");
            });
        });
    </script>
</body>

</html>
