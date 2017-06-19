<html>

<head>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Halanx - OTP Verification</title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Material Design Bootstrap -->
        <link href="css/mdb.min.css" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            .view {
                height: 100%;
            }
            
            .view {
                /*background-image: linear-gradient(to right, #314755 0%, #26a0da 51%, #314755 100%)*/
                background: url(assets/pictures/lightbackground.jpg);
            }
            
            .btn-grad:hover {
                background-position: right center;
            }
            
             ::-webkit-input-placeholder {
                /* Chrome/Opera/Safari */
                color: #141f1f;
            }
            
            input {
                text-align: center;
            }
            
            .navbar-fixed-top {
                background-color: white;
            }
            
            .img-responsive {
                margin-top: -10px;
            }
            
            .navbar-right {
                color: #ff0000;
                font-family: "Sans", Verdana, "sans-serif";
                font-weight: bold;
            }
            
            .navbar-bg {
                color: #e50000;
                font-family: "Sans", Verdana, "sans-serif";
                font-weight: bold;
                font-size: 2.5em;
            }
            
            #logo {
                top: 16px;
            }
            
            #alertMessage {
                color: green;
            }

        </style>
    </head>


    <script type="text/javascript" src="jquery-2.2.0.min.js"></script>
    <script type="text/javascript">
        function sendOTP() {
            $("#sendOtp").attr("disabled", true);
            var data = {
                /* "countryCode": $('#country_code').val(),*/
                "mobileNumber": $('#number').val()
            };
            $.ajax({
                url: 'http://localhost/OTPVerification/sendotp.php?action=submitOTP',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response == 'OTP SENT SUCCESSFULLY') {
                        $('#hiddenCode').val($('#country_code').val());
                        $('#hiddenNumber').val($('#number').val());
                        $('#verifyOtpForm').show();
                        $('#sendOtpForm').hide();
                        $('#alertMessage').html(response + " PLEASE VERIFY.");

                        $("#sendOtp").attr("disabled", false);
                    }
                },
                error: function(jqXHR, textStatus, ex) {
                    console.log(textStatus + "," + ex + "," + jqXHR.responseText);
                }
            });
        }

        function verifyBySendOtp() {
            $("#sendOtp").attr("disabled", true);
            var data = {
                /* countryCode: $('#hiddenCode').val(),*/
                mobileNumber: $('#hiddenNumber').val(),
                oneTimePassword: $('#oneTimePassword').val()
            };
            $.ajax({
                url: 'http://localhost/OTPVerification/sendotp.php?action=verifyBySendOtp',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response == 'NUMBER VERIFIED SUCCESSFULLY') {
                        $('#verifyOtpForm').hide();
                        // $('#sendOtpForm').show();
                        $('#alertMessage').css({
                            'color': 'green'
                        });
                        $('#alertMessage').html(response);

                        $("#sendOtp").attr("disabled", true);
                    } else {
                        $('#alertMessage').css({
                            'color': 'red'
                        });
                        $('#alertMessage').html("OTP not Verified, try again.");
                    }
                },
                error: function(jqXHR, textStatus, ex) {
                    console.log(textStatus + "," + ex + "," + jqXHR.responseText);
                }
            });
        }

    </script>
</head>

<body class="view">
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- add header -->
            <div class="navbar-header">
                <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">-->
                <!--<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>-->
                <a class="navbar-brand" href="index.php"><img src="../OTPVerification/assets/pictures/logo.png" class="img-responsive img-circle" width="50" height="50" id="logo"> </a>
                <a class="navbar-brand navbar-bg" href="index.php">Halanx</a>
            </div>
            <!-- menu items -->
            <!--<div class="collapse navbar-collapse" id="navbar1">
    <ul class="nav navbar-nav navbar-right">
        <button class="btn btn-danger btn-md pull-right" onclick="window.location='login1.php'"> Login </button>

    </ul>
</div>-->
        </div>
    </nav>
    <pre>

   
    <div >
    <div class="flex-center flex-column flex-row z-depth-5 white"  style="margin: auto; max-width: 850px; height: auto; " >
        <br />
        <h1 class="animated fadeIn mb-4  z-depth-2 h1-responsive red-text" style="padding: 5px 15px; ">VERIFICATION FOR HALANX ACCOUNT</h1>
        <hr />
        <h6 class="animated h6-responsive fadeIn mb-1 ">Thank you for using Halanx. The verification is important for us, please cooperate.</h6>

        <div id="alertMessage" class="-text" ></div>

        <form id="sendOtpForm" role="form" >
         <input type="text" pattern="[789][0-9]{9}" name="number" placeholder="Enter 10-digit Mobile number" id="number" ><br />
         <center><input type="submit" class="btn btn-info  waves-effect -text" name="sendOtp" id="sendOtp" value="Request OTP" onclick="sendOTP()"> </center> 
       </form>

       <form id="verifyOtpForm" role="form"  style="display:none">
        <input type="hidden" name="hiddenCode" id="hiddenCode">
        <input type="hidden" name="hiddenNumber" id="hiddenNumber">
        <input type="text" pattern="[0-9]{4}" name="oneTimePassword" placeholder="Enter OTP" id="oneTimePassword"  class="-text"><br />
        <center><input type="button" class="btn btn-info waves-effect -text" name="verifyOtp" id="verifyOtp" value="Verify OTP" onclick="verifyBySendOtp()"></center>
      </form>
      <br />
      <p class="animated fadeIn white-text">Halanx Team</p> <br /><br />
    </div>
  </div>
  <!-- /Start your project here-->


</pre>

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/tether.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>

</body>

</html>
