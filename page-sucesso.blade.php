@extends('site_v2/layouts/default-obra')

@section('content')

<article class="fd-cinza-claro padding80">
  <div class="container">
    <div class="page-sucesso">
    	<i class="fas fa-check-circle page-sucesso-icon"></i>
    	<h1>Sucesso</h1>
    	<h4 class="tx-cinza-claro">Obrigado por entrar em contacto connosco!<br>Em breve entraremos em contacto consigo.</h4>
    	<a href="{{ route('homePageV2') }}"><i class="fas fa-angle-double-left font16"> <span>Voltar ao site</span></i></a>
    </div>
  </div>
</article> 
@stop

@section('javascript')
<script>

</script>
@stop