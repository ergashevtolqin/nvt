<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Blackjack</title>

    @include('admin.partials.css')
        
   <style>
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
    body{
        background-color:wheat  
    }
    .rate {
    display: inline-block;
    border: 0;
}
/* Hide radio */
.rate > input {
    display: none;
}
/* Order correctly by floating highest to the right */
.rate > label {
    float: right;
}
/* The star of the show */
.rate > label:before {
    display: inline-block;
    font-size: 2rem;
    padding: .3rem .2rem;
    margin: 0;
    cursor: pointer;
    font-family: FontAwesome;
    content: "\f005 "; /* full star */
}

/* Half star trick */
.rate .half:before {
    content: "\f089 "; /* half star no outline */
    position: absolute;
    padding-right: 0;
}
/* Click + hover color */
input:checked ~ label, /* color current and previous stars on checked */
label:hover, label:hover ~ label { color: #10a712;  } /* color previous stars on hover */

 
/* Hover highlights */
input:checked + label:hover, input:checked ~ label:hover, /* highlight current and previous stars */
input:checked ~ label:hover ~ label, /* highlight previous selected stars for new rating */
label:hover ~ input:checked ~ label /* highlight previous selected stars */ { color: #A6E72D;  } 
.colorrate{
    color:#A6E72D
}
   </style>
</head>
<body class="mini-sidebar">
    <div class="main-wrapper">
        <div class="content main-wrapper ">
            <div class="content container-fluid headbot" id="status200">
                <div class="row">
                    <div class="col-12 mt-5" style="text-align: center">
                        <h2>{{$user->last_name}} {{$user->first_name}}</h2>
                        <fieldset class="rate" name="" id="getyulduz">
                            <input type="radio" id="rating10" name="rating" value="10" /><label class="" for="rating10" title="5 ball" onclick="hideQues(5)"></label>
                            {{-- <input type="radio" id="rating9" name="rating" value="9" /><label class="half " for="rating9" title="4.5 ball" onclick=""></label> --}}
                            <input type="radio" id="rating8" name="rating" value="8" /><label class="" for="rating8" title="4 ball" onclick="hideQues(4)"></label>
                            {{-- <input type="radio" id="rating7" name="rating" value="7" /><label class="half " for="rating7" title="3.5 ball" onclick=""></label> --}}
                            <input type="radio" id="rating6" name="rating" value="6" /><label class="" for="rating6" title="3 ball" onclick="hideQues(3)"></label>
                            {{-- <input type="radio" id="rating/5" name="rating" value="5" /><label class="half " for="rating5" title="2.5 ball" onclick=""></label> --}}
                            <input type="radio" id="rating4" name="rating" value="4" /><label class="" for="rating4" title="2 ball" onclick="hideQues(2)"></label>
                            {{-- <input type="radio" id="rating3" name="rating" value="3" /><label class="half " for="rating3" title="1.5 ball" onclick=""></label> --}}
                            <input type="radio" id="rating2" name="rating" value="2" /><label class="" for="rating2" title="1 ball" onclick="hideQues(1)"></label>
                            {{-- <input type="radio" id="rating1" name="rating" value="1" /><label class="half " for="rating1" title="0.5 ball" onclick=""></label> --}}
                        </fieldset>
                        
                    </div>
                        {{-- <div class="container horizontal-scrollable"> --}}
                            {{-- <div class="row text-center" style="overflow-x: scroll;"> --}}
                                
                            {{-- </div> --}}
                        {{-- </div> --}}
                </div>
                <div>
                    @foreach ($questions as $item)
                                    <div class="row gr{{$item->grade}} allgr" style="display: none;">
                                <div class="col-6">

                                    <span class="ml-5">{{$item->qname}}</span>
                                </div>
                                <div class="col-6" style="text-align: center">

                                    <input type="checkbox" class="checkboxes" value="{{$item->qid}}">
                                </div>
                                    </div>
                                @endforeach
                </div>
                <div class="mt-5" style="text-align: center">
                    <button style="display:none" onclick="getCheck()" type="button" class="btn btn-outline-info" >Ovoz berish</button>
                </div>
            </div>
            <div class="content container-fluid headbot" id="status300" style="display: none;">
                <div class="row">
                    <div class="col-12 mt-5" style="text-align: center">
                        <h2>E'tiboringiz uchun rahmat!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

    @include('admin.partials.js')

    <script>
        function getCheck()
        {
            let a = [];
            $(".checkboxes:checked").each(function() {
                a.push(this.value)
            });
            var yulduz = <?php echo json_encode( $yulduz ) ?>;
            agent_array = <?php echo json_encode( $agent_array ) ?>;
            user = <?php echo json_encode( $user ) ?>;
            ygrade = $('#getyulduz').attr('name');

            var _token   = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
            url: "/grade/tashqi",
            type:"POST",
            data:{
                a:a,
                yulduz:yulduz,
                ygrade:ygrade,
                user:user,
                agent_array:agent_array[0],
               _token: _token
            },
            success:function(response){
                if(response.status == 200)
                {
                    $('#status200').css('display','none');
                    $('#status300').css('display','');
                }
            }
        });
        }
        function hideQues(id)
        {
            $('#getyulduz').attr('name',id);

            $('.allgr').css('display','none')
            $('button').css('display','')
            $( "input" ).prop( "checked", false );
            if( id ==2 || id == 1 || id == 3)
            {
             $('.gr1').css('display','');
             $('.gr2').css('display','');
             $('.gr3').css('display','');

            }
            if(id ==4 || id == 5)
            {
             $('.gr4').css('display','');
             $('.gr5').css('display','');

            }
        }
        // $.getJSON("https://api.ipify.org/?format=json", function(e) {
        //     console.log(e);
        // });
       
    </script>
</html>