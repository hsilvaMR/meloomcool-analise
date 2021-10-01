@extends('backoffice_v2/layouts/default')

@section('content')
  <?php $arrayCrumbs = [ trans('backoffice_v2.Orcamentos') => route('orcamentoPageBV2') ]; ?>
  @include('backoffice_v2/includes/crumbs')

  <div class="page-titulo">
    {{ trans('backoffice_v2.Orcamentos') }}
    <div class="page-informacao" data-toggle="modal" data-target="#myModalInformation"><i class="fas fa-info"></i></div>
  </div>
  <!--<a href="{ { route('newsNoticiaPageBV2') }}" class="abt bt-azul modulo-botoes"><i class="fas fa-plus"></i> { { trans('backoffice_v2.Adicionar_noticia') }}</a>-->

  <div class="modulo-table">
    <div class="modulo-scroll">
      <table class="modulo-body" id="sortable">
        <thead>
          <tr>
            <th class="display-none"></th>
            <th>#</th>
            <th>{{ trans('backoffice_v2.Nome') }}</th>
            <th>{{ trans('backoffice_v2.Value') }}</th>
            <th>{{ trans('backoffice_v2.Date') }}</th>
            <th>{{ trans('backoffice_v2.Option') }}</th>
          </tr>
        </thead>
      <tbody>
        @foreach($formSub as $val)
        <tr id="linha_{{ $val['id'] }}">
          <td class="display-none"></td>
          <td>{{ $val['id'] }}</td>
          <input style="display: none;" type="text" name="id" value="{{ $val['id'] }}">
          <td>{{ $val['nome'] }}</td>
          <td>{{ $val['valor'] }}
            @if($val['tipo'] == 'file' && $val['resposta']!='')
              <span style="float:right;"><i class="fas fa-download"></i><a id="file_{!! $val['id'] !!}" href="{!! $val['resposta'] !!}"> ficheiro</a></span>
            @endif
          </td>
          <td>@if($val['data']) {!! date('d/m/Y',$val['data']) !!}@endif</td>
          <td class="table-opcao">
            <a href="{{ route('editOrcamentoPageBV2',['id'=>$val['id']]) }}" class="table-opcao"><i class="fas fa-pencil-alt"></i>&nbsp;{{trans('backoffice_v2.Edit')}}</a>&ensp;
            <span class="table-opcao" onclick="$('#id_modal').val({{ $val['id'] }});" data-toggle="modal" data-target="#myModalDelete">
              <i class="far fa-trash-alt"></i>&nbsp;{{trans('backoffice_v2.Delete')}}
            </span>&nbsp;
          </td>
        </tr>
        @endforeach
        @if(!isset($val['id'])) <tr><td colspan="6">{{ trans('backoffice_v2.noRecords') }}</td></tr> @endif
      </tbody>
      </table>
    </div>
  </div>
 
  <!-- Modal Delete -->
  <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <input type="hidden" name="id_modal" id="id_modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">{{ trans('backoffice_v2.ApagarOrcamento') }}</h4></div>
        <div class="modal-body">{!! trans('backoffice_v2.DeleteInformationOrcamento') !!}</div>
        <div class="modal-footer">
          <button type="button" class="bt bt-vermelho" data-dismiss="modal"><i class="fas fa-times"></i> {{ trans('backoffice_v2.Cancel') }}</button>&nbsp;
          <button type="button" class="bt bt-verde" data-dismiss="modal" onclick="apagarLinha();"><i class="fas fa-check"></i> {{ trans('backoffice_v2.Delete') }}</button>
          <div class="height-20"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Information -->
  <div class="modal fade" id="myModalInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">{{ trans('backoffice_v2.Orcamentos') }}</h4></div>
        <div class="modal-body">{!! trans('backoffice_v2.infoPageOrcamentos') !!}</div>
        <div class="modal-footer"><button type="button" class="bt bt-azul" data-dismiss="modal"><i class="fas fa-check"></i> {{ trans('backoffice_v2.Ok') }}</button></div>
      </div>
    </div>
  </div>

    <!-- Alert -->
  <div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
    <strong>{{ trans('backoffice_v2.Sucesso') }}</strong> {{ trans('backoffice_v2.deleteSuccessfully') }}!
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

  //Apagar Orçamento
  function apagarLinha(){
    var id = $('#id_modal').val();

    $.ajax({
      type: "POST",
      url: '{{ route('deleteOrcamentoPageBV2') }}',
      data: { id:id },
      headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' }
    })
    .done(function(resposta) {
      console.log(resposta);
      if(resposta=='sucesso'){
        $('#linha_'+id).slideUp();
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
      aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 5 ] }],
      lengthMenu: [[20,50,-1], [20,50,'{{ trans('backoffice_v2.All') }}']],
    });
  });
</script>
@stop