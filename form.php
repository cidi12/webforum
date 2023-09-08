<?php
$conn = mysqli_connect("localhost", "root", "", "webb");
?>
<section class="login-regis-form" id="form-reg">
    <form action="" method="POST" id="form-validate" novalidate>
        <div class="latar-formulir" id="latar-formulir">
            <div class="formulir">
                <div class="login-header-bar">
                    <img src="forum-nav.png" alt="">
                </div>
                <div class="loginteks">
                    <p>Welcome</p>
                </div>
                <div class="isian">
                    <p>Email</p>
                    <input type="email" id="log-email" name="log_email" required>
                    <p>Password</p>
                    <input type="password" id="log-password" name="log_password" minlength="6" maxlength="6" required>
                </div>
                <div class="lupa">
                    <p><input type="checkbox" id="ingatsaya"><label for="ingatsaya">Remember me</label></p>

                    <a href="">Forgot password</a>
                </div>
                <div class="pencetanlogin">
                    <button type="submit" name="masuk"><img src="loginbtn.png" alt=""></button>

                </div>
                <div class="noakun">
                    <p>or</p>
                    <a>>> Register << </a>
                </div>
                <div class="clsbtn" id="clsbtn">
                    <button>x</button>
                </div>
            </div>
        </div>
    </form>
    <form action="" method="post" id="form-validate2" novalidate>
        <div class="formulir-regis">
            <div class="login-header-bar">
                <img src="forum-nav.png" alt="">
            </div>
            <div class="registeks">
                <p>Sign Up</p>
            </div>
            <div class="isian2">
                <p>Username</p>
                <input type="text" id="reg-username" name="regusername" minlength="4" maxlength="8" onkeydown="return /[a-zA-Z0-9]/i.test(event.key)" onpaste="return false" autocomplete="off" ondrop="return false" required>
                <p>Email</p>
                <input type="email" id="reg-email" name="regemail" required>
                <p>Password</p>
                <input type="password" id="reg-password" name="regpass" minlength="6" maxlength="6" onkeydown="return /[a-zA-Z0-9]/i.test(event.key)" onpaste="return false" autocomplete="off" ondrop="return false" required>
                <p>PIN</p>
                <input type="number" id="pin" maxlength="6" name="pin" onpaste="return false" autocomplete="off" ondrop="return false" required>
                <input type="hidden" value="member" name="kasta">
            </div>
            <div class="persetujuan">
                <input type="checkbox" id="setuju" required>
                <label for="setuju">Agree with Terms of Service</label>
                
            </div>
            <div class="pencetandaftar">
                <button type="submit" name="daftar"><img src="registerbtn.png" alt=""></button>
            </div>
            <div class="punya-akun">
                <a> >> Sign in << </a>
            </div>
            <div class="clsbtn2">
                <button>x</button>
            </div>
        </div>
    </form>
</section>