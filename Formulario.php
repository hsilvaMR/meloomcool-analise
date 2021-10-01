<?php 
namespace App\Http\Controllers\Site_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Http\Classes\uploadImage;

use Mail;

class Formulario extends Controller{

    private $dados = [];

    public function page(){
        $this->dados['headTitulo'] = trans('metatags.formulario');
        $this->dados['headDescricao'] = trans('metatags.d_home');
        $this->dados['headPagina'] = 'Formulario';

        $formulario = \DB::table('form_pergunta')
                    ->where('online','1')
                    ->where('pergunta','!=','')
                    ->orderBy('ordem','ASC')
                    ->get();

        $array=[];
        foreach ($formulario as $val) {

            $formulario_opc = \DB::table('form_opcao')
                    ->select('opcao','id')
                    ->where('id_form',$val->id)
                    ->get();

            $perguntas = ($val->obrigatorio) ?  '<label class="quest-pergunta" for="'.$val->pergunta.'">'.$val->pergunta.' <span class="tx-verde font14">*</span></label>' : '<label class="quest-pergunta">'.$val->pergunta.'</label>';
            $respostas='';$opc='';

            switch ($val->tipo) {

                case 'input':

                    $respostas = '<div class="quest-resposta"><input class="ip" type="text" name="resposta'.$val->id.'"></div>';
                    break;
                case 'textarea':
                    
                    $respostas = '<div class="quest-resposta"><textarea class="tx" rows="8" name="resposta'.$val->id.'"></textarea></div>';
                    break;
                case 'checkbox':
                    
                    foreach($formulario_opc as $op){
                        
                        $respostas .= '<div class="margin-top10"><input type="checkbox" id="resposta'.$op->id.'" name="resposta'.$val->id.'[]" value="'.$op->opcao.'">
                        <label for="resposta'.$op->id.'"><span></span>'.$op->opcao.'</label><br></div>'; 
                    }
                    break;
                case 'radiobutton':

                    foreach($formulario_opc as $op){

                        $respostas .='<div class="margin-top10"><input type="radio" id="resposta'.$op->id.'" name="resposta'.$val->id.'" value="'.$op->opcao.'">
                        <label for="resposta'.$op->id.'"><span></span>'.$op->opcao.'</label><br></div>';
                    }
                    break;
                case 'check_input':

                    $respostas = '<div class="quest-resposta"><input class="ip" type="text" name="resposta'.$val->id.'"></div>';
                    break;
                case 'radio_input':

                    $respostas = '<div class="quest-resposta"><input class="ip" type="text" name="resposta'.$val->id.'"></div>';
                    break;

                case 'select':
                    if(isset($formulario_opc)){
                        $respostas = '<div class="quest-resposta"><select name="resposta'.$val->id.'"><option value="'.$op->opcao.'" disabled selected>Selecione uma opção</option>';
                        foreach ($formulario_opc as $op){$respostas .= '<option value="'.$op->opcao.'">'.$op->opcao.'</option>';}
                        $respostas .= '</select></div>';
                    } 
                    break;
                
                case 'file':
                  
                    $respostas ='<div class="quest-resposta div-50">
                                    <label class="a-dotted-white" id="uploads'.$val->id.'">&nbsp;</label>
                                    <label class="quest-legenda">São aceites ficheiros em PNG,JPG,PDF,RAR e ZIP</label>
                                </div>
                                <label for="selecao-arquivo'.$val->id.'" class="lb-40 bt-cinza float-right"><i class="fa fa-upload" aria-hidden="true"></i></label>
                                <input id="selecao-arquivo'.$val->id.'" type="file" name="resposta'.$val->id.'" accept=".jpg, .jpeg, .png, .pdf, .rar, .zip" onchange="lerFicheiros(this,\'uploads'.$val->id.'\');" >';
                    break;
            }

            if(!$respostas){ continue; }
            
            $array[]=[
                'id' => $val->id,
                'pergunta' => $perguntas,
                'resposta' => $respostas,
                'obrigatorio' => $val->obrigatorio
            ];
        }

        $this->dados['formulario'] = $array;
        return view('site_v2/pages/formulario', $this->dados);
    }

