<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

|
*/

Route::get('/clear-cache', function () {
	$exitCode = Artisan::call('cache:clear');
	return '<h1>Cache facade value cleared</h1>';
});
Route::get('/optimize', function () {
	$exitCode = Artisan::call('optimize');
	return '<h1>Reoptimized class loader</h1>';
});
Route::get('/route-cache', function () {
	$exitCode = Artisan::call('route:cache');
	return '<h1>Routes cached</h1>';
});
Route::get('/route-clear', function () {
	$exitCode = Artisan::call('route:clear');
	return '<h1>Route cache cleared</h1>';
});
Route::get('/view-clear', function () {
	$exitCode = Artisan::call('view:clear');
	return '<h1>View cache cleared</h1>';
});
Route::get('/config-cache', function () {
	$exitCode = Artisan::call('config:cache');
	return '<h1>Clear Config cleared</h1>';
});

Route::group(['middleware' => ['Language']], function () {
	Route::get('/lang/{lang}', 'Language@index')->name('setLanguage');



	/* SITE */
	Route::get('/home-v1', 'Site\Home@page')->name('homepage');
	Route::post('/homepage-v1', 'Site\Home@sendEmail')->name('sendcontact');
	Route::post('/call-me-v1', 'Site\Home@sendCallMe')->name('sendCallMe');

	Route::get('/obra-v1/{id}', 'Site\Obra@page')->name('obra');
	Route::get('/obra-pdf-v1/{id}', 'Site\Obra@getpdf')->name('obraPdf');

	Route::get('/orcamento-v1', 'Backoffice\Questionario@respond')->name('orcamento');
	Route::post('/orcamento-next-question-v1', 'Backoffice\Questionario@checkquestion')->name('orcamentoNextQuestion');
	Route::post('/orcamento-submit-v1', 'Backoffice\Questionario@submitresponse')->name('orcamentoSubmit');

	/* SITE V2 */
	Route::get('/', 'Site_v2\Home@page')->name('homePageV2');
	Route::get('/obra/{id}', 'Site_v2\Obra@page')->name('obraPageV2');
	Route::get('/obra-pdf/{id}', 'Site_v2\Obra@getpdf')->name('obraPdfV2');
	Route::get('/formulario', 'Site_v2\Formulario@page')->name('formV2');
	Route::get('/page-sucesso', 'Site_v2\PageSucesso@page')->name('sucessoPageV2');
	Route::post('/call-me', 'Site_v2\Home@ligueFormV2')->name('ligueFormV2');
	Route::post('/sendContacto', 'Site_v2\Home@sendContactoV2')->name('sendContactoV2');
	Route::post('/questionario', 'Site_v2\Formulario@submeter')->name('questionarioV2');


	/* BACKOFFICE */
	Route::get('/backoffice-v1/login', 'Backoffice\Login@index')->name('loginPageB');
	Route::post('/backoffice-v1/login', 'Backoffice\Login@loginForm')->name('loginFormB');
	Route::get('/backoffice-v1/logout', 'Backoffice\Login@logout')->name('logoutPageB');

	Route::post('/backoffice-v1/restore', 'Backoffice\Login@restoreForm')->name('restoreFormB');
	Route::get('/backoffice-v1/restore-password/{token}', 'Backoffice\Login@restorePasswordPage')->name('emailRestorePageB');
	Route::post('/backoffice-v1/restore-password-form', 'Backoffice\Login@restorePasswordForm')->name('restorePasswordFormB');
	Route::get('/backoffice-v1/new-user/{token}', 'Backoffice\Login@restorePasswordPage')->name('emailNewUserPageB');

	/* BACKOFFICE V2 */
	Route::get('/admin/lang/{lang}', 'Backoffice_v2\Language@index')->name('setLanguageBV2');
	Route::get('/admin', 'Backoffice_v2\Login@index')->name('loginPageBV2');
	Route::post('/admin-login', 'Backoffice_v2\Login@loginForm')->name('loginFormBV2');
	Route::get('/admin/logout', 'Backoffice_v2\Login@logout')->name('logoutPageBV2');

	Route::post('/admin/restore', 'Backoffice_v2\Login@restoreForm')->name('restoreFormBV2');
	Route::get('/admin/restore-password/{token}', 'Backoffice_v2\Login@restorePasswordPage')->name('emailRestorePageBV2');
	Route::post('/admin/restore-password-form', 'Backoffice_v2\Login@restorePasswordForm')->name('restorePasswordFormBV2');
	Route::get('/admin/new-admin/{token}', 'Backoffice_v2\Login@restorePasswordPage')->name('emailNewAdminPageBV2');

	/* SITE UNIVERSAL */
	Route::get('/universal', 'Universal\Home@page')->name('homePageUniversal');
	Route::get('/universal/produto', 'Universal\Produto@page')->name('produtoPageUniversal');
	Route::get('/universal/codigo', 'Universal\Codigo@page')->name('codigoPageUniversal');
	Route::get('/universal/login', 'Universal\Login@page')->name('loginPageUniversal');
	Route::get('/universal/concurso', 'Universal\FormConcurso@page')->name('concursoPageUniversal');
	Route::get('/universal/contacto', 'Universal\Contacto@page')->name('contactoPageUniversal');
	Route::post('/universal/envio-contacto', 'Universal\Contacto@sendcontact')->name('sendContactPageUniversal');
	Route::post('/universal/envio-produto', 'Universal\Produto@sendcontact')->name('sendProdutoPageUniversal');
});

