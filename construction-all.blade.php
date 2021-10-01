@extends('backoffice_v2/layouts/default')

@section('content')
  <?php $arrayCrumbs = [ trans('backoffice_v2.Construction') => route('constructionPageBV2') ]; ?>
  @include('backoffice_v2/includes/crumbs')

  <div class="page-titulo">
    {{ trans('backoffice_v2.Construction') }}
    <div class="page-informacao" data-toggle="modal" data-target="#myModalInformation"><i class="fas fa-info"></i></div>
  </div>
  <a href="{{ route('constructionNewPageBV2') }}" class="abt bt-azul modulo-botoes"><i class="fas fa-plus"></i> {{ trans('backoffice_v2.Adicionar_obra') }}</a>

  <div class="modulo-table">
    <div class="modulo-scroll">
      <table class="modulo-body" id="sortable">
        <thead>
          <tr>
            <th class="display-none"></th>
            <th>#</th>
            <th>{{ trans('backoffice_v2.Name') }}</th>
            <th>{{ trans('backoffice_v2.Adress') }}</th>
            <th>{{ trans('backoffice_v2.Online') }}</th>
            <th>{{ trans('backoffice_v2.Option') }}</th>
          </tr>
        </thead>
      <tbody>
        @foreach($array as $val)
        <tr id="linha_{{ $val->id }}">
          <td class="display-none"></td>
          <td>{{ $val->id }}</td>
          <td>{{ $val->nome }}</td>
          <td>{{ $val->morada }}</td>
          <td class="check-border">
            <input type="checkbox" name="online" id="check3{{ $val->id }}" value="1" onchange="updateOnOffTM({{ $val->id }});" 
            @if($val->online) checked @endif>
            <label for="check3{{ $val->id }}"><span></span></label>
          </td>
          <td class="table-opcao">
            <a href="{{ route('constructionEditPageBV2',['id'=>$val->id]) }}" class="table-opcao"><i class="fas fa-pencil-alt"></i>&nbsp;{{trans('backoffice_v2.Edit')}}</a>&ensp;
            <span class="table-opcao" onclick="$('#id_modal').val({{ $val->id }});" data-toggle="modal" data-target="#myModalDelete">
              <i class="far fa-trash-alt"></i>&nbsp;{{trans('backoffice_v2.Delete')}}
            </span>
          </td>
        </tr>
        @endforeach
        @if(!isset($val->id)) <tr><td colspan="6">{{ trans('backoffice_v2.noRecords') }}</td></tr> @endif
      </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Delete -->
  <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <input type="hidden" name="id_modal" id="id_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">{{ trans('backoffice_v2.DeleteObra') }}</h4></div>
        <div class="modal-body">{!! trans('backoffice_v2.DeleteInformationObra') !!}</div>
        <div class="modal-footer">
          <button type="button" class="bt bt-vermelho" data-dismiss="modal"><i class="fas fa-times"></i> {{ trans('backoffice_v2.Cancel') }}</button>&nbsp;
          <button type="button" class="bt bt-verde" data-dismiss="modal" onclick="apagarLinha();"><i class="fas fa-check"></i> {{ trans('backoffice_v2.Delete') }}</button>
          <div class="clearfix height-20"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Information -->
  <div class="modal fade" id="myModalInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">{{ trans('backoffice_v2.Construction') }}</h4></div>
        <div class="modal-body">{!! trans('backoffice_v2.infoPageObras') !!}</div>
        <div class="modal-footer"><button type="button" class="bt bt-azul" data-dismiss="modal"><i class="fas fa-check"></i> {{ trans('backoffice_v2.Ok') }}</button></div>
      </div>
    </div>
  </div>
  <!-- Alert -->
  <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
    <b>{{ trans('backoffice_v2.Sucesso') }}</b> {{ trans('backoffice_v2.changeSuccessfully') }}!
  </div>
  <!-- Alert Delete-->
  <div class="alert_delete">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
    <b>{{ trans('backoffice_v2.Sucesso') }}</b> {{ trans('backoffice_v2.deleteSuccessfully') }}!
  </div>
@stop

@section('css')
<!-- PAGINAR -->
<link href="{{ asset('backoffice_v2/vendor/datatables/jquery.dataTables.css') }}" rel="stylesheet">
@stop

@section('javascript')
<!-- PAGINAR -->
<script src="{{ asset('backoffice_v2/vendor/datatables/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">

  function apagarLinha(){
    var id = $('#id_modal').val();
    $.ajax({
      type: "POST",
      url: '{{ route('deleteObraPageBV2') }}',
      data: { tabela:'obras',id:id },
      headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' }
    })
    .done(function(resposta) {
      if(resposta=='sucesso'){
        $('#linha_'+id).slideUp();

        $('.alert_delete').show();
        setTimeout(function(){
          $('.alert_delete').hide();
        }, 6000);
      }
    });
  }

  function updateOnOffTM(id){
    $.ajax({
      type: "POST",
      url: '{{ route('updateOnOffTMBV2') }}',
      data: { tabela:'obras', referencia:'id', id:id },
      headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' }
    })
    .done(function(resposta) {
      if(resposta=='sucesso'){
        $('.alert').show();
        setTimeout(function(){
          $('.alert').hide();
        }, 6000);
      }
    });
  }

  //<!-- PAGINAR -->
  $(document).ready(function(){
    $('#sortable').dataTable({
      aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0,4,5 ] }],
      lengthMenu: [[20,50,-1], [20,50,'{{ trans('agentes.All') }}']],
    });
  });

</script>
@stop