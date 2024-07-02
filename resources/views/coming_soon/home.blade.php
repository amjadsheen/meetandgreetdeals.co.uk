<!doctype html>
<html lang=en>

<head>
    <meta charset=UTF-8 />
    <meta name=description content="Free coming soon template">
    <meta name=author content="Pawel Zuchowski">
    <meta name=viewport content="width=device-width,initial-scale=1" />
    <meta http-equiv=X-UA-Compatible content="ie=edge" />
    <link rel=stylesheet href=https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css
        integrity=sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO crossorigin=anonymous>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel=stylesheet>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@300;700&display=swap" rel=stylesheet>
    <link rel=stylesheet href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    <script src=https://kit.fontawesome.com/3c09bcb51a.js></script>
    <title>Comming Soon</title>
    <style>
		body,
body * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box; }

body,
.container,
.row {
  margin: 0;
  padding: 0;
  width: 100vw; }

p:not(.slogan),
.left,
.icon,
.icon-list,
h1,
.right,
.mainInfo {
  width: auto; }

.container .row .left-wrap {
  padding-right: 0;
  padding-left: 0;
  -webkit-filter: drop-shadow(15px 0px 10px rgba(50, 50, 0, 0.5));
  filter: drop-shadow(15px 0px 10px rgba(50, 50, 0, 0.5)); }
  .container .row .left-wrap .left {
    background-image: url(../img/247.jpg);
    background-repeat: no-repeat;
    background-position: 50% 100%;
    height: 100vh;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-clip-path: polygon(0 0, 100% 0%, 75% 100%, 0% 100%);
    clip-path: polygon(0 0, 100% 0%, 75% 100%, 0% 100%); }
    @media screen and (max-width: 576px) {
      .container .row .left-wrap .left {
        -webkit-clip-path: polygon(0 0, 100% 0, 100% 95%, 0% 100%);
        clip-path: polygon(0 0, 100% 0, 100% 95%, 0% 100%);
        height: 50vh;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-flow: column wrap;
        flex-flow: column wrap; } }
    .container .row .left-wrap .left p {
      font-family: "Muli", sans-serif;
      font-size: 3.5em;
      margin-right: 2em;
      font-weight: bold;
      color: white; }
      @media screen and (max-width: 576px) {
        .container .row .left-wrap .left p {
          font-size: 2em;
          margin: 0.5em 0 0.5em 0;
          -ms-flex-preferred-size: 10%;
          flex-basis: 10%; } }
      @media screen and (min-width: 576px) and (max-width: 768px) {
        .container .row .left-wrap .left p {
          font-size: 2.4em; } }
      .container .row .left-wrap .left p .small {
        vertical-align: text-top;
        font-size: 0.5em; }

.container .right {
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start; }
  @media screen and (max-width: 576px) {
    .container .right {
      height: 50vh;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center; } }
  .container .right .mainInfo {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1; }
    @media screen and (max-width: 576px) {
      .container .right .mainInfo {
        text-align: center; } }
    .container .right .mainInfo h1 {
      font-size: 2em;
      margin-left: 1em; }
      @media screen and (max-width: 576px) {
        .container .right .mainInfo h1 {
          margin-left: 0; } }
    .container .right .mainInfo .slogan {
      width: 50vw;
      margin-top: 1.5em;
      color: #6d6464; }
      @media screen and (max-width: 576px) {
        .container .right .mainInfo .slogan {
          width: auto; } }
    .container .right .mainInfo .form-subscribe {
      margin-top: 0.5em; }
      @media screen and (max-width: 576px) {
        .container .right .mainInfo .form-subscribe {
          margin-left: 0; } }
      .container .right .mainInfo .form-subscribe .form {
        height: 40px;
        padding: 0;
        margin-right: -6px;
        border: 1px solid black;
        border-right: none;
        padding-left: 0.5em; }
      .container .right .mainInfo .form-subscribe button {
        width: 120px;
        height: 40px;
        border: 1px solid black;
        border-top: 2px solid black;
        border-radius: 0 25px 25px 0;
        padding: 0;
        color: white;
        background-color: black; }
        @media screen and (max-width: 576px) {
          .container .right .mainInfo .form-subscribe button {
            width: 100px; } }
      .container .right .mainInfo .form-subscribe button:hover {
        cursor: pointer; }
  .container .right .icon-list {
    list-style: none;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-transform: translateY(-3em);
    transform: translateY(-3em); }
    @media screen and (max-width: 576px) {
      .container .right .icon-list {
        -webkit-transform: translateY(-0.1em);
        transform: translateY(-0.1em);
        padding-left: 0; } }
    .container .right .icon-list .icon {
      margin-right: 1em;
      font-size: 1.5em; }
      .container .right .icon-list .icon a {
        color: black;
        text-decoration: none; }

.right,
.mainInfo,
.left {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center; }

h1,
.slogan,
button,
.form {
  font-family: "Lato", sans-serif; }

.slogan,
.form-subscribe {
  margin-left: 2em; }
  @media screen and (max-width: 576px) {
    .slogan,
    .form-subscribe {
      margin-left: auto; } }

.twitter::before {
  font-family: "Font Awesome 5 Brands";
  content: "\f099"; }

.facebook::before {
  font-family: "Font Awesome 5 Brands";
  content: "\f16d"; }

.instagram::before {
  font-family: "Font Awesome 5 Brands";
  content: "\f09a"; }


	</style>
	<script>

		</script>
</head>

<body>
    <div class=container>
        <div class=row>
            <div class="left-wrap col-12 col-md-5">
                <div class=left>
                    
                </div>
            </div>
            <div class="col-12 col-md-7 right">
                <div class=mainInfo>
                    <h1>COMING SOON</h1>
                    <p class=slogan>Dev at work ):</p>
                    <form class=form-subscribe action=#> <input type=email class=form placeholder="Your eamil address"
                            required> <button type=submit>Subscribe</button> </form>
                </div>
               
            </div>
        </div>
    </div>
    
 
</body>

</html>