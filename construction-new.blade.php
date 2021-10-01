@extends('backoffice_v2/layouts/default')

@section('content')

  @if(isset($obras->id)) <?php $arrayCrumbs = [ trans('backoffice_v2.Construction') => route('constructionPageBV2') , trans('backoffice_v2.Editar_obra') => route('constructionEditPageBV2', ['id'=>$obras->id])]; ?>
  @else <?php $arrayCrumbs = [ trans('backoffice_v2.Construction') => route('constructionPageBV2'), trans('backoffice_v2.Adicionar_obra') => route('constructionNewPageBV2')]; ?>
  @endif
  @include('backoffice_v2/includes/crumbs')

  <div class="page-titulo">
    @if(isset($obras->id)) {{ trans('backoffice_v2.Editar_obra') }} 
    @else {{ trans('backoffice_v2.Adicionar_obra') }} 
    @endif
  </div>

  <form id="editConteudo" action="{{route('saveConstructionPageBV2')}}" name="form" method="post" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <input type="hidden" name="id_obra" id="id" value="@if(isset($obras->id)){{ $obras->id }}@endif">
    
    <div class="row">
      <div class="col-lg-6">
        <label class="lb">{{ trans('backoffice_v2.Name') }}</label>
        <input class="lb-solid" name="nome" value="@if(isset($obras->nome)){{ $obras->nome }}@endif">
      </div>
      <div class="col-lg-6">
        <label class="lb">{{ trans('backoffice_v2.Adress') }}</label>
        <input class="lb-solid" name="morada" value="@if(isset($obras->morada)){{ $obras->morada }}@endif">
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <label class="lb">{{ trans('backoffice_v2.Cor_letra_cabecalho') }}</label><br>
        <div class="margin-top10">
            <input type="radio" id="radio_branco" name="cor" value="branco" @if(isset($obras->cor) && ($obras->cor == 'branco')) checked="true" @endif>
            <label for="radio_branco"><span></span>Branco</label>&nbsp;
            <input type="radio" id="radio_cinza" name="cor" value="cinza" @if(isset($obras->cor) && ($obras->cor == 'cinza')) checked="true" @endif>
            <label for="radio_cinza"><span></span>Cinza</label>      
        </div>
      </div>
      <div class="col-lg-6">
        <label class="lb">{{ trans('backoffice_v2.Proprietario') }}</label>
        <input class="lb-solid" name="dono" value="@if(isset($obras->dono)){{ $obras->dono }}@endif">
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <label class="lb">{{ trans('backoffice_v2.Categoria') }}</label>
        <input class="lb-solid" name="classificacao" value="@if(isset($obras->classificacao)){{ $obras->classificacao }}@endif">
      </div>
      <div class="col-lg-3">
        <label class="lb">{{ trans('backoffice_v2.Area') }} ( m&sup2; )</label>
        <input class="lb-solid" name="area" value="@if(isset($obras->area)){{ $obras->area }}@endif">
      </div>
      <div class="col-lg-3">
        <label class="lb">{{ trans('backoffice_v2.Deadline') }}</label>
        <input class="lb-solid" name="prazo" value="@if(isset($obras->prazo)){{ $obras->prazo }}@endif">
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3">
        <label class="lb">{{ trans('backoffice_v2.piso_abaixo') }}</label>
        <input class="lb-solid" name="piso_abaixo" value="@if(isset($obras->pisoAbaixo)){{ $obras->pisoAbaixo }}@endif">
      </div>
      <div class="col-lg-3">
        <label class="lb">{{ trans('backoffice_v2.piso_acima') }}</label>
        <input class="lb-solid" name="piso_acima" value="@if(isset($obras->pisoAcima)){{ $obras->pisoAcima }}@endif">
      </div>

      <div class="col-lg-3">
        <label class="lb">{{ trans('backoffice_v2.Value') }} ( € )</label>
        <input class="lb-solid" name="valor" value="@if(isset($obras->valor) && ($obras->valor != 0.00)){{ $obras->valor }}@endif">
      </div>
      <div class="col-lg-3">
        <label class="lb">{{ trans('backoffice_v2.Visivel') }}</label>
        <div class="margin-top10"><input id="checkbox_visivel" type="checkbox" name="visivel" value="1" @if(isset($obras->visivel) && $obras->visivel) checked="true" @endif><label for="checkbox_visivel"><span></span>Vísivel</label></div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <label class="lb">{{ trans('backoffice_v2.Status') }}</label>
          <div class="margin-top10">
            <input class="margin-right5" type="radio" id="estado_concluida" name="estado" value="concluida" @if(isset($obras->estado) &&  ($obras->estado== 'concluida')) checked @endif>
            <label for="estado_concluida"><span></span>Concluída</label>&nbsp;
            
            <input class="margin-right5" type="radio" id="estado_encontrucao" name="estado" value="construcao" @if(isset($obras->estado) &&  ($obras->estado== 'construcao')) checked @endif>
            <label for="estado_encontrucao"><span></span>Em Construção</label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <label class="lb">{{ trans('backoffice_v2.Services') }}</label><br>
        <!--{ { var_dump($array['servicos']) }}-->
        @if(isset($obras->id))
          @foreach($servicos as $val)
            <label class="margin-top10">
              <input id="value_service{{ $val['id'] }}" type="hidden" name="valor" value="{{ $val['valor'] }}">
              <input id="check3{{ $val['id'] }}" type="checkbox" name="servico[]" onchange="guardarServicos({{ $obras->id }},{{ $val['id'] }});" @if($val['valor'] == 1)checked="true"@endif>
              <label for="check3{{ $val['id'] }}"><span></span></label>{{ $val['nome'] }}&ensp;
            </label>
          @endforeach
        @else
          @foreach($servicos as $val)
            <label class="margin-top10">
              <input id="check3{{ $val->id }}" type="checkbox" name="servico[]" value="{{ $val->id }}">
              <label for="check3{{ $val->id }}"><span></span></label>{{ $val->nome }}&ensp;
            </label> 
          @endforeach
        @endif 
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <label class="lb">{{ trans('backoffice_v2.Descricao') }}</label>
        <textarea class="tx" name="descricao">@if(isset($obras->descricao)){{ $obras->descricao }}@endif</textarea>
      </div>
    </div> 

    <div class="row">
      <div class="col-lg-12">
        <label class="lb">{{ trans('backoffice_v2.Fotografia') }}</label>
        <div class="div-50">
          <div class="div-50" id="imagem">
            <label class="a-dotted-white" id="uploads">&nbsp;</label>
          </div>
          <label for="selecao-arquivo" class="lb-40 bt-azul float-right"><i class="fa fa-upload" aria-hidden="true"></i></label>
          <input id="selecao-arquivo" type="file" name="resposta[]" onchange="lerFicheiros(this,'uploads');" accept="image/*" multiple="true">
        </div>
        <label class="lb-40 bt-azul float-right" onclick="limparFicheiros();"><i class="fa fa-trash" aria-hidden="true"></i></label>

        @if(isset($obras->id))
          <div class="margin-top30">

            <div class="modulo-table">
              <div class="modulo-scroll pointer">
                <table class="modulo-body" id="sortable">
                  <thead>
                    <tr>
                      <th class="display-none"></th>
                      <th>#</th>
                      <th>{{ trans('backoffice_v2.Imagem') }}</th>
                      <th>{{ trans('backoffice_v2.Capa') }}</th>
                      <th>{{ trans('backoffice_v2.Fundo_frente') }}</th>
                      <th>{{ trans('backoffice_v2.Fundo_tras') }}</th>
                      <th>{{ trans('backoffice_v2.Option') }}</th>
                    </tr>
                  </thead>
                <tbody>
                 
                  @foreach($imagens as $valor)
                  <tr id="linha_{!! $valor->id !!}">
                    <td class="display-none"></td>
                    <td>{!!($valor->id)!!}</td><input type="hidden" name="id_img" value="{!! $valor->id !!}">
                    <td><img class="width-50 height-50" src="{!! $valor->img !!}"></td><input type="hidden" name="imagem" value="{!! $valor->img !!}">
                    <td class="check-border">
                      <input type="radio" name="capa" id="check{{ $valor->id }}" value="1" onchange="editarConteudos({{ $valor->id_obra }},{{ $valor->id }},'capa');" @if($valor->capa) checked @endif>
                      <label for="check{{ $valor->id }}"><span></span></label>
                    </td>
                    <td class="check-border">
                      <input type="radio" name="fundoFrente" id="check4{{ $valor->id }}" value="1" onchange="editarConteudos({{ $valor->id_obra }},{{ $valor->id }},'fundoFrente');" @if($valor->fundoFrente) checked @endif>
                      <label for="check4{{ $valor->id }}"><span></span></label>
                    </td>
                    <td class="check-border">
                      <input type="radio" name="fundoTras" id="check5{{ $valor->id }}" value="1" onchange="editarConteudos({{ $valor->id_obra }},{{ $valor->id }},'fundoTras');" @if($valor->fundoTras) checked @endif>
                      <label for="check5{{ $valor->id }}"><span></span></label>
                    </td>

                    <td class="table-opcao">
                      <span class="table-opcao" onclick="$('#id_modal').val({{ $valor->id }});" data-toggle="modal" data-target="#myModalDelete">
                        <i class="far fa-trash-alt"></i>&nbsp;{{trans('backoffice_v2.Delete')}}
                      </span>
                    </td>
                  </tr> 
                  @endforeach

                  @if(!isset($valor->id)) <tr><td colspan="6">{{ trans('backoffice_v2.noRecords') }}</td></tr> @endif
                
                </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div> 

    <div class="row">
      <div class="col-lg-12">
        <label class="lb">{{ trans('backoffice_v2.Observacoes_controlo_interno') }}</label>
        <textarea class="tx" name="obs">@if(isset($obras->obs)){{ $obras->obs }}@endif</textarea>
      </div>
    </div>

    <label class="lb">{{ trans('backoffice_v2.Online') }}</label>
    <div class="margin-top10"><input id="checkbox_online" type="checkbox" name="online" value="1" @if(isset($obras->online) && $obras->online) checked="true" @endif><label for="checkbox_online"><span></span>Online</label></div>
 
    <div class="clearfix height-20"></div>
    <div id="botoes">
      <button class="bt bt-verde float-right" type="submit"><i class="fas fa-check"></i> {{ trans('backoffice_v2.Save') }}</button>
      <label class="width-10 height-40 float-right"></label>
      <a href="{{ route('constructionPageBV2') }}" class="abt bt-vermelho float-right"><i class="fas fa-times"></i> {{ trans('backoffice_v2.Cancel') }}</a>
    </div>
    <div id="loading" class="loading"><i class="fas fa-sync fa-spin"></i> {{ trans('backoffice_v2.SavingR') }}</div>
    <div class="clearfix"></div>
    <div class="height-20"></div>
    <label id="labelSucesso" class="av-100 av-verde display-none"><span id="spanSucesso">{{ trans('backoffice_v2.savedSuccessfully') }}</span> <i class="fas fa-times" onclick="$(this).parent().hide();"></i></label>
    <label id="labelErros" class="av-100 av-vermelho display-none"><span id="spanErro"></span> <i class="fas fa-times" onclick="$(this).parent().hide();"></i></label>
  </form>

  <!-- Modal Delete -->
  <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <input type="hidden" name="id_modal" id="id_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">{{ trans('backoffice_v2.DeleteImagem') }}</h4></div>
        <div class="modal-body">{!! trans('backoffice_v2.DeleteInformationImagem') !!}</div>
        <div class="modal-footer">
          <button type="button" class="bt bt-vermelho" data-dismiss="modal"><i class="fas fa-times"></i> {{ trans('backoffice_v2.Cancel') }}</button>&nbsp;
          <button type="button" class="bt bt-verde" data-dismiss="modal" onclick="apagarLinha();"><i class="fas fa-check"></i> {{ trans('backoffice_v2.Delete') }}</button>
          <div class="height-20"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Alert -->
  <div class="alert">
    <span class="closebtn" onclick="this.hide();">&times;</span> 
    <b>{{ trans('backoffice_v2.Sucesso') }}</b> {{ trans('backoffice_v2.changeSuccessfully') }}!
  </div>
