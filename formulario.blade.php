@extends('site_v2/layouts/default-obra')

@section('content')

<article class="fd-cinza-claro padding80">
  <div class="container">
    
    <div class="form-tamanho">
      <h2 class="quest-titulo">Peça o seu Orçamento</h2>
      <label class="section5-conteudo">Poderão ser cobrados € 25 (iva incluído) para cobrir os custos de deslocação. Nestes casos, se a sua obra for adjudicada, o valor ser-lhe-á devolvido.</label>

      <form id="questionario" action="{{route('questionarioV2')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="hidden" id="id_form" name="id_form" value="">
        @foreach($formulario as $valor) 
          {!! $valor['pergunta'] !!}
          {!! $valor['resposta'] !!}
        @endforeach

        <div class="clearfix height-20"></div>
        <div>
          <label class="quest-legenda"><span class="tx-verde">*</span> Campos Obrigatórios</label>
          <div class="margin-top10"><input type="checkbox" name="termos" id="termos">
            <label for="termos"><span></span></label>Concordo com a utilização dos meus dados apenas para o formulário.
          </div>
          <button id="botoes" class="bt-verde-quest bt-verde float-right" type="submit">SUBMETER</button>
        </div>
        <div id="loading" class="loading"><i class="fas fa-sync fa-spin"></i> A submeter...</div>
        <div class="clearfix"></div>
        <div class="height-20"></div>
        <label id="labelSucesso" class="av-100 av-verde display-none"><span id="spanSucesso">Submetido com sucesso!</span> <i class="fas fa-times" onclick="$(this).parent().hide();"></i></label>
        <label id="labelErros" class="av-100 av-vermelho display-none"><span id="spanErro">Existem campos obrigatórios por preencher.</span> <i class="fas fa-times" onclick="$(this).parent().hide();"></i></label>

      </form>
    </div>
  </div>
</article> 
@stop

@section('javascript')
<script>
  $("#termos").on('change', function() {
    if ($(this).is(':checked')) { $(this).attr('value', '1'); } 
    else { $(this).attr('value', '0'); }
  });

  function lerFicheiros(input,id) {
    var quantidade = input.files.length;
    var nome = input.value;
    if(quantidade==1){$('#'+id).html(nome);}
    else{$('#'+id).html(quantidade+' {{ trans('profile.selectedFiles') }}');}
  }
</script>
<script>
$('#questionario').on('submit',function(e) {

  $("#labelSucesso").hide();
  $("#labelErros").hide();
  $('#loading').show();
  $('#botoes').hide();
  var form = $(this);
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: form.attr('action'),
    data: new FormData(this),
    contentType: false,
    processData: false,
    cache: false,
    headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  })
  .done(function(resposta){

   console.log(resposta);
   //return;
    try{ resp=$.parseJSON(resposta); }
    catch (e){

      if(resposta){ $("#spanErro").html(resposta); }
      else{ $("#spanErro").html('ERROR'); }
      $("#labelErros").show();
      $('#loading').hide();
      $('#botoes').show();
      return;
    }

    if(resp.estado=='sucesso'){
      $("#id").val(resp.id);
      $("#nome").val(resp.nome);
      $("#labelSucesso").show();
      $(".a-dotted-white").empty();
      document.getElementById("questionario").reset();
      window.location="{{ route('sucessoPageV2') }}";

    }
    else if(resp.estado=='erro'){
      $("#spanErro").html(resp.mensagem);
      $("#labelErros").show();
      $("#id_form").val(resp.id_form);
    }
    else if(resposta){
      $("#spanErro").html(resposta);
      $("#labelErros").show();
    }

    $('#loading').hide();
    $('#botoes').show();  
  });
});
</script>
@stop