/* BACKOFFICE */
Route::group(['middleware' => ['Backoffice']], function () {
	Route::get('/backoffice-v1', 'Backoffice\Dashboard@index')->name('homePageB');

	Route::get('/backoffice-v1/dashboard', 'Backoffice\Dashboard@index')->name('dashboardPageB');

	Route::get('/backoffice-v1/user-account', 'Backoffice\UserAccount@index')->name('userAccountPageB');
	Route::post('/backoffice-v1/user-account-avatar', 'Backoffice\UserAccount@accountAvatarForm')->name('userAccAvaFormB');
	Route::post('/backoffice-v1/user-account-avatar-delete', 'Backoffice\UserAccount@accountAvatarApagar')->name('userAccAvaApagarB');
	Route::post('/backoffice-v1/user-account-dados', 'Backoffice\UserAccount@accountDataForm')->name('userAccDatFormB');

	Route::get('/backoffice-v1/user-all', 'Backoffice\User@index')->name('userAllPageB');
	Route::post('/backoffice-v1/user-all-delete', 'Backoffice\User@userApagar')->name('userAllApagarB');
	Route::get('/backoffice-v1/user-new', 'Backoffice\User@userNew')->name('userNewPageB');
	Route::get('/backoffice-v1/user-edit/{id}', 'Backoffice\User@userEdit')->name('userEditPageB');
	Route::post('/backoffice-v1/user-new-edit', 'Backoffice\User@userForm')->name('userFormB');

	Route::get('/backoffice-v1/pages', 'Backoffice\Pages@index')->name('admin_pages');
	Route::get('/backoffice-v1/new-page-config', 'Backoffice\Pages@newPageConfig')->name('admin_newpageconfig');
	Route::get('/backoffice-v1/edit-page-config/{id}', 'Backoffice\Pages@editPageConfig')->name('admin_editpageconfig');
	Route::post('/backoffice-v1/edit-page-element-config', 'Backoffice\Pages@editPageElementConfig')->name('admin_editpageelementconfig');
	Route::post('/backoffice-v1/delete-element-page-config', 'Backoffice\Pages@deleteElement')->name('admin_deletepageconfig');
	Route::post('/backoffice-v1/delete-element-option-page-config', 'Backoffice\Pages@deleteElementOption')->name('admin_deleteelementoptionconfig');
	Route::post('/backoffice-v1/edit-element-option-page-config', 'Backoffice\Pages@editElementOption')->name('admin_editelementoptionconfig');
	Route::post('/backoffice-v1/insert-element-option-page-config', 'Backoffice\Pages@insertElementOption')->name('admin_insertelementoptionconfig');
	Route::post('/backoffice-v1/insert-page-config', 'Backoffice\Pages@insertPageConfig')->name('admin_insertpageconfig');
	Route::post('/backoffice-v1/update-page-config', 'Backoffice\Pages@updatePageConfig')->name('admin_updatepageconfig');
	Route::get('/backoffice-v1/edit-page/{id}', 'Backoffice\Pages@editPage')->name('admin_editpage');
	Route::post('/backoffice-v1/edit-page', 'Backoffice\Pages@editPagePost')->name('admin_editpagepost');
	Route::post('/backoffice-v1/delete-page', 'Backoffice\Pages@deletePage')->name('admin_deletepage');

	Route::get('/backoffice-v1/lists', 'Backoffice\Lists@index')->name('admin_lists');
	Route::get('/backoffice-v1/list/{id}', 'Backoffice\Lists@listagem')->name('admin_listagem');
	Route::get('/backoffice-v1/new-list-config', 'Backoffice\Lists@newListConfig')->name('admin_newlistconfig');
	Route::get('/backoffice-v1/edit-list-config/{id}', 'Backoffice\Lists@editListConfig')->name('admin_editlistconfig');
	Route::post('/backoffice-v1/delete-element-list-config', 'Backoffice\Lists@deleteElement')->name('admin_deletelistconfig');
	Route::post('/backoffice-v1/delete-element-option-list-config', 'Backoffice\Lists@deleteElementOption')->name('admin_deleteelementoptionconfig_list');
	Route::post('/backoffice-v1/edit-element-option-list-config', 'Backoffice\Lists@editElementOption')->name('admin_editelementoptionconfig_list');
	Route::post('/backoffice-v1/edit-list-element-config', 'Backoffice\Lists@editListElementConfig')->name('admin_editlistelementconfig');
	Route::post('/backoffice-v1/insert-element-option-list-config', 'Backoffice\Lists@insertElementOption')->name('admin_insertelementoptionconfig_list');
	Route::post('/backoffice-v1/insert-list-config', 'Backoffice\Lists@insertListConfig')->name('admin_insertlistconfig');
	Route::post('/backoffice-v1/update-list-config', 'Backoffice\Lists@updateListConfig')->name('admin_updatelistconfig');
	Route::post('/backoffice-v1/delete-list', 'Backoffice\Lists@deleteList')->name('admin_deletelist');
	Route::get('/backoffice-v1/edit-entry/{id}', 'Backoffice\Lists@editEntry')->name('admin_editentry');
	Route::post('/backoffice-v1/edit-entry', 'Backoffice\Lists@editEntryPost')->name('admin_editentryPost');
	Route::post('/backoffice-v1/new-entry', 'Backoffice\Lists@newentryPost')->name('admin_newentryPost');
	Route::post('/backoffice-v1/delete-entry', 'Backoffice\Lists@deleteEntry')->name('admin_deleteEntry');

	Route::get('/backoffice-v1/cats', 'Backoffice\Cats@index')->name('admin_cats');
	Route::get('/backoffice-v1/new-cat', 'Backoffice\Cats@newCat')->name('admin_newcat');

	Route::get('/backoffice-v1/menus', 'Backoffice\Menus@index')->name('admin_menus');
	Route::get('/backoffice-v1/new-menu', 'Backoffice\Menus@newMenu')->name('admin_newmenu');

	Route::get('/backoffice-v1/config', 'Backoffice\AdminConfig@index')->name('admin_config');
	Route::post('/backoffice-v1/config/set-languages', 'Backoffice\AdminConfig@update')->name('admin_config_update');

	Route::get('/backoffice-v1/questionario', 'Backoffice\Questionario@index')->name('admin_questionario');
	Route::post('/backoffice-v1/questionario', 'Backoffice\Questionario@insert')->name('admin_questionariopost');
	Route::get('/backoffice-v1/questionario-edit', 'Backoffice\Questionario@edit')->name('admin_questionario_edit');
	Route::post('/backoffice-v1/questionario-delete', 'Backoffice\Questionario@deletequestion')->name('admin_questionario_delete');
	Route::get('/backoffice-v1/questionario-respostas', 'Backoffice\Questionario@respostas')->name('admin_questionario_respostas');
	Route::get('/backoffice-v1/questionario-resposta/{id}', 'Backoffice\Questionario@resposta')->name('admin_questionario_resposta');
	Route::get('/backoffice-v1/questionario-downloadfile/{file}', 'Backoffice\Questionario@downloadfile')->name('orcamento_downloadfile');
	Route::post('/backoffice-v1/questionario-apagar-resposta', 'Backoffice\Questionario@apagarResposta')->name('apagar_resposta');

	Route::get('/backoffice-v1/blog-all', 'Backoffice\Blog@index')->name('blogAllPageB');
	Route::post('/backoffice-v1/blog-all-delete', 'Backoffice\Blog@articleApagar')->name('blogAllApagarB');
	Route::get('/backoffice-v1/blog-new', 'Backoffice\Blog@articleNew')->name('blogNewPageB');
	Route::get('/backoffice-v1/blog-edit/{id}', 'Backoffice\Blog@articleEdit')->name('blogEditPageB');
	Route::post('/backoffice-v1/blog-new-edit', 'Backoffice\Blog@articleForm')->name('blogFormB');


	Route::post('/TM-onoff-v1', 'Backoffice\_TableManager@updateOnOff')->name('updateOnOffTM');
	Route::post('/TM-delLine-v1', 'Backoffice\_TableManager@deleteLine')->name('deleteLineTM');
});