@stop

@section('css')

@stop

@section('javascript')
<!-- ORDENAR -->
<script src="{{ asset('backoffice_v2/vendor/sortable/jquery-ui.min.js') }}"></script>

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
<script>
  function editarConteudos(id_obra,id_img,campo){

    $.ajax({
      type: "POST",
      url: '{{ route('updateContentsImg') }}',
      data: { id_obra:id_obra, id_img:id_img, campo:campo },
      headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' }
    })
    .done(function(resposta) {

      console.log(resposta);
      if(resposta=='sucesso'){
        //alert('Guardado com sucesso!');
      }
    });
  }

  function guardarServicos(id_obra,id_serv){

    valor = $('#value_service'+id_serv).val();

    $.ajax({
      type: "POST",
      url: '{{ route('saveService') }}',
      data: { id_obra:id_obra, id_serv:id_serv, valor},
      headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' }
    })
    .done(function(resposta) {

    
      if(resposta){
        $('#value_service'+id_serv).val(resposta);

        //alert('Guardado com sucesso!');
      }
    });
  }

  function limparFicheiros() {
    $('#selecao-arquivo').val('');
    $('#uploads').html('&nbsp;');
    $('#imagem').html('<label class="a-dotted-white" id="uploads">&nbsp;</label>');
  }

  $("#checkbox_visivel").on('change', function() {
    if ($(this).is(':checked')) { $(this).attr('value', '1'); } 
    else { $(this).attr('value', '0'); }
  });

  $("#checkbox_online").on('change', function() {
    if ($(this).is(':checked')) { $(this).attr('value', '1'); } 
    else { $(this).attr('value', '0'); }
  });


  function lerFicheiros(input,id) {
    var quantidade = input.files.length;
    var nome = input.value;
    if(quantidade==1){$('#'+id).html(nome);}
    else{$('#'+id).html(quantidade+' {{ trans('profile.selectedFiles') }}');}
  }

  function apagarLinha(){
    var id = $('#id_modal').val();

    $.ajax({
      type: "POST",
      url: '{{ route('deleteImagemPageBV2') }}',
      data: { tabela:'obras_img',id:id },
      headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' }
    })
    .done(function(resposta) {
      console.log(resposta);
      if(resposta=='sucesso'){
        $('#linha_'+id).slideUp();
        $('.alert').show();
        setTimeout(function(){
          $('.alert').hide();
        }, 3000);
      }
      //window.location.reload();
    });
  }

  // ORDENAR IMAGEM
  /*$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
      var order = $(this).sortable("serialize");
      $.ajax({
        type: "POST",
        url: '{ { route('orderTableTMBV2') }}',
        data: { tabela:'obras_img', order },
        headers:{ 'X-CSRF-Token':'{ !! csrf_token() !!}' }
      })      
      .done(function(resposta){
        console.log(resposta);
        if(resposta=='sucesso'){
          alert('Guardado com sucesso!');
        }
      });

    }
  }).disableSelection();*/

  // ORDENAR
  $("#sortable tbody").sortable({
      opacity: 0.6, cursor: 'move',
      update: function() {
      var order = $(this).sortable("serialize")+'&tabela=obras_img&campo=ordem';
      $.post("{{ route('orderTableTMBV2') }}", order);
      //$.notific8('Enviamos os dados para o seu email!', {heading: 'Aviso'});
      $('.alert').show();
        setTimeout(function(){
          $('.alert').hide();
        }, 6000);
      }
  }).disableSelection();
</script>
@stop




    
 


