<?php namespace App\Http\Controllers\Backoffice_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Cookie;
use App\Http\Classes\uploadImage;

class Construction extends Controller
{
  private $dados=[];

  /************
  *  DOMAINS  *
  ************/
  public function constructionPage(){
    $this->dados['headTitulo']=trans('backoffice_v2.siteTitulo').trans('backoffice_v2.ObrasTitulo');
    $this->dados['separador']="obras";

    $this->dados['array']=\DB::table('obras')
                          ->orderBy('id','DESC')
                          ->get(); 
    
    return view('backoffice_v2/pages/construction-all', $this->dados);
  }

  public function constructionNew(){
    $this->dados['headTitulo']=trans('backoffice_v2.siteTitulo').trans('backoffice_v2.ObrasTitulo');
    $this->dados['separador']="obras";

    $this->dados['servicos'] = \DB::table('servicos')
                              ->select('id','nome')
                              ->get();
          
    return view('backoffice_v2/pages/construction-new', $this->dados);
  }

  public function constructionEdit($id){
    $this->dados['headTitulo']=trans('backoffice_v2.siteTitulo').trans('backoffice_v2.ObrasTitulo');
    $this->dados['separador']="obras";
    $this->dados['funcao']="edit";

    $this->dados['obras'] = \DB::table('obras')
                            ->where('id',$id)
                            ->first();

    if(empty($this->dados['obras'])){ return redirect()->route('constructionNewPageBV2');}

    $this->dados['imagens'] = \DB::table('obras_img')
                            ->where('id_obra',$id)
                            ->orderBy('ordem','ASC')
                            ->get();

    $servicosObra = \DB::table('obras_servico')
                    ->select('id_servico')
                    ->where('id_obra',$id)
                    ->get();
    $arrayServicoes=[];
    foreach ($servicosObra as $value){
      $arrayServicoes[]=$value->id_servico;
    }
    
    $servicosAll = \DB::table('servicos')
                    ->select('id','nome')
                    ->get();
    $servicos = [];
    foreach ($servicosAll as $val) {

      $valor = (in_array($val->id, $arrayServicoes)) ? 1 : 0;      

      $servicos[] = [
        'id' => $val->id,
        'nome' => $val->nome,
        'valor' => $valor
      ];
    }

    $this->dados['servicos'] = $servicos;
    return view('backoffice_v2/pages/construction-new', $this->dados);
  }