/* BACKOFFICE V2 */
Route::group(['middleware' => ['BackofficeV2']], function () {
	Route::get('/admin/dashboard', 'Backoffice_v2\Dashboard@index')->name('dashboardPageBV2');

	//Minha conta
	Route::get('/admin/admin-account', 'Backoffice_v2\AdminAccount@index')->name('adminAccountPageBV2');
	Route::post('/admin/admin-account-avatar', 'Backoffice_v2\AdminAccount@accountAvatarForm')->name('adminAccAvaFormBV2');
	Route::post('/admin/admin-account-avatar-delete', 'Backoffice_v2\AdminAccount@accountAvatarApagar')->name('adminAccAvaApagarBV2');
	Route::post('/admin/admin-account-dados', 'Backoffice_v2\AdminAccount@accountDataForm')->name('adminAccDatFormBV2');

	//Administradores
	Route::get('/admin/admin-all', 'Backoffice_v2\Admin@index')->name('adminAllPageBV2');
	Route::post('/admin/admin-all-delete', 'Backoffice_v2\Admin@adminApagar')->name('adminAllApagarBV2');
	Route::get('/admin/admin-new', 'Backoffice_v2\Admin@adminNew')->name('adminNewPageBV2');
	Route::get('/admin/admin-edit/{id}', 'Backoffice_v2\Admin@adminEdit')->name('adminEditPageBV2');
	Route::post('/admin/admin-new-edit', 'Backoffice_v2\Admin@adminForm')->name('adminFormBV2');

	//Conteudos
	Route::get('/admin/contents', 'Backoffice_v2\Contents@contentsPage')->name('contentsPageBV2');
	Route::get('/admin/contents-edit/{id}', 'Backoffice_v2\Contents@contentsDetails')->name('contentsDetailsPageBV2');
	Route::get('/admin/contents-new', 'Backoffice_v2\Contents@contentsNew')->name('contentsNewPageBV2');
	Route::post('/admin/contents-edit', 'Backoffice_v2\Contents@editContents')->name('editContentsPageBV2');
	Route::post('/admin/contents-removeCat', 'Backoffice_v2\Contents@removeCatalogo')->name('removeCatalogo');
	Route::post('/admin/contents-add', 'Backoffice_v2\Contents@addContents')->name('addContentsPageBV2');

	//Noticias
	Route::get('/admin/news', 'Backoffice_v2\News@newsPage')->name('newsPageBV2');
	Route::get('/admin/news-new/{id}', 'Backoffice_v2\News@newsDetails')->name('newsDetailsPageBV2');
	Route::get('/admin/news-new', 'Backoffice_v2\News@newNoticia')->name('newsNoticiaPageBV2');
	Route::post('/admin/news-save', 'Backoffice_v2\News@saveNews')->name('saveNewsPageBV2');

	//Servicos
	Route::get('/admin/services', 'Backoffice_v2\Services@servicesPage')->name('servicesPageBV2');
	Route::get('/admin/services-new', 'Backoffice_v2\Services@servicesNew')->name('servicesNewPageBV2');
	Route::get('/admin/services-edit/{id}', 'Backoffice_v2\Services@servicesEdit')->name('servicesEditPageBV2');
	Route::post('/admin/services-new', 'Backoffice_v2\Services@saveService')->name('servicesSavePageBV2');

	//Obras
	Route::get('/admin/construction', 'Backoffice_v2\Construction@constructionPage')->name('constructionPageBV2');
	Route::get('/admin/construction/{id}', 'Backoffice_v2\Construction@constructionEdit')->name('constructionEditPageBV2');
	Route::get('/admin/construction-new', 'Backoffice_v2\Construction@constructionNew')->name('constructionNewPageBV2');
	Route::post('/admin/construction-save', 'Backoffice_v2\Construction@saveConstruction')->name('saveConstructionPageBV2');
	Route::post('/admin/construction-contents', 'Backoffice_v2\Construction@updateImagem')->name('updateContentsImg');
	Route::post('/admin/construction-delete', 'Backoffice_v2\Construction@deleteObra')->name('deleteObraPageBV2');
	Route::post('/admin/construction-deleteImg', 'Backoffice_v2\Construction@deleteImagem')->name('deleteImagemPageBV2');
	Route::post('/admin/contruction-service', 'Backoffice_v2\Construction@saveService')->name('saveService');

	//Formulário
	Route::get('/admin/formulario', 'Backoffice_v2\Forms@formPage')->name('formPageBV2');
	Route::get('/admin/formulario-perg/{id}', 'Backoffice_v2\Forms@formEditPergunta')->name('formEditPerguntaBV2');
	Route::get('/admin/formulario-perg', 'Backoffice_v2\Forms@addPerg')->name('addPergPageBV2');
	Route::post('/admin/formulario-perg', 'Backoffice_v2\Forms@addPergPost')->name('formAddPageBV2');

	//Orçamentos
	Route::get('/admin/orcamento', 'Backoffice_v2\Orcamentos@orcamentoPage')->name('orcamentoPageBV2');
	Route::get('/admin/orcamento-edit/{id}', 'Backoffice_v2\Orcamentos@detailsOrcamento')->name('editOrcamentoPageBV2');
	Route::post('/admin/orcamento-delete', 'Backoffice_v2\Orcamentos@deleteOrcamento')->name('deleteOrcamentoPageBV2');
	Route::post('/admin/orcamento-edit', 'Backoffice_v2\Orcamentos@editOrcamento')->name('editValorOrcamento');

	//Contactos
	Route::get('/admin/contactos', 'Backoffice_v2\Contactos@contactosPage')->name('contactosPageBV2');
	Route::get('/admin/contactos-details/{id}', 'Backoffice_v2\Contactos@detailsPage')->name('contactosDetailsPageBV2');

	//Email
	Route::get('/admin/create-email', 'Backoffice_v2\Emails@emailsPage')->name('emailsPageBV2');
	Route::post('/admin/create-email', 'Backoffice_v2\Emails@createEmail')->name('createEmail');

	//Planos de Comissões
	Route::get('/admin/commissions', 'Backoffice_v2\Commissions@commissionsPage')->name('commissionsPageBV2');
	Route::get('/admin/commissions-new', 'Backoffice_v2\Commissions@commissionsNew')->name('commissionsNewPageBV2');
	Route::get('/admin/commissions-edit/{id}', 'Backoffice_v2\Commissions@commissionsEdit')->name('commissionsEditPageBV2');
	Route::post('/admin/commissions-update', 'Backoffice_v2\Commissions@commissionsUpdate')->name('commissionsUpdateBV2');
	Route::post('/admin/commissions-edit', 'Backoffice_v2\Commissions@commissionsForm')->name('commissionsFormBV2');

	//_TableManager
	Route::post('/admin/TM-onoff', 'Backoffice_v2\_TableManager@updateOnOff')->name('updateOnOffTMBV2');
	Route::post('/admin/TM-delLine', 'Backoffice_v2\_TableManager@deleteLine')->name('deleteLineTMBV2');
	Route::post('/admin/TM-repDel', 'Backoffice_v2\_TableManager@replaceDelete')->name('replaceDeleteTMBV2');
	Route::post('/admin/TM-order', 'Backoffice_v2\_TableManager@orderTable')->name('orderTableTMBV2');
});
