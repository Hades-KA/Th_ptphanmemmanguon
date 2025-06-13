<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <form id="login-form">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                <div class="form-outline form-white mb-4">
                  <input type="text" name="username" id="username" class="form-control form-control-lg" required />
                  <label class="form-label" for="username">Username</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input type="password" name="password" id="password" class="form-control form-control-lg" required />
                  <label class="form-label" for="password">Password</label>
                </div>

                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#">Forgot password?</a></p>
                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>

                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                  <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f fa-lg"></i></a>
                  <a href="#" class="text-white mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                  <a href="#" class="text-white mx-2"><i class="fab fa-google fa-lg"></i></a>
                </div>
              </div>

              <div>
                <p class="mb-0">Don't have an account?
                  <a href="/2280618888_PhamTaManhLan_Bai2/account/register" class="text-white-50 fw-bold">Sign Up</a>
                </p>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.getElementById('login-form').addEventListener('submit', function (event) {
  event.preventDefault();

  const formData = new FormData(this);
  const jsonData = {};
  formData.forEach((value, key) => {
    jsonData[key] = value;
  });

  fetch('/2280618888_PhamTaManhLan_Bai2/account/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(jsonData)
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`Đăng nhập thất bại: ${response.status} - ${response.statusText}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('Response data:', data); // Debug dữ liệu trả về
    if (data.token) {
      localStorage.setItem('jwtToken', data.token);
      window.location.href = '/2280618888_PhamTaManhLan_Bai2/product';
    } else {
      alert(data.message || "Sai thông tin đăng nhập hoặc chưa cấu hình token");
    }
  })
  .catch(error => {
    console.error('Lỗi khi đăng nhập:', error);
    alert(error.message || "Lỗi không xác định khi đăng nhập. Vui lòng thử lại!");
  });
});
</script>