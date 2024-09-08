<?php
session_start();
require '../../backend/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $password_hash = md5($password);

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header('Location: ../index.php'); // Redirect to a protected page
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!doctype html>
<html lang="en">

<!-- Mirrored from preview.colorlib.com/theme/bootstrap/login-form-19/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 08 Sep 2024 09:28:33 GMT -->
<head>
<title>Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="../../../../stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css">
<script nonce="a0708aac-2344-432b-b35a-9abede6b1ba1">try{(function(w,d){!function(j,k,l,m){if(j.zaraz)console.error("zaraz is loaded twice");else{j[l]=j[l]||{};j[l].executed=[];j.zaraz={deferred:[],listeners:[]};j.zaraz._v="5796";j.zaraz.q=[];j.zaraz._f=function(n){return async function(){var o=Array.prototype.slice.call(arguments);j.zaraz.q.push({m:n,a:o})}};for(const p of["track","set","debug"])j.zaraz[p]=j.zaraz._f(p);j.zaraz.init=()=>{var q=k.getElementsByTagName(m)[0],r=k.createElement(m),s=k.getElementsByTagName("title")[0];s&&(j[l].t=k.getElementsByTagName("title")[0].text);j[l].x=Math.random();j[l].w=j.screen.width;j[l].h=j.screen.height;j[l].j=j.innerHeight;j[l].e=j.innerWidth;j[l].l=j.location.href;j[l].r=k.referrer;j[l].k=j.screen.colorDepth;j[l].n=k.characterSet;j[l].o=(new Date).getTimezoneOffset();if(j.dataLayer)for(const w of Object.entries(Object.entries(dataLayer).reduce(((x,y)=>({...x[1],...y[1]})),{})))zaraz.set(w[0],w[1],{scope:"page"});j[l].q=[];for(;j.zaraz.q.length;){const z=j.zaraz.q.shift();j[l].q.push(z)}r.defer=!0;for(const A of[localStorage,sessionStorage])Object.keys(A||{}).filter((C=>C.startsWith("_zaraz_"))).forEach((B=>{try{j[l]["z_"+B.slice(7)]=JSON.parse(A.getItem(B))}catch{j[l]["z_"+B.slice(7)]=A.getItem(B)}}));r.referrerPolicy="origin";r.src="../../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(j[l])));q.parentNode.insertBefore(r,q)};["complete","interactive"].includes(k.readyState)?zaraz.init():j.addEventListener("DOMContentLoaded",zaraz.init)}}(w,d,"zarazData","script");window.zaraz._p=async bv=>new Promise((bw=>{if(bv){bv.e&&bv.e.forEach((bx=>{try{const by=d.querySelector("script[nonce]"),bz=by?.nonce||by?.getAttribute("nonce"),bA=d.createElement("script");bz&&(bA.nonce=bz);bA.innerHTML=bx;bA.onload=()=>{d.head.removeChild(bA)};d.head.appendChild(bA)}catch(bB){console.error(`Error executing script: ${bx}\n`,bB)}}));Promise.allSettled((bv.f||[]).map((bC=>fetch(bC[0],bC[1]))))}bw()}));zaraz._p({"e":["(function(w,d){})(window,document)"]});})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script></head>
<body>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-6 text-center mb-5">
</div>
</div>
<div class="row justify-content-center">
<div class="col-md-6 col-lg-4">
<div class="login-wrap py-5">
<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/admin.png);"></div>
<h3 class="text-center mb-0">Welcome</h3>
<p class="text-center">Sign in by entering the information below</p>
<form action="" class="login-form" method="post">
<div class="form-group">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
<input type="text" class="form-control" placeholder="Username" name="email" required>
</div>
<div class="form-group">
<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock"></span></div>
<input type="password" class="form-control" placeholder="Password"  name="password" required>
</div>
<div class="form-group d-md-flex">
<div class="w-100 text-md-right">
<a href="#">Forgot Password</a>
</div>
</div>
<div class="form-group">
<button type="submit" class="btn form-control btn-primary rounded submit px-3">Get Started</button>
</div>
</form>
<div class="w-100 text-center mt-4 text">
<p class="mb-0">Don't have an account?</p>
<a href="#">Sign Up</a>
</div>
</div>
</div>
</div>
</div>
</section>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8bfde8423f21f2f3","version":"2024.8.0","serverTiming":{"name":{"cfL4":true}},"token":"cd0b4b3a733644fc843ef0b185f98241","b":1}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from preview.colorlib.com/theme/bootstrap/login-form-19/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 08 Sep 2024 09:28:36 GMT -->
</html>
