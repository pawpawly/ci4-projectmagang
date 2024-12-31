
<footer class="bg-gray-900 text-white py-8">
    <div class="container mx-auto px-6">
        <div class="flex flex-wrap justify-between">
            <!-- Left Side: Visit Us -->
            <div class="w-full md:w-1/3 mb-6">
                <h3 class="text-white text-lg font-semibold mb-4">Kunjungi Kami</h3>
                <p>
                    Jl. Teluk Kelayan, Kelayan Barat,<br>
                    Kecamatan Banjarmasin Selatan,<br>
                    Kota Banjarmasin, Kalimantan Selatan 70234<br>
                    WhatsApp: 08xx-xxxx-xxxx
                </p>
            </div>

            <!-- Middle Side: Google Maps -->
            <div class="w-full md:w-1/3 mb-6 md:mr-8">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3523.7726485377193!2d114.59101189367716!3d-3.327717827123221!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de423b46ad04651%3A0x924ae960199efd12!2sMuseum%20Kota%20Banjarmasin!5e0!3m2!1sid!2sid!4v1728971659722!5m2!1sid!2sid"
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

            <!-- Right Side: Social Media -->
            <div class="w-full md:w-1/4 mb-6 md:ml-auto text-right"> 
    <h3 class="text-white text-lg font-semibold mb-4">Social Media</h3>
    <div class="flex justify-end space-x-4">
        <!-- Instagram Icon -->
        <a href="https://www.instagram.com" target="_blank" style="display: inline-block;">
            <div id="lottie-facebook" class="lottie-icon" style="width: 40px; height: 40px;"></div>
        </a>
        <!-- Facebook Icon -->
        <a href="https://www.facebook.com" target="_blank" style="display: inline-block;">
            <div id="lottie-instagram" class="lottie-icon" style="width: 40px; height: 40px;"></div>
        </a>
        <!-- TikTok Icon -->
        <a href="https://www.tiktok.com" target="_blank" style="display: inline-block;">
            <div id="lottie-tiktok" class="lottie-icon" style="width: 40px; height: 40px;"></div>
        </a>
        <!-- YouTube Icon -->
        <a href="https://www.youtube.com" target="_blank" style="display: inline-block;">
            <div id="lottie-youtube" class="lottie-icon" style="width: 40px; height: 40px;"></div>
        </a>
    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>

<script>
    // Load Lottie Animation for YouTube
    const youtubeAnim = lottie.loadAnimation({
        container: document.getElementById('lottie-youtube'),
        renderer: 'svg',
        loop: false, // Disable looping
        autoplay: false, // Don't autoplay on load
        path: '<?php echo base_url("js/icons8-youtube.json"); ?>' // Replace with your Lottie JSON file path
    });

    // Add hover event listeners
    const youtubeIcon = document.getElementById('lottie-youtube');
    
    youtubeIcon.addEventListener('mouseenter', () => {
        youtubeAnim.goToAndPlay(0, true); // Play animation from the beginning
    });

    youtubeIcon.addEventListener('mouseleave', () => {
        youtubeAnim.stop(); // Stop animation when the cursor leaves
    });
</script>

<script>
    // Load Lottie Animation for YouTube
    const instagramAnim = lottie.loadAnimation({
        container: document.getElementById('lottie-instagram'),
        renderer: 'svg',
        loop: false, // Disable looping
        autoplay: false, // Don't autoplay on load
        path: '<?php echo base_url("js/icons8-instagram.json"); ?>' // Replace with your Lottie JSON file path
    });

    // Add hover event listeners
    const instagramIcon = document.getElementById('lottie-instagram');
    
    instagramIcon.addEventListener('mouseenter', () => {
        instagramAnim.goToAndPlay(0, true); // Play animation from the beginning
    });

    instagramIcon.addEventListener('mouseleave', () => {
        instagramAnim.stop(); // Stop animation when the cursor leaves
    });
</script>

<script>
    // Load Lottie Animation for YouTube
    const tiktokAnim = lottie.loadAnimation({
        container: document.getElementById('lottie-tiktok'),
        renderer: 'svg',
        loop: false, // Disable looping
        autoplay: false, // Don't autoplay on load
        path: '<?php echo base_url("js/icons8-tiktok.json"); ?>' // Replace with your Lottie JSON file path
    });

    // Add hover event listeners
    const tiktokIcon = document.getElementById('lottie-tiktok');
    
    tiktokIcon.addEventListener('mouseenter', () => {
        tiktokAnim.goToAndPlay(0, true); // Play animation from the beginning
    });

    tiktokIcon.addEventListener('mouseleave', () => {
        tiktokAnim.stop(); // Stop animation when the cursor leaves
    });
</script>

<script>
    // Load Lottie Animation for YouTube
    const facebookAnim = lottie.loadAnimation({
        container: document.getElementById('lottie-facebook'),
        renderer: 'svg',
        loop: false, // Disable looping
        autoplay: false, // Don't autoplay on load
        path: '<?php echo base_url("js/icons8-facebook.json"); ?>' // Replace with your Lottie JSON file path
    });

    // Add hover event listeners
    const facebookIcon = document.getElementById('lottie-facebook');
    
    facebookIcon.addEventListener('mouseenter', () => {
        facebookAnim.goToAndPlay(0, true); // Play animation from the beginning
    });

    facebookIcon.addEventListener('mouseleave', () => {
        facebookAnim.stop(); // Stop animation when the cursor leaves
    });
</script>

        <!-- Footer Bottom -->
        <div class="mt-8 text-center text-white border-t border-white pt-4">
            &copy; Museum Kayuh Baimbai 2024
        </div>
    </div>
</footer>
