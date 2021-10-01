<?php namespace App\Http\Controllers\Backoffice_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Cookie;
use File;

class Orcamentos extends Controller
{
  private $dados=[];

  /************
  *  DOMAINS  *
  ************/
  public function orcamentoPage(){



    $this->dados['headTitulo']=trans('backoffice_v2.siteTitulo').trans('backoffice_v2.OrcamentosTitulo');
    $this->dados['separador']="orcamentos";

    $formSub=\DB::table('form_sub')
                            ->select('form_sub.*')
                            ->orderBy('id','DESC')
                            ->get();

    $form = [];
    foreach ($formSub as $value) {
      $formSubInd = \DB::table('form_sub_ind')->where('id_form_sub',$value->id)->where('tipo','file')->first();

      $tipo = '';
      $resposta = '';
      if (isset($formSubInd->id)) {
        $tipo = 'file';
        $resposta = $formSubInd->resposta;
      }

      $form[] = [
        'id' => $value->id,
        'nome' => $value->nome,
        'valor' => $value->valor,
        'data' => $value->data,
        'tipo' => $tipo,
        'resposta' => $resposta
      ];
    }

    $this->dados['formSub'] = $form;

    //return $this->dados['formSub'];

    //$this->dados['formSubInd']=\DB::table('form_sub_ind')->get();


    return view('backoffice_v2/pages/orcamentos-all', $this->dados);

  }

  public function detailsOrcamento($id){

    $this->dados['headTitulo']=trans('backoffice_v2.siteTitulo').trans('backoffice_v2.OrcamentosTitulo');
    $this->dados['separador']="orcamentos";

    $this->dados['formSub']=\DB::table('form_sub')
                              ->where('id',$id)
                              ->first();

    $this->dados['formSubInd']=\DB::table('form_sub_ind')
                                ->where('id_form_sub',$id)
                                ->get();

    if(empty($this->dados['formSub'])){ return redirect()->route('orcamentoPageBV2');}
    return view('backoffice_v2/pages/orcamentos-edit', $this->dados);

  }

  public function editOrcamento(Request $request){

    $valor = trim($request->valor) ? trim($request->valor) : '';
    $obs = trim($request->obs) ? trim($request->obs) : '';
    $nome = trim($request->nome);
    $id_sub = trim($request->id_sub);

    \DB::table('form_sub')->where('id',$id_sub)->update([
      'nome' => $nome,
      'valor' => $valor,
      'obs' => $obs
    ]);

    $resposta = [
      'id' => $id_sub,
      'estado' => 'sucesso',
      'mensagem' =>'Obrigado! Entraremos em contacto brevemente.' ];

    return json_encode($resposta,true);
  }

  public function deleteOrcamento(Request $request){

    $id=trim($request->id);
    $files = \DB::table('form_sub_ind')
                ->select('resposta')
                ->where('tipo','file')
                ->where('id_form_sub',$id)
                ->get();

    foreach ($files as $value) {
     if($value && file_exists(base_path('public_html'.$value->resposta))){ \File::delete('../public_html'.$value->resposta); }
    }

    \DB::table('form_sub_ind')->where('id_form_sub',$id)->delete();
    \DB::table('form_sub')->where('id',$id)->delete();
    
    return 'sucesso';
  }
}