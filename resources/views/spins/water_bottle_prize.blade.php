<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prince Bank - Lucky Draw</title>
    <!-- Favicon icon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{URL::to('newicon.ico')}}" /> --}}
    <!-- Common Plugins -->
    <link href="{{URL::to('src/assets/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom Css-->

    <link rel="stylesheet" href="{{URL::to('src/slot/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::to('src/fa/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::to('src/css/app.css')}}">
    <link href="{{URL::to('src/fa/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{URL::to('src/fa/css/brands.css')}}" rel="stylesheet">
    <link href="{{URL::to('src/fa/css/solid.css')}}" rel="stylesheet">
    <style type="text/css">
        @font-face {
            font-family: KhmerOSDangrek;
            src: url("{{URL::to('src/assets/fonts/KhmerOSDangrek.ttf')}}");
        }
        @font-face {
            font-family: 'Noto Sans Khmer';
            src: url("{{URL::to('src/assets/fonts/KhmerOSDangrek.ttf')}}");
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family:'Bayon-Regular';
            src: url("{{URL::to('src/image/new_luckyDraw/fonts/Khmer/KantumruyPro-SemiBoldItalic.ttf')}}");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: Poppins-ExtraBold;
            src: url("{{URL::to('src/assets/fonts/Poppins-ExtraBold.otf')}}");
        }

        @font-face {
            font-family: Poppins-Bold;
            src: url("{{URL::to('src/assets/fonts/Poppins-Bold.otf')}}");
        }

        @font-face {
            font-family: Poppins-Medium;
            src: url("{{URL::to('src/assets/fonts/Poppins-Medium.otf')}}");
        }

        #confetti {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
        }

        .bg-cover {
            background-size: cover !important;
        }

        .col-sm-2,
        .col-sm-4 {
            font-family: Poppins-Bold;
            font-size: 19px;
            text-align: center;
            padding-top: 12px;
        }
        .lucky-draw-logo{
            max-width: 110%;
            height: auto;
        }
        .ticket-number{
            max-width: 40%;
            height: auto;
        }
        .prince-eaccount{
            height: auto;
            max-width: 50%;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 160px;
            padding-top: 47px;
        }
        .prize-winner{
            height: auto;
            max-width: 60%;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            margin: auto;
            padding-top: 10%;
        }
        .winner-name{
            height: auto;
            max-width: 100%;
        }
        .start-btn {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 35px;
            font-weight: bold;
            color: #fff;
            background: radial-gradient(circle at center, #7b1fa2 0%, #9c27b0 70%, #ba68c8 100%);
            box-shadow:
                0 0 25px 10px rgba(156, 39, 176, 0.6),
                inset 0 0 10px rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .start-btn:hover {
            transform: scale(1.08);
            box-shadow:
                0 0 40px 15px rgba(156, 39, 176, 0.9),
                inset 0 0 12px rgba(12, 8, 8, 0.4);
        }

        .start-btn:active {
            transform: scale(0.95);
            box-shadow:
                0 0 20px 6px rgba(156, 39, 176, 0.8),
                inset 0 0 8px rgba(255, 255, 255, 0.2);
        }
        .gradient-text {
            background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }
        .spacer{
            width:100%;
            border:1px solid rgb(255 255 255 / 60%);
            margin-top:15px;
            box-sizing: border-box;
        }
    </style>
</head>
<body style="background: url({{URL::to('src/image/new_luckyDraw/Background/Lucky-Draw-BG.png')}});">
    {{-- <canvas id="confetti" width="1" height="1" style="display: none;"></canvas> --}}
    <header style="padding:0;margin: 0;" class="jumbotron bg-cover text-white">
        <div class="col-md-3" style="padding-left: 0px; padding-top: 15px;">
            <img src="{{URL::to('src/image/new_luckyDraw/Logo/Lucky-Draw-2025-logo.png')}}" class="lucky-draw-logo">
        </div>
        <div class="col-md-6">
            <div class="col-sm-12 text-center" style="padding:30px 0 0px 0; height: auto;">
                <img src="{{URL::to('src/image/new_luckyDraw/Characters/number_ticket.png')}}" class="ticket-number">
            </div>
            <div class="col-sm-12 text-center" style="font-family: Poppins-Bold; padding: 18px 0px 0px 0px;">

                @foreach($drawNumClass as $data)
                    <div class="slotwrapper" style="color:#ffffff; height: 84px;background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);">
                        <ul id="{{$data}}" style="font-size: 65px;line-height: 84px;width: 45px;">
                            <li>0</li>
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                            <li>4</li>
                            <li>5</li>
                            <li>6</li>
                            <li>7</li>
                            <li>8</li>
                            <li>9</li>
                        </ul>
                    </div>
                @endforeach
                <div>
                    <input type="hidden" name="ac_no" id="ac_no">
                    <input type="hidden" name="ac_desc" id="ac_desc">
                    <input type="hidden" name="phone_number" id="phone_number">
                    <input type="hidden" name="txt-1" id="txt-1">
                    <input type="hidden" name="txt-2" id="txt-2">
                    <input type="hidden" name="txt-3" id="txt-3">
                    <input type="hidden" name="txt-4" id="txt-4">
                    <input type="hidden" name="txt-5" id="txt-5">
                    <input type="hidden" name="prize" id="prize" value="Iphone">
                </div>
            </div>
            <div class="col-sm-12 text-center" style="padding: 25px">
                <button type="button" class="btn-start start-btn"  id="btn-example10-start">Start</button>
                <button type="button" style="display: none;" class="btn-stop" id="btn-example10-stop" disabled>Stop</button>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <img src="{{URL::to('src/image/new_luckyDraw/Logo/Prince_logo_landscape.png')}}" class="prince-eaccount">
        </div>
        <div class="col-md-12">
            <div class=" col-md-3 text-center">
                <div class="col-md-12">
                    <img src="{{URL::to('src/image/new_luckyDraw/Characters/name_customer.png')}}" class="winner-name">

                </div>
                <div class="col-md-12" style="padding-bottom: 7%;">
                    <div style="background: none;border-radius: 25px;border: solid 3px #ffffff;height: 50px;background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);">
                        <span style="font-family: Poppins-Bold; font-weight: bold;color: white;font-size: 30px;" id="spn_winnername"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <img src="{{URL::to('src/image/new_luckyDraw/Prize/Tumbler.png')}}" class="prize-winner" id="prize_image">
            </div>
        </div>
    </header>
    <div class="col-md-12 text-center" style=" padding-left: 0px;padding-right: 0px;">
        <div class="col-md-12">
            <div class="col-md-12 py-5 text-center" style="padding: 30px">
                <div class="row">
                    <div class="col-md-12 d-flex flex-column justify-content-center" style="background: linear-gradient(220deg, rgb(255 255 255 / 28%) 0%, rgb(255 255 255 / 28%) 100%); height: 400px;border-radius: 25px;">
                        
                        <!-- Names Row -->
                        <div class="row justify-content-center">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style="height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff;font-size: 20px;font-family: Bayon-Regular;"><i>ឈ្នោះអាជីវកម្ម</i></span>
                            </div>
                            <div class="col-sm-2  text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_1" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_2" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_3" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2  text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_4" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_5" style="color:#ffffff"></span>
                            </div>
                        </div>
                        
                        <!-- ticket Row -->
                        <div class="row justify-content-center" style="margin-top: 5px;">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style=" height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff; font-size: 12px;font-family: Bayon-Regular;"><i>លេខប័ណ្ណចាប់រង្វាន់</i></span>
                            </div>
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_1" class="gradient-text"> </span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_2" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_3" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_4" class="gradient-text"> </span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_5" class="gradient-text"></span>
                            </div>
                        </div>

                         <!-- Phone Row-->
                         <div class="row justify-content-center" style="margin-top: 5px;">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style=" height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff; font-size: 12px;font-family: Bayon-Regular;"><i>លេខទូរសព្ទ</i></span>
                            </div>
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_1" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_2" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_3" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_4" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_5" class="gradient-text"></span>
                            </div>
                        </div>

                         <!-- Account Row-->
                         <div class="row justify-content-center" style="margin-top: 5px;">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style=" height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff;font-size: 12px; font-family: Bayon-Regular;"><i>លេខគណនី</i></span>
                            </div>
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_1" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_2" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_3" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_4" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_5" class="gradient-text"></span>
                            </div>
                        </div>
                        <div class="spacer"></div>
                        <!-- Names Row -->
                        <div class="row justify-content-center" style="margin-top: 15px;">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style="height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff;font-size: 20px;font-family: Bayon-Regular;"><i>ឈ្នោះអាជីវកម្ម</i></span>
                            </div>
                            <div class="col-sm-2  text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_6" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_7" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_8" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2  text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_9" style="color:#ffffff"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: linear-gradient(220deg, #9d52fe 0%, #6220fb 100%);height: 30px;min-height: 45px; word-break: break-word; border-radius: 50px; padding: 10px;">
                                <span id="3_win_name_10" style="color:#ffffff"></span>
                            </div>
                        </div>
                        
                        <!-- ticket Row -->
                        <div class="row justify-content-center" style="margin-top: 5px;">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style=" height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff; font-size: 12px;font-family: Bayon-Regular;"><i>លេខប័ណ្ណចាប់រង្វាន់</i></span>
                            </div>
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_6" class="gradient-text"> </span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_7" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_8" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_9" class="gradient-text"> </span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="tickets_10" class="gradient-text"></span>
                            </div>
                        </div>
                        <!-- Phone Row-->
                        <div class="row justify-content-center" style="margin-top: 5px;">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style=" height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff; font-size: 12px;font-family: Bayon-Regular;"><i>លេខទូរសព្ទ</i></span>
                            </div>
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_6" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_7" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_8" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_9" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="phone_10" class="gradient-text"></span>
                            </div>
                        </div>

                         <!-- Account Row-->
                         <div class="row justify-content-center" style="margin-top: 5px;">
                            <div class="col-sm-1 text-center d-flex align-items-center justify-content-center" style=" height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="" style="color:#ffffff;font-size: 12px; font-family: Bayon-Regular;"><i>លេខគណនី</i></span>
                            </div>
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_6" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_7" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_8" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_9" class="gradient-text"></span>
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center" style="background: #ffffff; border:solid 3px #ffffff; height: 32px;border-radius: 50px; padding: 10px;">
                                <span id="3_win_cif_10" class="gradient-text"></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal info  -->
    <div id="limitCustomer" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="icon-box bg-success">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>				
                    <h4 class="modal-title w-100 ">User Limit!</h4>	
                </div>
                <div class="modal-body">
                    <p class="text-center">All winners are reach our limitation of 50.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-block " data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div> 

    <!-- Common Plugins -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{URL::to('src/assets/lib/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/pace/pace.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/nano-scroll/jquery.nanoscroller.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/metisMenu/metisMenu.min.js')}}"></script>
    <script src="{{URL::to('src/assets/js/custom.js')}}"></script>

    <script src="{{URL::to('src/slot/jquery.min.js')}}"></script>
    <script src="{{URL::to('src/slot/jquery.easing.min.js')}}"></script>
    <script src="{{URL::to('src/slot/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('src/js/slotmachine.min.js')}}"></script>

    @include('spins/script/spinscript_water_bottle_prize')
</body>
</html>
