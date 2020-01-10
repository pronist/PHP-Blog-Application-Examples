        </div> <!-- #app -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit-icons.min.js"></script>
        <script src="https://cdn.ckeditor.com/4.13.1/standard-all/ckeditor.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script>
            if (document.getElementById('editor')) {
                CKEDITOR.replace('editor', {
                    height: 420,
                    extraPlugins: 'image2, uploadimage',
                    uploadUrl: '/board/upload.php'
                });
            }
        </script>
    </body>
</html>
