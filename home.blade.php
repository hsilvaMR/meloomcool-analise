@extends('site_v2/layouts/default')


@section('content')
<!--CAPA -->
<article class="fd-branco">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div id="capa-titulo">
                   <?php $count = 0; ?>
                    @foreach ($conteudos['slideTitulo'] as $value)
                        <?php $count++; ?>
                        <div class="slideshow-container"><div class="mySlides fade"><h3 id="section1text{{ $count }}">{!! nl2br($value) !!}</h3></div></div>
                    @endforeach
                    <a class="abt bt-verde capa-button" href="{{ route('formV2') }}">{{ $conteudos['pedirOrcamento'] }}</a>
                </div>
            </div>
        
            <div class="col-sm-6">
                <div class="capa-imgs">
                    <div class="capa-melao" id="melao"></div>
                    <div class="capa-girl"></div>
                </div>
            </div>
        </div>
    </div>
</article>

<!--NOTICIAS -->
<article class="fd-verde noticias">
    <div class="noticia-section">
        <div class="slide">
            <div class="swiper-container swiper-noticia">
                <div class="swiper-wrapper">
                    @foreach ($noticias as $elem)
                      <div class="swiper-slide">
                            <div class="noticia-slide">
                                <div class="noticia-data">
                                    @if($elem['data_publicacao'])
                                        <p>{!! $elem['data_publicacao'] !!}</p>
                                    @endif
                                    <br><br>
                                </div>
                                <h2 class="{!! $elem['sizeTitulo'] !!}">{!! $elem['titulo'] !!}</h2>
                                <p class="{!! $elem['sizeCorpo'] !!}">{!! $elem['texto'] !!}</p>
                            </div>
                      </div>
                    @endforeach 
                </div>
            </div>
            <div class="swiper-bt-next"><i class="seta fas fa-angle-right"></i></div>
            <div class="swiper-bt-prev"><i class="seta fas fa-angle-left"></i></div>
        </div>
    </div>
</article>

<!--SERVICOS-->
<article class="fd-branco">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center servico-conteudo">
                    @foreach ($servico as $cont)
                        <div class="servico-iconeHome">
                            <div class="servico-icones servico-padding"><img class="servico-img" src="{!! $cont->iconsv2 !!}"></img></div>
                            <div class="tx-preto margin-bottom10">{!! $cont->nome !!}</div> 
                        </div> 
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</article>

<!--IMAGEM DUAS PESSOAS-->
<div class="img-pessoas"></div>

<!--O QUE FAZEMOS-->
<section class="fd-branco">
    <div class="container">
        <h1 class="section5-titulo">{!! nl2br($conteudos['casaDeSonho']) !!}</h1>
        <div class="row">
            <div class="col-sm-5 col-md-6">
                <h2 class="section5-subtitulo">{!! nl2br($conteudos['oQueFazemos']) !!}</h2>
                <p class="section5-conteudo">{!! nl2br($conteudos['textOqueFazemos']) !!}</p>
           
                <div><img src="img/site_v2/parceiros-01.png" id="img-parceiros"></div>
            </div>
            <div class="col-sm-7 col-md-6">
                <div class=" section5-antesdepoisdiv">
                    <div class="section5-antesdepois"><p class="section5-texto">{{ $conteudos['remodelacoes'] }}</p></div>
                    <img src="img/site_v2/antes-depois.png">
                </div>  
                <div class="section5-botao">
                    <a class="abt bt-verde" href="{{ route('formV2') }}">
                    {{ $conteudos['pedirOrcamento'] }}</a>
                </div> 
            </div>
        </div>
    </div>
</section>


<!--SECTION O QUE OBRAS RELEVANTES -->

<article class="fd-branco obra-fd">
    <div class="sectionSlide">
        <div class="slide">
            <div class="swiper-container obra-galeria">
                <div class="obra-titulo"><h2>{{ nl2br($conteudos['textoListaObras']) }}</h2></div>
                <div class="swiper-wrapper">
                    @foreach ($obras as $elem)
                        <div class="swiper-slide">
                            <div class="obra-img-container">
                   
                                <!--<div class="obra-project">
                                    <a href="{ { route('obraPageV2',$elem['id']) }}" target="_blank">
                                       <div class="obra-project-img" style="background-image:url('{ !! $elem['img'] !!}');">
                                           <i class="fas fa-search"></i>
                                       </div>
                                        
                                    </a>
                                </div>-->

                                <div class="obra-project">
                                    <a href="{{ route('obraPageV2',$elem['id']) }}" target="_blank">
                                        @foreach($elem['img'] as $el)
                                       <div class="obra-project-img" style="background-image:url('{!! $el->img !!}');">
                                           <i class="fas fa-search"></i>
                                       </div>
                                        @endforeach
                                    </a>
                                </div>
                           
                                <div class="obra-icons">
                                    @foreach($elem['servicos'] as $el)
                                        <div class="obra-servico"><img class="obra-img-servico" src="{{ asset($el->icon) }}" title="{{ $el->nome }}"></div>
                                    @endforeach
                                </div>
                            </div> 
                        </div>
                    @endforeach 
                </div>
            </div>
            <div class="swiper-btn-next"><i class=" fas fa-angle-right"></i></div>
            <div class="swiper-btn-prev"><i class=" fas fa-angle-left"></i></div>
        </div>
    </div>
