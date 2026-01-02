<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prince Bank - Lucky Draw</title>
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{URL::to('newicon.ico')}}" />
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
            font-size: 21px;
            text-align: center;
            padding-top: 12px;
        }
        .col-md-4{
            font-family: Poppins-Bold;
            font-size: 28px;
            text-align: center;
            padding-top: 4px;
        }
        .lucky-draw-logo{
            max-width: 135%;
            height: auto;
            margin-top: -41px;
        }
        .ticket-number{
            max-width: 70%;
            height: auto;
        }
        .prince-eaccount{
            height: auto;
            max-width: 94%;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            padding-top: 47px;
        }
        .prize-winner{
            height: auto;
            max-width: 130%;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            margin: auto;
        }
        .winner-name{
            height: 40px;
            margin-top: 30px;
        }
        .all-winner-name{
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body style="background: rgba(46,52,148,255);">
    <canvas id="confetti" width="1" height="1" style="display: none;"></canvas>
    <header style="background: url({{URL::to('src/image/grand_prize/prince_background.png')}});margin: 0;padding-bottom: 0px;" class="jumbotron bg-cover text-white">
        <div class="row" style="margin-top: -3%;">
            <div class="col-md-12">
                <div class="col-md-3" style="padding-left: 0px; padding-top: 15px;">
                    <img src="{{URL::to('src/image/grand_prize/lucky_draw_logo.png')}}" class="lucky-draw-logo">
                </div>
                <div class="col-md-6">
                    <div class="col-sm-12 text-center" style="padding:30px 0 0px 0; height: auto;">
                        <img src="{{URL::to('src/image/grand_prize/ticket_number.png')}}" style="height: 66px;">
                    </div>
                    <div class="col-sm-12 text-center" style="font-family: Poppins-Bold; padding: 0px 0px 0px 0px;">
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="one" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="two" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="three" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="four" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="five" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="six" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="seven" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="eight" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div class="slotwrapper" style="height: 84px;">
                            <ul id="nine" style="font-size: 76px;line-height: 84px;width: 50px; color: #d1aa67;">
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
                        <div>
                            <input type="hidden" name="ac_no" id="ac_no">
                            <input type="hidden" name="ac_desc" id="ac_desc">
                            <input type="hidden" name="phone_number" id="phone_number">
                            <input type="hidden" name="txt-1" id="txt-1">
                            <input type="hidden" name="txt-2" id="txt-2">
                            <input type="hidden" name="txt-3" id="txt-3">
                            <input type="hidden" name="txt-4" id="txt-4">
                            <input type="hidden" name="txt-5" id="txt-5">
                            <input type="hidden" name="txt-6" id="txt-6">
                            <input type="hidden" name="txt-7" id="txt-7">
                            <input type="hidden" name="txt-8" id="txt-8">
                            <input type="hidden" name="txt-9" id="txt-9">
                            <input type="hidden" name="prize" id="prize" value="Iphone">
                        </div>
                    </div>
                    <div class="col-sm-12 text-center" style="padding: 25px 25px 0px 25px;">
                        <button type="button" class="btn-start" style="font-family: Poppins-ExtraBold;font-weight: bold;color: white;font-size: 35px; background: linear-gradient(90deg, rgba(29,193,152,1) 0%, rgba(107,251,206,1) 100%);height: 50px;width: 279px;border: none;border-radius: 25px" id="btn-example10-start">Start</button>
                        <button type="button" style="display: none;" class="btn-stop" id="btn-example10-stop" disabled>Stop</button>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <img src="{{URL::to('src/image/grand_prize/prince_eaccount.png')}}" class="prince-eaccount">
                </div>
            </div>
            <div class="col-md-12">
            <div class=" col-md-4 text-center">
                <div class="col-md-12">
                    <img src="{{URL::to('src/image/grand_prize/winner_name.png')}}" class="winner-name">
                </div>
                <div class="col-md-12" style="padding-bottom: 7%;">
                    <div style="background: none;border-radius: 25px;border: solid 3px white;height: 50px;">
                        <span style="font-family: Poppins-Bold; font-weight: bold;color: white;font-size: 26px;" id="spn_winnername"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-6">
                <img src="{{URL::to('src/image/grand_prize/prize.png')}}" style="max-width: 100%;max-height: 100%;" id="prize_image">
            </div>
        </div>
        </div>
        
       
    </header>
    <div class="col-md-12 text-center" style="padding-left: 0px;padding-right: 0px;">
        <div class="col-md-12" style="background: white; border-radius: 0px 0px 0px 53px;">
            <div class="col-md-12 py-5 text-center" style="padding: 30px">
                <div class="row">
                    <div class="col-md-12" style="background: rgb(255,180,36); background: linear-gradient(220deg, rgba(20,104,255,255) 0%, rgba(21,185,255,255) 100%); height: 235px;border-radius: 25px;">
                        <div class="col-md-12 text-center" style="height: 60px;">
                            <img src="{{URL::to('src/image/grand_prize/grand_prize_winner.png')}}" class="all-winner-name">
                        </div> 
                        <div  class="col-md-12 ">
                            <div class="col-sm-4" style="background: white;height: auto;min-height: 50px; word-break: break-word;top: 15px;border-radius: 20px; width: 30%;margin-right: 5%;">
                                <span id="3_win_name_1" style="color:#007bff"></span>
                            </div>
                            <div class="col-sm-4" style="background: white;height: auto;min-height: 50px; word-break: break-word;top: 15px;border-radius: 20px; width: 30%;margin-right: 5%;">
                                <span id="3_win_name_2" style="color:#007bff"></span>
                            </div>
                            <div class="col-sm-4" style="background: white;height: auto;min-height: 50px; word-break: break-word;top: 15px;border-radius: 20px; width: 30%;">
                                <span id="3_win_name_3" style="color:#007bff"></span>
                            </div>
                        </div>   
                        <div class="col-md-12 ">
                            <div class="col-md-4" style="background: none; border:solid 3px #06e1ff; height: 50px;border-radius: 20px; top: 25px; width: 30%;margin-right: 5%;">
                                <span id="3_win_cif_1" style="color:white"></span>
                            </div>
                            <div class="col-md-4" style="background: none; border:solid 3px #06e1ff; height: 50px;border-radius: 20px; top: 25px; width: 30%;margin-right: 5%;">
                                <span id="3_win_cif_2" style="color:white"></span>
                            </div>
                            <div class="col-md-4" style="background: none; border:solid 3px #06e1ff; height: 50px;border-radius: 20px; top: 25px; width: 30%;">
                                <span id="3_win_cif_3" style="color:white"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <img src="{{URL::to('src/image/grand_prize/prince_logo.png')}}" style="height: auto;margin-top: 0px;max-width: 25%;" id="prize_image">
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

    @include('spins/spinscript_grand_prize')
</body>
</html>