  /*Adicionar Obra*/
  public function saveConstruction(Request $request){
    $id = trim($request->id_obra);
    $nomeObra = trim($request->nome);
    $morada = trim($request->morada);
    $cor = trim($request->cor) ? trim($request->cor) : 'branco';
    $valor = trim($request->valor) ? trim($request->valor) : 0.00;
    $visivel = trim($request->visivel) ? 1 : 0;
    $dono = trim($request->dono);
    $classificacao = trim($request->classificacao);
    $area = trim($request->area);
    $prazo = trim($request->prazo);
    $pisoAbaixo = trim($request->piso_abaixo);
    $pisoAcima = trim($request->piso_acima);
    $estado = trim($request->estado) ? trim($request->estado) : 'construcao';
    $descricao = trim($request->descricao);
    $obs = trim($request->obs);
    $online = trim($request->online) ? 1 : 0;
    $servico = $request->servico;
    $ficheiro = $request->file('resposta');
    $ordem = \DB::table('obras_img')->max('ordem') + 1;

    if ($id) {
      $resposta = [];
      if ($ficheiro) {
        foreach ($ficheiro as $file) {
          $novoNome='';
          if(count($file)){
            $antigoNome='';
            $cache = str_random(3);
            $extensao = strtolower($file->getClientOriginalExtension());

            $novoNome = 'projetos-'.$cache.'.'.$extensao;


            $pasta = base_path('public_html/img/projetos/');
            $width = 300; $height = 300;

            $uploadImage = New uploadImage;
            $uploadImage->upload($file,$antigoNome,$novoNome,$pasta,$width,$height);
          }
          $resposta[] = '/img/projetos/'.$novoNome;
        }
      }
      if ($resposta) {
        foreach ($resposta as $value) {
          if ($value) {
            \DB::table('obras_img')->insert([
              'id_obra' => $id,
              'img' => $value,
              'capa' => 0,
              'fundoFrente' => 0,
              'fundoTras' => 0,
              'ordem' => $ordem
            ]);
          }
        }
      }

      \DB::table('obras')->where('id',$id)->update([
        'nome' => $nomeObra,
        'morada' => $morada,
        'cor' =>$cor,
        'valor' => $valor,
        'visivel' => $visivel,
        'dono' =>$dono,
        'classificacao' => $classificacao,
        'area' => $area,
        'prazo' =>$prazo,
        'pisoAbaixo' => $pisoAbaixo,
        'pisoAcima' => $pisoAcima,
        'estado' =>$estado,
        'descricao' => $descricao,
        'data' =>\Carbon\Carbon::now()->timestamp,
        'obs' => $obs,
        'online' => $online
      ]);
    }
    else{

      $resposta = [];
      if ($ficheiro) {
        foreach ($ficheiro as $file) {
          $novoNome='';
          if(count($file)){
            $antigoNome='';
            $cache = str_random(3);
            $extensao = strtolower($file->getClientOriginalExtension());

            $novoNome = 'projetos-'.$cache.'.'.$extensao;

            $pasta = base_path('public_html/img/projetos/');
            $width = 300; $height = 300;

            $uploadImage = New uploadImage;
            $uploadImage->upload($file,$antigoNome,$novoNome,$pasta,$width,$height);
          }
          $resposta[] = '/img/projetos/'.$novoNome;
        }
      }
      
      $id = \DB::table('obras')->insertGetId([
        'nome' => $nomeObra,
        'morada' => $morada,
        'cor' =>$cor,
        'valor' => $valor,
        'visivel' => $visivel,
        'dono' =>$dono,
        'classificacao' => $classificacao,
        'area' => $area,
        'prazo' =>$prazo,
        'pisoAbaixo' => $pisoAbaixo,
        'pisoAcima' => $pisoAcima,
        'estado' =>$estado,
        'descricao' => $descricao,
        'data' =>\Carbon\Carbon::now()->timestamp,
        'obs' => $obs,
        'online' => $online
      ]);

      if ($resposta) {
        foreach ($resposta as $value) {
          if ($value) {
            \DB::table('obras_img')->insert([
              'id_obra' => $id,
              'img' => $value,
              'capa' => 0,
              'fundoFrente' => 0,
              'fundoTras' => 0,
              'ordem' => $ordem
            ]);
          }
        }
      }
      //servicos
      if ($servico) {
        foreach($servico as $value) {
       
          if($value){
            \DB::table('obras_servico')->insert([   
              'id_obra' => $id,
              'id_servico' => trim($value)
            ]);          
          }
        }
      }
    }  

    $resposta = [
      'id' => $id,
      'estado' => 'sucesso',
      'mensagem' =>'Obrigado! Entraremos em contacto brevemente.' ];

    return json_encode($resposta,true);
  }

  /*Editar updateImagem*/
  public function updateImagem(Request $request){

    $id_img=$request->id_img;
    $campo=$request->campo;
    $id_obra = $request->id_obra;

    \DB::table('obras_img')->where('id_obra', $id_obra)->update([ $campo => 0 ]);
    \DB::table('obras_img')->where('id', $id_img)->update([ $campo => 1 ]);

    return 'sucesso';
  }

  /*Editar servico*/
  public function saveService(Request $request){
    
    $id_serv=trim($request->id_serv);
    $id_obra= trim($request->id_obra);
    $valor= ($request->valor);

    //return $valor;
    if ($valor == 1) {\DB::table('obras_servico')->where('id_obra', $id_obra)->where('id_servico', $id_serv)->delete(); $val = 0;}
    else{
      \DB::table('obras_servico')->where('id_obra', $id_obra)->where('id_servico', $id_serv)->delete();
      \DB::table('obras_servico')->insert([
        'id_obra' => $id_obra,
        'id_servico' => $id_serv
      ]);

      $val = 1;
    }

    return $val;
  }

  /*Eliminar Obra*/    

  public function deleteObra(Request $request){
    
    $id=trim($request->id);
    $imagens = \DB::table('obras_img')
                ->select('img')
                ->where('id_obra',$id)
                ->get();


    foreach ($imagens as $value) {
     if($value && file_exists(base_path('public_html/'.$value->img))){ \File::delete('../public_html'.$value->img); }
    }

    \DB::table('obras_img')->where('id_obra',$id)->delete();
    \DB::table('obras')->where('id',$id)->delete();
    
    return 'sucesso';
  }

  public function deleteImagem(Request $request){
    
    $id=trim($request->id);
    $imagens_obra = \DB::table('obras_img')
                ->select('img')
                ->where('id',$id)
                ->get();

 
    foreach ($imagens_obra as $value) {
     if($value && file_exists(base_path('public_html/'.$value->img))){ \File::delete('../public_html'.$value->img); }
    }

    \DB::table('obras_img')->where('id',$id)->delete();
    return 'sucesso';
  }
}