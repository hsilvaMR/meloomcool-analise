@extends('backoffice_v2/layouts/default')

@section('content')
  <?php $arrayCrumbs = [ trans('backoffice_v2.Orcamentos') => route('orcamentoPageBV2') , trans('backoffice_v2.EditOrcamento') => route('editOrcamentoPageBV2',['id'=>$formSub->id])]; ?>
  @include('backoffice_v2/includes/crumbs')

  <div class="page-titulo">
    {{ trans('backoffice_v2.EditOrcamento') }}
  </div>

  <form id="editConteudo" action="{{ route('editValorOrcamento') }}" name="form" method="post" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <input type="hidden" id="id" name="id_sub" value="{{ $formSub->id }}">

    <label class="lb">Nome</label>
    <input class="ip" name="nome" value="{{ $formSub->nome }}">
    
    @foreach($formSubInd as $val)
      <label class="lb">{{ $val->pergunta }}</label>

      @if($val->tipo=='input' || $val->tipo=='radiobutton' || $val->tipo=='select')
        @if(isset($val->resposta))<label class="lb-solid">{{ $val->resposta }}</label>@else<label class="lb-solid">&ensp;</label> @endif
      @elseif($val->tipo=='textarea')
        @if(isset($val->resposta))<label class="lb-solid">{!! nl2br($val->resposta) !!}</label>@else<label class="lb-solid">&ensp;</label> @endif
      @elseif($val->tipo=='checkbox')
        <div class="clearfix"></div>
        @php $array=json_decode($val->resposta); @endphp
        @if(isset($array)) @foreach($array as $value) <label class="lb-solid-width">{{ $value }}</label> @endforeach @else <label class="lb-solid">&ensp;</label> @endif
        <div class="clearfix"></div>
      @elseif($val->tipo=='file')
        <div>
          @if($val->resposta)
            <div class="div-50"><label class="lb-solid" name="nome">{{ ($val->resposta) }}</label></div>
            <a href="{{ ($val->resposta) }}" download="ficheiro" class="bt-40 bt-azul float-right">
              <i class="fas fa-download margin-top10" aria-hidden="true"></i>
            </a>
          @else
          <div class="div-50" ><label class="lb-solid"></label></div>
          <button class="bt-40 bt-cinza-claro float-right" type="button"><i class="fas fa-download" aria-hidden="true"></i></i></button>
          @endif
        </div>
      @else
        <input class="lb-solid" name="valor" value="{{ $val->resposta }}">
      @endif
    @endforeach

    <label class="lb">Data</label>
    <label class="lb-solid" name="data">{{ date('Y-m-d',$formSub->data) }}</label>

    <label class="lb">Valor</label>
    <input class="ip" name="valor" value="{{ $formSub->valor }}">

    <label class="lb">Observações</label>
    <textarea class="tx" name="obs">{!! nl2br($formSub->obs) !!}</textarea>

    <!--{ { var_dump($array['servicos']) }}-->
    <div class="clearfix height-20"></div>
    <div id="botoes">
      <button class="bt bt-verde float-right" type="submit"><i class="fas fa-check"></i> {{ trans('backoffice_v2.Save') }}</button>
      <label class="width-10 height-40 float-right"></label>
      <a href="{{ route('orcamentoPageBV2') }}" class="abt bt-vermelho float-right"><i class="fas fa-times"></i> {{ trans('backoffice_v2.Cancel') }}</a>
    </div>
    <div id="loading" class="loading"><i class="fas fa-sync fa-spin"></i> {{ trans('backoffice_v2.SavingR') }}</div>
    <div class="clearfix"></div>
    <div class="height-20"></div>
    <label id="labelSucesso" class="av-100 av-verde display-none"><span id="spanSucesso">{{ trans('backoffice_v2.savedSuccessfully') }}</span> <i class="fas fa-times" onclick="$(this).parent().hide();"></i></label>
    <label id="labelErros" class="av-100 av-vermelho display-none"><span id="spanErro"></span> <i class="fas fa-times" onclick="$(this).parent().hide();"></i></label>
  </form>
@stop

@section('javascript')
<script type="text/javascript">
  $('#editConteudo').on('submit',function(e) {
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
        cache: false
      })
      .done(function(resposta){
        //console.log(resposta);
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
          //$('#myModalSave').modal('show');
          $('#id').val(resp.id);
          $("#labelSucesso").show();
          $(".a-dotted-white").empty();
         
        }else if(resposta){
          $("#spanErro").html(resposta);
          $("#labelErros").show();
        }
        $('#loading').hide();
        $('#botoes').show();
      });
    });
</script>
@stop




    
 


