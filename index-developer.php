<DOCTYPE html>
<html lang="en" dir="ltr" oncopy="return false;" oncontextmenu="return myRightClick();" oncut="return false;" onpaste="return false;">
  <head>
    <meta charset="UTF-8">
    <title> Developer | PacacPortal </title>
    <link rel="stylesheet" href="css/style-developer.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <ul class="nav nav-pills">
    <li class="active"><a href="https://pacacportal.com/" data-toggle="tab">Go Back</a>
    </li>
  <div class="container">
    <input type="radio" name="dot" id="one">
    <input type="radio" name="dot" id="two">
    <div class="main-card">
      <div class="cards">
        <div class="card">
         <div class="content">
           <div class="img">
            <img src="developer-pic/Reno.jpg" alt="">
           </div>
           <div class="details">
             <div class="name">Reno F. Catigday</div>
             <div class="job">Developer</div>
           </div>
           <div class="media-icons">
             <a href="https://www.facebook.com/reno.catigday"><i class="fab fa-facebook-f"></i></a>
             <a href="https://www.instagram.com/_itsnoi_/"><i class="fab fa-instagram"></i></a>
             <a href="https://github.com/GojoSatoru-26"><i class="fab fa-github"></i></a>
           </div>
         </div>
        </div>
        
        <div class="card">
         <div class="content">
           <div class="img">
            <img src="developer-pic/Glenn.jpg" alt="">
           </div>
           <div class="details">
             <div class="name">Eliezer Glenn G. Castelo</div>
             <div class="job">Developer</div>
           </div>
           <div class="media-icons">
             <a href="https://www.facebook.com/profile.php?id=100026828993378"><i class="fab fa-facebook-f"></i></a>
             <a href="https://www.instagram.com/ohiozergel/"><i class="fab fa-instagram"></i></a>
             <a href="https://github.com/Eliezer222222"><i class="fab fa-github"></i></a>
           </div>
         </div>
        </div>
      </div>
      <div class="cards">
        <div class="card">
         <div class="content">
           <div class="img">
             <img src="developer-pic/Susie.jpg" alt="">
           </div>
           <div class="details">
             <div class="name">Susie P. Orzame</div>
             <div class="job">Developer</div>
           </div>
           <div class="media-icons">
             <a href="https://www.facebook.com/profile.php?id=100073529025527"><i class="fab fa-facebook-f"></i></a>
             <a href="https://www.instagram.com/its_suujiiohara/"><i class="fab fa-instagram"></i></a>
             <a href="https://github.com/Suujii29"><i class="fab fa-github"></i></a>
           </div>
         </div>
        </div>
        <div class="card">
         <div class="content">
           <div class="img">
             <img src="developer-pic/Revilyn.jpg" alt="">
           </div>
           <div class="details">
             <div class="name">Revilyn Mae B. Antonio</div>
             <div class="job">Developer</div>
           </div>
           <div class="media-icons">
             <a href="https://www.facebook.com/revilyn.antonio"><i class="fab fa-facebook-f"></i></a>
             <a href="https://www.instagram.com/rvlynm"><i class="fab fa-instagram"></i></a>
             <a href="https://github.com/Belindugh"><i class="fab fa-github"></i></a>
           </div>
         </div>
        </div>
        <div class="card">
         <div class="content">
           <div class="img">
             <img src="developer-pic/Edrey.jpg" alt="">
           </div>
           <div class="details">
             <div class="name">Edrey Kyle A. Dingle</div>
             <div class="job">Developer</div>
           </div>
           <div class="media-icons">
             <a href="https://www.facebook.com/Edrey.Kylee"><i class="fab fa-facebook-f"></i></a>
             <a href="https://www.instagram.com/ufound_edri/"><i class="fab fa-instagram"></i></a>
             <a href="https://github.com/EdreyKd"><i class="fab fa-github"></i></a>
           </div>
         </div>
        </div>
      </div>
    </div>
    <div class="button">
      <label for="one" class=" active one"></label>
      <label for="two" class="two"></label>
    </div>
  </div>
  </script>
 <script type="text/javascript">
    function myRightClick() {
      alert("Function Disabled.");
      return false;
    }

    document.onkeydown = function(e) {
      if(event.keyCode == 123) {
        return false;
      }
      if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        alert("Function Disabled.");
        return false;
      }
      if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        alert("Function Disabled.");
        return false;
      }
      if(e.ctrlKey && e.keyCode == 'C'.charCodeAt(0)) {
        alert("Function Disabled.");
        return false;
      }
       if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        alert("Function Disabled.");
        return false;
      }
    }
  </script>
</body>
</html>