</article>


<!--SECTION CASA DE SONHO MELOM-->

<article class="casadesonho-fd">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 casadesonho-area-verde">
            
                <h2>{{ nl2br($conteudos['casaMelom']) }}</h2>
                <p class="casadesonho-texto">{!! nl2br($conteudos['textoCasaMelom']) !!}</p>

                @if($conteudos['pdfCatalogo'] && file_exists(base_path()."/public_html/".$conteudos['pdfCatalogo']))
                    <div class="casadesonho-botao">
                        <a href="{{ $conteudos['pdfCatalogo'] }}" download="catálogo.pdf" class="abt bt-verde">{!! $conteudos['buttonCatalogo'] !!}</a>
                    </div>
                @endif
            </div>
        </div>   
    </div>
    <div class="casadesonho-fd casadesonho-height"></div>
</article>

<!--IMAGEM BENITO-->

<article class="fd-branco benito-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-push-7">
                <div class="benito-conteudo">
                    <h2>{!! nl2br($conteudos['tituloCOOL']) !!}</h2>
                    <p class="tx-cinza benito-texto">{!! nl2br($conteudos['textoParceiro']) !!}</p> 
                    <div class="benito-marcas">
                        <img class="benito-marca-img margin-right10" src="/img/site_v2/2016.png">
                        <img class="benito-marca-img margin-right10" src="/img/site_v2/2017.png">
                        <a href="http://reabilitacao.aiccopn.pt" target="_blank"><img class="benito-ruis-img" src="/img/site_v2/ruis-logo.svg"></a> 
                    </div> 
                </div>
            </div>
            <div class="col-md-7 col-md-pull-5">
                <div class="benito-img"><div class="benito-position"><img src="/img/site_v2/sergio-videira.png"></div></div>
            </div>
        </div>
    </div>
</article>


<!--PORQUE ESCOLHER A MELOM-->

<article class="fd-verde-escuro">
    <div class="container">
        <div class="row">
            <div class="col-md-4"><ul class="melom-topico">@foreach ($conteudos['topicoCool1'] as $value)<li>{!! nl2br($value) !!}</li>@endforeach</ul></div>
            <div class="col-md-4"><ul class="melom-topico">@foreach ($conteudos['topicoCool2'] as $value)<li>{!! nl2br($value) !!}</li>@endforeach</ul></div>
            <div class="col-md-4"><ul class="melom-topico">@foreach ($conteudos['topicoCool3'] as $value)<li>{!! nl2br($value) !!}</li>@endforeach</ul></div>
        </div>
        <div class="text-center margin-top20">
            <a class="abt bt-verde" href="{{ route('formV2') }}">
            {!! nl2br($conteudos['pedirOrcamento']) !!}</a>
        </div>
    </div>
</article>


<!--QUER SABER QUANTO PODEM CUSTAR AS SUAS OBRAS?-->

<article class="fd-formulario fd-cinza-claro">
    <div class="container">
        <h2 class="form-titulo">{!! nl2br($conteudos['tituloInfoCusto']) !!}</h2>
        <div class="row form-tamanho">
            <form id="sendContactoV2" action="{{ route('sendContactoV2') }}" name="form" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="col-md-6 margin-top20">
                    <p>Nome <span class="tx-verde">*</span></p>
                    <input class="form-control form-input" type="text" name="nome" id="c_nome"> 
                </div>
                <div class="col-md-6 margin-top20">
                    <p>Email <span class="tx-verde">*</span></p>
                    <input class="form-control form-input" type="email" name="email" id="c_email">
                </div>
                <div class="col-md-12 margin-top20">
                    <p>Mensagem <span class="tx-verde">*</span></p>
                    <textarea rows="8" cols="4" class="form-control form-textarea" name="mensagem" id="c_mensagem"></textarea>
                </div>
                <div class="col-md-12 form-campos-obg">

                    <div class="margin-top10 float-right"><span><span class="tx-verde">*</span> campos obrigatórios</span></div>
                    <div class="clear height-10"></div>
                    <div class="margin-top20 check-right"><input type="checkbox" name="termos" id="termos">
                        <label for="termos">Concordo com a utilização dos meus dados apenas para o contacto. <span></span></label>
                    </div>
                </div>
                <div class="col-md-12 form-campos-obg">
                    <div class="float-right">
                        <p id="formGreen"></p>
                        <p id="formRed"></p>
                    </div>
                    <div class="clear height-10"></div>
                    <button class="btn btn-link form-submit" type="submit"></button>
                </div>
            </form>          
        </div>
    </div>
