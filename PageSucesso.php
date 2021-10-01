<?php 
namespace App\Http\Controllers\Site_v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


class PageSucesso extends Controller{

	private $dados = [];

    public function page(){

        $this->dados['headTitulo'] = trans('metatags.t_home');
        $this->dados['headDescricao'] = trans('metatags.d_home');
        $this->dados['headPagina'] = 'Home';

        return view('site_v2/pages/page-sucesso', $this->dados);
    }

}