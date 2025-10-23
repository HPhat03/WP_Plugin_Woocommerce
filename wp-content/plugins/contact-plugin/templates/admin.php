<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Test REST API</title>
</head>
<body>
  <h1>Test REST API</h1>

  <?php echo wp_create_nonce("wp_rest"); ?>
  <button id="btnCreatePost">Test</button>

  <pre id="result"></pre>

  <script>
    // Nonce này thường được in ra trong trang PHP hoặc gán trong wp_localize_script
    // Ví dụ bạn có thể in như:
    const WP_NONCE = '<?php echo wp_create_nonce("wp_rest"); ?>';

    document.getElementById('btnCreatePost').addEventListener('click', () => {
      fetch('/wordpress/wp-json/api/json/?post_type=product', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': WP_NONCE, // Gửi nonce để xác thực user
        },
        //  body: JSON.stringify({
        //   title: 'Bài viết mới từ JS',
        //   content: '<p>Nội dung bài viết được tạo từ REST API.</p>',
        //   status: 'publish'
        // }),
        credentials: 'same-origin' // Gửi cookie theo domain
      })
      .then(response => response.json())
      .then(data => {
        document.getElementById('result').textContent = JSON.stringify(data, null, 2);
      })
      .catch(error => {
        document.getElementById('result').textContent = 'Lỗi: ' + error.message;
      });
    });
  </script>
</body>
</html>