</article>    


<article class="map">
    <div class="map-area-verde">
        <img class="map-icon" src="img/site_v2/pin.svg">
        <p class="map-morada">{!! nl2br($conteudos['morada']) !!}<br>
            <a href="mailto:{!! $conteudos['email'] !!}"><b>{!! nl2br($conteudos['email']) !!}</b></a>
        </p>
        <div class="map-phone-label"><a>{!! nl2br($conteudos['contacto']) !!}</a></div>
    	<!--<br>EM PARCERIA COM<br>
        <a href="http://www.ci-interiordecor.com" target="_blank"><img class="map-img-CI" src="/img/site_v2/ci-logo.svg"></a>-->
    </div>
    <div class="map-container"><div id="mapa"></div></div>
</article>

<!--CALL ME-->
<div id="call-bt-open" class="call-bt-open" onclick="open_call();"></div>
<div id="call-container" class="call-container">
    <form id="ligueFormV2" action="{{route('ligueFormV2')}}" name="form" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div id="call-me">
            <div class="call-me-top">
                <h4 class="margin-bottom10">{!! nl2br($conteudos['entreEmContacto']) !!}</h4>
                <p class="call-me-text">{!! nl2br($conteudos['especialista']) !!}</p>
                <div class="call-me-img"><img class="call-me-operator" src="/img/site_v2/img-operator.png"></div>  
            </div>
            <div class="call-me-bottom">
                <div id="form-nome" class="form-group col-lg-12 text-left">
                    <p class="form-conteudo">Nome</p>
                    <input type="text" name="nome" id="nome" class="col-lg-12 form-control input-melom">
                </div>
                <div id="form-conct" class="form-group col-lg-12 text-left">
                    <p class="form-conteudo">Telefone</p>
                    <input type="text" name="telefone" id="telefone" class="col-lg-12 form-control input-melom">
                </div>
                <p id="form-avisoGreen"></p>
                <p id="form-avisoRed"></p>
                
                <div class="text-right col-lg-12">
                    <div id="form-botaoLigar"><button class="fd-branco" type="submit">Liguem-me GRÁTIS!</button></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </form>       
    <div id="call-bt-close" class="call-bt-close" onclick="close_call();"></div>
</div>
@stop

@section('css')
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.6/css/swiper.css">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.6/css/swiper.min.css">
@stop

@section('javascript')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.6/js/swiper.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.6/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-noticia', { 
        loop:true,
        keyboard: { enabled: true, },
        direction: 'horizontal',
        navigation: {
            nextEl: '.swiper-bt-next',
            prevEl: '.swiper-bt-prev',
        },
    });

    var swiper = new Swiper('.obra-galeria', {
        slidesPerView:3,
        spaceBetween: 20,
        loop:true,
        keyboard: { enabled: true, },
        direction: 'horizontal',       
        pagination: {
            el: '.swiper-pagination',
        },
        navigation: {
            nextEl: '.swiper-btn-next',
            prevEl: '.swiper-btn-prev',
        },
        breakpoints: {
            576: {
              slidesPerView: 1,
              spaceBetween: 20,
            },
            800: {
              slidesPerView: 2,
              spaceBetween: 20,
            }
        }
    });
</script>

<script>
var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");

    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    slides[slideIndex-1].style.display = "block";  
    setTimeout(showSlides, 5000); 
}
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeP3zRZhKETZZO8MaVk-DX-1s2We9WMCI&callback=initMap"></script>
<script>
    $("#termos").on('change', function() {
        if ($(this).is(':checked')) { $(this).attr('value', '1'); } 
        else { $(this).attr('value', '0'); }
    });

    function initMap() {
    var myLatLng  = {lat: 41.175920, lng: -8.647040}; 
    var map = new google.maps.Map(document.getElementById('mapa'), {
      center: myLatLng ,
      zoom: 16,
      styles: [{"featureType": "landscape","stylers": [{"hue": "#FFA800"},{"saturation": 0},{"lightness": 0},{"gamma": 1}]},{"featureType": "road.highway","stylers": [{"hue": "#53FF00"},{"saturation": -73},{"lightness": 40},{"gamma": 1}]},{"featureType": "road.arterial","stylers": [{"hue": "#FBFF00"},{"saturation": 0},{"lightness": 0},{"gamma": 1}]},{"featureType": "road.local","stylers": [{"hue": "#00FFFD"},{"saturation": 0},{"lightness": 30},{"gamma": 1}]},{"featureType": "water","stylers": [{"hue": "#00BFFF"},{"saturation": 6},{"lightness": 8},{"gamma": 1}]},{"featureType": "poi","stylers": [{"hue": "#679714"},{"saturation": 33.4},{"lightness": -25.4},{"gamma": 1}]}]});
    
        var marker = new google.maps.Marker({
          position: myLatLng ,
          map: map,
          title: 'Melom Cool',
          icon: "/img/site_v2/pin_green.svg"
        });
    }
</script>
@stop