    public function submeter(Request $request){
        
        $formulario = \DB::table('form_pergunta')
                      ->where('online','1')
                      ->orderBy('ordem','ASC')
                      ->get();

        $max_id = \DB::table('form_sub')->max('id');

        $email_auto = \DB::table('email_auto')
                        ->get();


        $arrayRequest = [];
        $dados = [];
        $nome = trim($request->resposta69);
        $email = trim($request->resposta70);

        $id_form = $request->id_form;

        foreach ($formulario as $val) {
            $resposta = '';

            $resp = 'resposta'.$val->id;
            switch ($val->tipo) {
                case 'input':
                case 'textarea':
                case 'select':
                case 'radiobutton':
                    $resposta = trim($request->$resp);
                break;
                    
                case 'checkbox':
                    $resposta = json_encode($request->input($resp));
                break;
                
                case 'file':
                    $ficheiro=$request->file($resp);
                    if(count($ficheiro)){$resposta = $ficheiro;}
                break;

                default:$resposta='';
            } 

            if($val->obrigatorio && empty($resposta)){return 'Existem campos obrigatórios por preencher.';}

            $arrayRequest[] = [
                'id_pergunta' => $val->id,
                'pergunta' => $val->pergunta,
                'resposta' => $resposta,
                'tipo' => $val->tipo
            ];


        }

  
        $termos = $request->termos;
        if(empty($termos)){return 'Deve concordar com a utilização dos dados.';}

        if (!isset($id_form)) {
            $id = DB::table('form_sub')->insertGetId([ 'data'=>\Carbon\Carbon::now()->timestamp ]);
            DB::table('form_sub')->where('id',$id)->update([ 'nome'=>'Formulario '.$id ]);
        }else{
            $id = $id_form;
        }
        
        
        $anexosEmail = '';
        $arrayAnexos = [];
        foreach ($arrayRequest as $value) {

            if($value['resposta'] && $value['tipo'] == 'file'){
                
                $destinationPath = base_path('public_html/doc/');
                $extension = strtolower($value['resposta']->getClientOriginalExtension());
                $getName =$value['resposta']->getPathName();

                $novoNome = 'file-'.$id.'-'.str_random(3).'.'.$extension;
                $width = $height = 1200;

                switch ($extension) {
                    case 'pdf':
                    case 'rar':
                    case 'zip':
                        move_uploaded_file($getName, $destinationPath.$novoNome);
                        break;

                    case 'png':
                    case 'jpg':
                    case 'jpeg':
                        $uploadImage = New uploadImage;
                        $uploadImage->upload($value['resposta'],'',$novoNome,$destinationPath,$width,$height);
                        break;

                    default:
                        $resposta = [
                            'estado' => 'erro',
                            'id_form' => $id,
                            'mensagem' =>'Extensão do ficheiro não suportada.'
                        ];
                        return json_encode($resposta,true);
                      
                        break;
                }
                $value['resposta'] = '/doc/'.$novoNome;
                $arrayAnexos[] = 'http://www.melomcool.pt'.$value['resposta'];
            }
            
            if ($value['resposta'] == 'null') {$value['resposta'] = '';}

            DB::table('form_sub_ind')->insert([
                        'id_form_sub' => $id,
                        'pergunta' => $value['pergunta'],
                        'resposta'=> $value['resposta'],
                        'tipo' => $value['tipo']
            ]);

            $dados[] = [
                'pergunta' => $value['pergunta'],
                'resposta' => $value['resposta'],
                'tipo' => $value['tipo'],
                'data_pedido' => \Carbon\Carbon::now()->timestamp
            ];
        }

            foreach ($email_auto as $val) {
                $assunto = $val->assunto;
                $mensagem = $val->mensagem;
            }

            $dados_cliente = [
                'nome' => $nome,
                'email' => $email,
                'assunto' => $assunto,
                'mensagem' => $mensagem
            ];

           
        Mail::send('site_v2.emails.pages.formulario',['dados' => $dados], function ($message) use ($arrayAnexos){
            $message->to('joaquim.machado@melom.pt','Joaquim Machado')->subject('Contacto do site Melom Cool');

            foreach($arrayAnexos as $val){
                $message->attach($val);
            }

            //$message->attach('http://www.melomcool.pt/doc/file-14-NX4.png');
            //$message->attach('http://www.melomcool.pt/doc/file-15-9OK.jpg');
            $message->from(config('mailAccounts.geral')['email'],config('mailAccounts.geral')['nome']);
            
        });


        /*Email enviado automaticamente*/

        Mail::send('site_v2.emails.pages.mail-sucesso',['dados_cliente' => $dados_cliente], function ($message) use ($request,$email_auto){
            foreach ($email_auto as $val) {
                $message->to($request->resposta70,$request->nome)->subject($val->assunto);
                $message->from(config('mailAccounts.geral')['email'],config('mailAccounts.geral')['nome']);
            }  
        });

        $resposta = [
           'estado' => 'sucesso',
           'mensagem' =>'Obrigado! Entraremos em contacto brevemente.'
        ];
        return json_encode($resposta,true);
    }  
}