<?
/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECONÔMICA
 * 2014-09-29
 * Versão do Gerador de Código: 1.0
 * Versão no CVS/SVN:
 *
 * sei
 * pesquisa
 * processo_pesquisar
 *
 *
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 */

/**
 * Pagina de apresentação da página de pesquisa.
 *
 *
 * @package Cade_pesquisa_processo_pesquisar
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 * @license Creative Commons Atribuição 3.0 não adaptada
 *          <http://creativecommons.org/licenses/by/3.0/deed.pt_BR>
 * @ignore Este código é livre para uso sem nenhuma restrição,
 *         salvo pelas informações a seguir referentes
 * @copyright Conselho Administrativo de Defesa Econômica ©2014-2018
 *            <http://www.cade.gov.br>
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 */


try {
	require_once dirname(__FILE__).'/../../SEI.php';
	require_once dirname(__FILE__).'/MdPesqBuscaProtocoloExterno.php';
	require_once ("MdPesqConverteURI.php");

//	session_start();

	SessaoSEIExterna::getInstance()->validarSessao();

// 	InfraDebug::getInstance()->setBolLigado(false);
// 	InfraDebug::getInstance()->setBolDebugInfra(false);
// 	InfraDebug::getInstance()->limpar();

	$objParametroPesquisaDTO = new MdPesqParametroPesquisaDTO();
	$objParametroPesquisaDTO->retStrNome();
	$objParametroPesquisaDTO->retStrValor();
	
	$objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
 	$arrObjParametroPesquisaDTO = $objParametroPesquisaRN->listar($objParametroPesquisaDTO);
	
	$arrParametroPesquisaDTO = InfraArray::converterArrInfraDTO($arrObjParametroPesquisaDTO,'Valor','Nome');
	
	$bolCaptcha = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA] == 'S' ? true : false;
	$bolAutocompletarInterressado = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO] == 'S' ? true : false;


 //	SessaoSEIExterna::getInstance()->validarLink();
 	MdPesqPesquisaUtil::valiadarLink();

	PaginaSEIExterna::getInstance()->setBolXHTML(false);

	if($bolCaptcha) {
		$strCodigoParaGeracaoCaptcha = InfraCaptcha::obterCodigo();
		$md5Captcha = md5(InfraCaptcha::gerar($strCodigoParaGeracaoCaptcha));
	}else {
		$md5Captcha = null;
	}
	if (isset($_POST['hdnFlagPesquisa']) || isset($_POST['sbmLimpar'])){
		
		if(isset($_POST['sbmLimpar'])){
			
			PaginaSEIExterna::getInstance()->limparCampos();
			PaginaSEIExterna::getInstance()->salvarCampo('rdoData', '');
			PaginaSEIExterna::getInstance()->salvarCampo('chkSinProcessos', 'P');
			
			
		}else{
			
			PaginaSEIExterna::getInstance()->salvarCampo('chkSinProcessos', $_POST['chkSinProcessos']);
			PaginaSEIExterna::getInstance()->salvarCampo('chkSinDocumentosGerados', $_POST['chkSinDocumentosGerados']);
			PaginaSEIExterna::getInstance()->salvarCampo('chkSinDocumentosRecebidos', $_POST['chkSinDocumentosRecebidos']);
			
			PaginaSEIExterna::getInstance()->salvarCamposPost(array('q',
					'txtParticipante',
					'hdnIdParticipante',
					'txtAssinante',
					'hdnIdAssinante',
					'txtDescricaoPesquisa',
					'txtObservacaoPesquisa',
					'txtAssunto',
					'hdnIdAssunto',
					'txtUnidade',
					'hdnIdUnidade',
					'txtProtocoloPesquisa',
					'selTipoProcedimentoPesquisa',
					'selSeriePesquisa',
					'txtNumeroDocumentoPesquisa',
					'rdoData',
					'txtDataInicio',
					'txtDataFim',
					'hdnSiglasUsuarios',
					'txtSiglaUsuario1',
					'txtSiglaUsuario2',
					'txtSiglaUsuario3',
					'txtSiglaUsuario4'
			));
			
		}
			

	}else{

		PaginaSEIExterna::getInstance()->salvarCampo('q', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtProtocoloPesquisa', $strProtocoloFormatadoLimpo);			
		PaginaSEIExterna::getInstance()->salvarCampo('chkSinProcessos', 'P');
		PaginaSEIExterna::getInstance()->salvarCampo('chkSinDocumentosGerados', '');
		PaginaSEIExterna::getInstance()->salvarCampo('chkSinDocumentosRecebidos', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtParticipante', '');
		PaginaSEIExterna::getInstance()->salvarCampo('hdnIdParticipante', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtAssinante', '');
		PaginaSEIExterna::getInstance()->salvarCampo('hdnIdAssinante', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtDescricaoPesquisa', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtObservacaoPesquisa', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtAssunto', '');
		PaginaSEIExterna::getInstance()->salvarCampo('hdnIdAssunto', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtUnidade', '');
		PaginaSEIExterna::getInstance()->salvarCampo('hdnIdUnidade', '');
		//PaginaSEIExterna::getInstance()->salvarCampo('txtProtocoloPesquisa', '');
		PaginaSEIExterna::getInstance()->salvarCampo('selTipoProcedimentoPesquisa', '');
		PaginaSEIExterna::getInstance()->salvarCampo('selSeriePesquisa', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtNumeroDocumentoPesquisa', '');
		PaginaSEIExterna::getInstance()->salvarCampo('rdoData', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtDataInicio', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtDataFim', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtSiglaUsuario1', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtSiglaUsuario2', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtSiglaUsuario3', '');
		PaginaSEIExterna::getInstance()->salvarCampo('txtSiglaUsuario4', '');
		PaginaSEIExterna::getInstance()->salvarCampo('hdnSiglasUsuarios', '');
	}


	switch($_GET['acao_externa']){

		case 'protocolo_pesquisar':
		case 'protocolo_pesquisa_rapida':

			
			$strTitulo = 'Pesquisa Pública';
			

			// Altero os caracteres 'Coringas' por aspas Duplas para não dar erro de Js no IE
			$strPalavrasPesquisa = str_replace("$*",'\"',PaginaSEIExterna::getInstance()->recuperarCampo('q'));
			$strSinProcessos = PaginaSEIExterna::getInstance()->recuperarCampo('chkSinProcessos');
			$strSinDocumentosGerados = PaginaSEIExterna::getInstance()->recuperarCampo('chkSinDocumentosGerados');
			$strSinDocumentosRecebidos = PaginaSEIExterna::getInstance()->recuperarCampo('chkSinDocumentosRecebidos');
			$strIdParticipante = PaginaSEIExterna::getInstance()->recuperarCampo('hdnIdParticipante');
			$strNomeParticipante = PaginaSEIExterna::getInstance()->recuperarCampo('txtParticipante');
			$strIdAssinante = PaginaSEIExterna::getInstance()->recuperarCampo('hdnIdAssinante');
			$strNomeAssinante = PaginaSEIExterna::getInstance()->recuperarCampo('txtAssinante');
			$strDescricaoPesquisa = PaginaSEIExterna::getInstance()->recuperarCampo('txtDescricaoPesquisa');
			$strObservacaoPesquisa = PaginaSEIExterna::getInstance()->recuperarCampo('txtObservacaoPesquisa');
			$strIdAssunto = PaginaSEIExterna::getInstance()->recuperarCampo('hdnIdAssunto');
			$strDescricaoAssunto = PaginaSEIExterna::getInstance()->recuperarCampo('txtAssunto');
			$strIdUnidade = PaginaSEIExterna::getInstance()->recuperarCampo('hdnIdUnidade');
			$strDescricaoUnidade = PaginaSEIExterna::getInstance()->recuperarCampo('txtUnidade');
			$strProtocoloPesquisa = PaginaSEIExterna::getInstance()->recuperarCampo('txtProtocoloPesquisa');
			$numIdTipoProcedimento = PaginaSEIExterna::getInstance()->recuperarCampo('selTipoProcedimentoPesquisa','null');
			$numIdSerie = PaginaSEIExterna::getInstance()->recuperarCampo('selSeriePesquisa','null');
			$strNumeroDocumentoPesquisa = PaginaSEIExterna::getInstance()->recuperarCampo('txtNumeroDocumentoPesquisa');
			$strStaData = PaginaSEIExterna::getInstance()->recuperarCampo('rdoData');
			$strDataInicio = PaginaSEIExterna::getInstance()->recuperarCampo('txtDataInicio');
			$strDataFim = PaginaSEIExterna::getInstance()->recuperarCampo('txtDataFim');
			$strSiglaUsuario1 = PaginaSEIExterna::getInstance()->recuperarCampo('txtSiglaUsuario1');
			$strSiglaUsuario2 = PaginaSEIExterna::getInstance()->recuperarCampo('txtSiglaUsuario2');
			$strSiglaUsuario3 = PaginaSEIExterna::getInstance()->recuperarCampo('txtSiglaUsuario3');
			$strSiglaUsuario4 = PaginaSEIExterna::getInstance()->recuperarCampo('txtSiglaUsuario4');
			$strUsuarios = PaginaSEIExterna::getInstance()->recuperarCampo('hdnSiglasUsuarios');
			$strParticipanteSolr = '';
			
			//Opção de Auto Completar Interressado
			if(!$bolAutocompletarInterressado){
				
				if(!InfraString::isBolVazia($strNomeParticipante)){
					$strParticipanteSolr = MdPesqPesquisaUtil::buscaParticipantes($strNomeParticipante);
				}
				
			}
			
		

			$strDisplayAvancado = 'block';
			$bolPreencheuAvancado = false;
			if (($strSinProcessos=='P' || $strSinDocumentosGerados=='G' || $strSinDocumentosRecebidos=='R') &&
					!InfraString::isBolVazia($strIdParticipante) ||
					!InfraString::isBolVazia($strParticipanteSolr) ||
					!InfraString::isBolVazia($strIdAssinante) ||
					!InfraString::isBolVazia($strDescricaoPesquisa) ||
					!InfraString::isBolVazia($strObservacaoPesquisa) ||
					!InfraString::isBolVazia($strIdAssunto) ||
					!InfraString::isBolVazia($strIdUnidade) ||
					!InfraString::isBolVazia($strProtocoloPesquisa) ||
					!InfraString::isBolVazia($numIdTipoProcedimento) ||
					!InfraString::isBolVazia($numIdSerie) ||
					!InfraString::isBolVazia($strNumeroDocumentoPesquisa) ||
					!InfraString::isBolVazia($strDataInicio) ||
					!InfraString::isBolVazia($strDataFim) ||
					!InfraString::isBolVazia(str_replace(',','',$strUsuarios))){

				//$strDisplayAvancado = 'none';
				$bolPreencheuAvancado = true;
			}

			$q = PaginaSEIExterna::getInstance()->recuperarCampo('q');

			$inicio = intval($_REQUEST["inicio"]);

			$strResultado = '';
				
			if (isset($_POST['sbmPesquisar']) || ($_GET['acao_origem_externa'] == "protocolo_pesquisar_paginado")){
					
				if(md5($_POST['txtCaptcha']) != $_POST['hdnCaptchaMd5'] && $_GET['hash'] !=  $_POST['hdnCaptchaMd5'] && $bolCaptcha == true){
					PaginaSEIExterna::getInstance()->setStrMensagem('Código de confirmação inválido.');
				}else{
					//preencheu palavra de busca ou alguma opção avançada
					if (!InfraString::isBolVazia($q) || $bolPreencheuAvancado) {

							try{
								$strResultado = MdPesqBuscaProtocoloExterno::executar($q, $strDescricaoPesquisa, $strObservacaoPesquisa, $inicio, 100, $strParticipanteSolr,$md5Captcha);
							}catch(Exception $e){
								LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
								throw new InfraException('Erro realizando pesquisa.',$e);
							}

							
					}

				

// 					if(strpos($strResultado, 'sem-resultado')){
							
// 							$strResultado = '';
// 					}


				}


			}



			break;

		default:
			throw new InfraException("Ação '".$_GET['acao']."' não reconhecida.");
	}

	$strItensSelTipoProcedimento 	= TipoProcedimentoINT::montarSelectNome('null','&nbsp;',$numIdTipoProcedimento);
	$strItensSelSerie 						= SerieINT::montarSelectNomeRI0802('null','&nbsp;',$numIdSerie);

	$strLinkAjaxContatos              = SessaoSEIExterna::getInstance()->assinarLink('md_pesq_controlador_ajax_externo.php?acao_ajax_externo=contato_auto_completar_contexto_pesquisa&id_orgao_acesso_externo=0');
	$strLinkAjaxUnidade               = SessaoSEIExterna::getInstance()->assinarLink('md_pesq_controlador_ajax_externo.php?acao_ajax_externo=unidade_auto_completar_todas&id_orgao_acesso_externo=0');

	$strLinkAjuda = PaginaSEIExterna::getInstance()->formatarXHTML(SessaoSEIExterna::getInstance()->assinarLink('md_pesq_ajuda_exibir_externo.php?acao_externa=pesquisa_solr_ajuda_externa&id_orgao_acesso_externo=0'));

	if ($strStaData=='0'){
		$strDisplayPeriodoExplicito = $strDisplayAvancado;
	}else{
		$strDisplayPeriodoExplicito = 'none';
	}


	
	

}catch(Exception $e){
	PaginaSEIExterna::getInstance()->processarExcecao($e);
}
PaginaSEIExterna::getInstance()->montarDocType();
PaginaSEIExterna::getInstance()->abrirHtml();
PaginaSEIExterna::getInstance()->abrirHead();
PaginaSEIExterna::getInstance()->montarMeta();
PaginaSEIExterna::getInstance()->montarTitle(':: '.PaginaSEIExterna::getInstance()->getStrNomeSistema().' - '.$strTitulo.' ::');
PaginaSEIExterna::getInstance()->montarStyle();
PaginaSEIExterna::getInstance()->abrirStyle();
?>

#lblPalavrasPesquisa{position:absolute;left:0%;top:4%;width:20%;} 
#q{position:absolute;left:21%;top:1%;width:60%;} 
#ancAjuda{position:absolute;left:82%;top:%;} 
#sbmPesquisar {position:absolute;left:86%;top:5%; width:10%;}
#lnkAvancado {position:absolute;left:96%;top:5%;display:none;}

#lblPesquisarEm {position:absolute;left:0%;top:17%;width:20%;}
#divSinProcessos {position:absolute;left:21%;top:15%;}
#divSinDocumentosGerados {position:absolute;left:38%;top:15%;}
#divSinDocumentosRecebidos {position:absolute;left:61%;top:15%;}

#lblParticipante {position:absolute;left:0%;top:28%;width:20%;}
#txtParticipante {position:absolute;left:21%;top:27%;width:60%;}



#lblUnidade {position:absolute;left:0%;top:40%;width:20%;} 
#txtUnidade{position:absolute;left:21%;top:39%;width:60%;} 
#lblProtocoloPesquisa{position:absolute;left:0%;top:50%;width:20%;} 
#txtProtocoloPesquisa{position:absolute;left:21%;top:35%;width:20%;}
#lblProtocoloPesquisaComplemento {position:absolute;left:42%;top:14%;width:25%;} 
#lblAssinante {position:absolute;left:0%;top:18%;width:20%;} 
#txtAssinante {position:absolute;left:21%;top:17%;width:60%;} 
#lblDescricaoPesquisa {position:absolute;left:0%;top:26%;width:20%;} 
#txtDescricaoPesquisa {position:absolute;left:21%;top:25%;width:60%;} 
#ancAjudaDescricao{position:absolute;left:82%;top:25%;} 
#lblObservacaoPesquisa {position:absolute;left:0%;top:34%;width:20%;}
#txtObservacaoPesquisa {position:absolute;left:21%;top:33%;width:60%;}
#ancAjudaObservacao {position:absolute;left:82%;top:33%;} 
#lblAssunto {position:absolute;left:0%;top:42%;width:20%;} 
#txtAssunto {position:absolute;left:21%;top:41%;width:60%;} 
#imgPesquisarAssuntos {position:absolute;top:41%;left:82%;} 
#lblTipoProcedimentoPesquisa {position:absolute;left:0%;top:52%;width:20%;}
#selTipoProcedimentoPesquisa {position:absolute;left:21%;top:51%;width:60.5%;} 
#lblSeriePesquisa {position:absolute;left:0%;top:64%;width:20%;} 
#selSeriePesquisa {position:absolute;left:21%;top:63%;width:60.5%;}

#lblNumeroDocumentoPesquisa
{position:absolute;left:0%;top:76%;width:20%;}
#txtNumeroDocumentoPesquisa
{position:absolute;left:21%;top:75%;width:20%;} #lblData
{position:absolute;left:0%;top:76%;width:20%;} #divOptPeriodoExplicito
{position:absolute;left:21%;top:75%;} #divOptPeriodo30
{position:absolute;left:40%;top:75%;} #divOptPeriodo60
{position:absolute;left:55%;top:75%;} #txtDataInicio
{position:absolute;left:21%;top:0%;width:9%;} #imgDataInicio
{position:absolute;left:31%;top:10%;} #lblDataE
{position:absolute;left:33%;top:10%;width:1%;} #txtDataFim
{position:absolute;left:35%;top:0%;width:9%;} #imgDataFim
{position:absolute;left:45%;top:10%;} #lblSiglaUsuario
{position:absolute;left:0%;top:0%;width:20%;} #txtSiglaUsuario1
{position:absolute;left:21%;top:0%;width:9%;} #txtSiglaUsuario2
{position:absolute;left:31%;top:0%;width:9%;} #txtSiglaUsuario3
{position:absolute;left:41%;top:0%;width:9%;} #txtSiglaUsuario4
{position:absolute;left:51%;top:0%;width:9%;} 

#divAvancado {display: <?=$strDisplayAvancado?>;} 
#divPeriodoExplicito {display:<?=$strDisplayPeriodoExplicito?>;} 
#divUsuario {display:<?=$strDisplayAvancado?>;} 
#lnkAvancado{ border-bottom: 1px solid transparent; color: #0000b0;text-decoration: none; } 
.sugestao{ font-size: 1.2em; } 
div#conteudo > div.barra { border-bottom: .1em solid #909090; font-size: 1.2em; margin:0 0 .5em 0; padding: 0 0 .5em 0; text-align: right; } 
div#conteudo > div.paginas { border-top: .1em solid #909090; margin: 0 0 5em; padding:.5em 0 0 0; text-align: center; font-size: 1.2em; } 
div#conteudo > div.sem-resultado { font-size:1.2em; margin: .5em 0 0 0; } 
div#conteudo table { border-collapse: collapse; border-spacing: 0px; } 
div#conteudo > table { margin: 0 0 .5em; width: 100%; } 
table.resultado td {background: #f0f0f0; padding: .3em .5em; } 
div#conteudo > table > tbody > tr:first-child > td { background: #e0e0e0; } 
tr.resTituloRegistro td {background: #e0e0e0; } 
div#conteudo a.protocoloAberto, div#conteudo a.protocoloNormal{ font-size:1.1em !important; } 
div#conteudo a.protocoloAberto:hover, div#conteudo a.protocoloNormal:hover{text-decoration:underline !important; } 
div#conteudo td.metatag > table{ border-collapse: collapse; margin: 0px auto; white-space: nowrap; }

div#conteudo td.metatag > table { text-align: left; width:75%; }

div#conteudo td.metatag > table > tbody > tr > td { color: #333333; font-size: .9em; padding: 0 2em; width:30%; } 
div#conteudo td.metatag > table > tbody > tr > td:first-child { width:45%; } 
div#conteudo td.metatag > table > tbody > tr > td > b { color: #006600; font-weight:normal; } 
span.pequeno { font-size: .9em; } 
div#mensagem { background:#e0e0e0; border-color: #c0c0c0; border-style: solid; border-width: .1em; margin: 4em auto 0; padding: 2em; } 
div#mensagem > span.pequeno { color:#909090; font-size: .9em; } 
td.resTituloEsquerda img.arvore { margin:0px 5px -3px 0px; } 
td.resTituloDireita { text-align:right; width:20%; }

div.paginas, div.paginas * { font-size: 12px; } div.paginas b {font-weight: bold; } 
div.paginas a { border-bottom: 1px solid transparent; color: #000080; text-decoration: none; } 
div.paginas a:hover { border-bottom: 1px solid #000000; color: #800000; }
td.resSnippet b { font-weight:bold; } 
#divInfraAreaTabela tr.infraTrClara td {padding:.3em;} 
#divInfraAreaTabela table.infraTable {border-spacing:0;} 

<? if($bolCaptcha) { ?>
#sbmPesquisar {position:absolute;left:86%;top:42%;width:10%;font-size: 1.2em}
#sbmLimpar {position:absolute;left:86%;top:52%; width:10%;font-size: 1.2em} 
#lblCodigo {position:absolute;left:86%;top:8%;width:10%;} 
#lblCaptcha {position:absolute;left:86%;top:0%;}
#txtCaptcha{position:absolute;left:86%;top:18%;width:10%;height:18%;font-size:3em;}
<?}else { ?>
#sbmPesquisar {position:absolute;left:86%;top:10%;width:10%;font-size: 1.2em}
#sbmLimpar {position:absolute;left:86%;top:70%; width:10%;font-size: 1.2em}  
<?} ?>

<?
PaginaSEIExterna::getInstance()->fecharStyle();

PaginaSEIExterna::getInstance()->montarJavaScript();
PaginaSEIExterna::getInstance()->adicionarJavaScript('solr/js/sistema.js');
PaginaSEIExterna::getInstance()->abrirJavaScript();
?>


var objAutoCompletarInteressadoRI1225 = null;
var objAutoCompletarUsuario = null;
var objAutoCompletarAssuntoRI1223 = null;
var objAutoCompletarUnidade = null;



function inicializar(){


  infraOcultarMenuSistemaEsquema();
  
  <?if($bolAutocompletarInterressado) {?>
  
  	//Interessado/Remetente
  	objAutoCompletarInteressadoRI1225 = new infraAjaxAutoCompletar('hdnIdParticipante','txtParticipante','<?=$strLinkAjaxContatos?>');
  	//objAutoCompletarInteressadoRI1225.maiusculas = true;
  	//objAutoCompletarInteressadoRI1225.mostrarAviso = true;
  	//objAutoCompletarInteressadoRI1225.tempoAviso = 1000;
  	//objAutoCompletarInteressadoRI1225.tamanhoMinimo = 3;
  	objAutoCompletarInteressadoRI1225.limparCampo = true;
  	//objAutoCompletarInteressadoRI1225.bolExecucaoAutomatica = false;
  
  

  	objAutoCompletarInteressadoRI1225.prepararExecucao = function(){
    	return 'palavras_pesquisa='+document.getElementById('txtParticipante').value;
  	};
  	objAutoCompletarInteressadoRI1225.selecionar('<?=$strIdParticipante;?>','<?=PaginaSEI::getInstance()->formatarParametrosJavascript($strNomeParticipante)?>');

  <?}?>

  //Unidades
  objAutoCompletarUnidade = new infraAjaxAutoCompletar('hdnIdUnidade','txtUnidade','<?=$strLinkAjaxUnidade?>');
  
  
  objAutoCompletarUnidade.limparCampo = true;
  objAutoCompletarUnidade.prepararExecucao = function(){
    return 'palavras_pesquisa='+document.getElementById('txtUnidade').value;
  };
 	objAutoCompletarUnidade.selecionar('<?=$strIdUnidade;?>','<?=PaginaSEIExterna::getInstance()->formatarParametrosJavascript($strDescricaoUnidade)?>');
 	
  document.getElementById('txtProtocoloPesquisa').focus();
  
  
  //remover a string null dos combos
  document.getElementById('selTipoProcedimentoPesquisa').options[0].value='';
  document.getElementById('selSeriePesquisa').options[0].value='';
  
  infraProcessarResize();
  
  
  <? if ($strLinkVisualizarSigilosoPublicado != ''){ ?>
    infraAbrirJanela('<?=$strLinkVisualizarSigilosoPublicado?>','janelaSigilosoPublicado',750,550,'location=0,status=1,resizable=1,scrollbars=1',false);
  <? } ?>
  
  
  sistemaInicializar();


}


function tratarPeriodo(valor){
  if (valor=='0'){
    document.getElementById('divPeriodoExplicito').style.display='block';
    document.getElementById('txtDataInicio').value='';
    document.getElementById('txtDataFim').value='';
  }else if (valor =='30'){
    document.getElementById('divPeriodoExplicito').style.display='none';
    document.getElementById('txtDataInicio').value='<?php echo ProtocoloINT::calcularDataInicial(30); ?>';
    document.getElementById('txtDataFim').value='<?php echo date('d/m/Y'); ?>';
  }else if (valor =='60'){
    document.getElementById('divPeriodoExplicito').style.display='none';
    document.getElementById('txtDataInicio').value='<?php echo ProtocoloINT::calcularDataInicial(60); ?>';
    document.getElementById('txtDataFim').value='<?php echo date('d/m/Y'); ?>';
  }
}

function sugerirUsuario(obj){
  if (infraTrim(obj.value)==''){
    obj.value = '<?=SessaoSEIExterna::getInstance()->getStrSiglaUsuario()?>';
  }
}



function obterUsuarios(){
  var objHdnUsuarios = document.getElementById('hdnSiglasUsuarios');
  objHdnUsuarios.value = '';
  
  if (document.getElementById('txtSiglaUsuario1').value != ''){
  	if (objHdnUsuarios.value == ''){
			objHdnUsuarios.value += infraTrim(document.getElementById('txtSiglaUsuario1').value);
		}else {
		  objHdnUsuarios.value += ',' + infraTrim(document.getElementById('txtSiglaUsuario1').value);
		}  
  }
  if (document.getElementById('txtSiglaUsuario2').value != ''){
  	if (objHdnUsuarios.value == ''){
			objHdnUsuarios.value += infraTrim(document.getElementById('txtSiglaUsuario2').value);
		}else {
		  objHdnUsuarios.value += ',' + infraTrim(document.getElementById('txtSiglaUsuario2').value);
		}  
  }
  if (document.getElementById('txtSiglaUsuario3').value != ''){
  	if (objHdnUsuarios.value == ''){
			objHdnUsuarios.value += infraTrim(document.getElementById('txtSiglaUsuario3').value);
		}else {
		  objHdnUsuarios.value += ',' + infraTrim(document.getElementById('txtSiglaUsuario3').value);
		}  
  }
  if (document.getElementById('txtSiglaUsuario4').value != ''){
  	if (objHdnUsuarios.value == ''){
			objHdnUsuarios.value += infraTrim(document.getElementById('txtSiglaUsuario4').value);
		}else {
		  objHdnUsuarios.value += ',' + infraTrim(document.getElementById('txtSiglaUsuario4').value);
		}  
  }
}








function onSubmitForm(){
  
  if (!document.getElementById('chkSinProcessos').checked && !document.getElementById('chkSinDocumentosGerados').checked && !document.getElementById('chkSinDocumentosRecebidos').checked){
    alert('Selecione pelo menos uma das opções de pesquisa avançada: Processos, Documentos Gerados ou Documento Recebidos');
    return false;
  }
  
	limpaFields();
    return partialFields();

}

function exibirAvancado(){
 
  if (document.getElementById('divAvancado').style.display=='none'){
    document.getElementById('divAvancado').style.display = 'block';
    
    if (document.getElementById('optPeriodoExplicito').checked){
      document.getElementById('divPeriodoExplicito').style.display='block';
    }else{
      document.getElementById('divPeriodoExplicito').style.display='none';
    }
    document.getElementById('divUsuario').style.display = 'block';
    
  }else{
    document.getElementById('divAvancado').style.display = 'none';
    document.getElementById('divPeriodoExplicito').style.display='none';
    document.getElementById('divUsuario').style.display='none';
    document.getElementById('txtProtocoloPesquisa').focus();
  }
  
  infraProcessarResize();
}

<?
PaginaSEIExterna::getInstance()->fecharJavaScript();
PaginaSEIExterna::getInstance()->fecharHead();
PaginaSEIExterna::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
 <form id="seiSearch" name="seiSearch" method="post" onsubmit="return onSubmitForm();" action="<?=PaginaSEIExterna::getInstance()->formatarXHTML(SessaoSEIExterna::getInstance()->assinarLink('md_pesq_processo_pesquisar.php?acao_externa='.$_GET['acao_externa'].'&acao_origem_externa='.$_GET['acao_externa'].$strParametros))?>">
	<br />
	<br />
	
	<div id="divGeral" class="infraAreaDados" style="height: 3.2em; width: 99%; overflow: visible;">
		 <label id="lblProtocoloPesquisa" for="txtProtocoloPesquisa" accesskey="" class="infraLabelOpcional">Nº do Processo ou Documento:</label> 
    	 <input type="text" id="txtProtocoloPesquisa" name="txtProtocoloPesquisa" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strProtocoloPesquisa);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
		
		<?if($bolCaptcha) { ?>
			<label id="lblCaptcha" accesskey="" class="infraLabelObrigatorio">
			<img src="/infra_js/infra_gerar_captcha.php?codetorandom=<?=$strCodigoParaGeracaoCaptcha;?>" alt="Não foi possível carregar imagem de confirmação" /> </label> 
		<?} else {?>
			<input type="submit" id="sbmPesquisar"name="sbmPesquisar" value="Pesquisar" class="infraButton" />
			<input type="submit"  id="sbmLimpar"name="sbmLimpar" value="Limpar Campos" class="infraButton" />  
		<?}?>
		
		
	</div>
	<div id="divAvancado" class="infraAreaDados" style="height: 20em; width: 99%;">
		<?if($bolCaptcha) { ?>
			<label id="lblCodigo" for="txtCaptcha" accesskey="" class="infraLabelOpcional">Digite o código acima:</label> 
			<input type="text" id="txtCaptcha" name="txtCaptcha" class="infraText" maxlength="4" value="" /> 
			<input type="submit" id="sbmPesquisar"name="sbmPesquisar" value="Pesquisar" class="infraButton" />
			<input type="submit"  id="sbmLimpar"name="sbmLimpar" value="Limpar Campos" class="infraButton" />   
		<?}?>
		
		
		<label id="lblPalavrasPesquisa" for="q" accesskey="" class="infraLabelOpcional">Pesquisa Livre:</label> 
		<input type="text" id="q" name="q" class="infraText" value="<?=str_replace('\\','',str_replace('"','&quot;',PaginaSEIExterna::tratarHTML($strPalavrasPesquisa)))?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
		<a id="ancAjuda" href="<?=$strLinkAjuda?>" target="janAjuda" title="Ajuda para Pesquisa" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>">
			<img src="<?=PaginaSEIExterna::getInstance()->getDiretorioImagensGlobal()?>/ajuda.gif" class="infraImg" /> 
		</a>
		
		<label id="lblPesquisarEm" accesskey="" class="infraLabelObrigatorio">Pesquisar em:</label>
		
		<div id="divSinProcessos" class="infraDivCheckbox">
			<input type="checkbox" id="chkSinProcessos" name="chkSinProcessos" value="P" class="infraCheckbox" <?=($strSinProcessos=='P'?'checked="checked"':'')?> tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
			<label id="lblSinProcessos" for="chkSinProcessos" accesskey="" class="infraLabelCheckbox">Processos</label>
		</div>
		<div id="divSinDocumentosGerados" class="infraDivCheckbox" title="Documento nato do Sei">
			<input type="checkbox" id="chkSinDocumentosGerados" name="chkSinDocumentosGerados" value="G" class="infraCheckbox" <?=($strSinDocumentosGerados=='G'?'checked="checked"':'')?> tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
			<label id="lblSinDocumentosGerados" for="chkSinDocumentosGerados" accesskey="" class="infraLabelCheckbox">Documentos Gerados</label>
		</div>

		<div id="divSinDocumentosRecebidos" class="infraDivCheckbox" title="Arquivo anexo">
			<input type="checkbox" id="chkSinDocumentosRecebidos" name="chkSinDocumentosRecebidos" value="R" class="infraCheckbox"  <?=($strSinDocumentosRecebidos=='R'?'checked="checked"':'')?> tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
			<label id="lblSinDocumentosRecebidos" for="chkSinDocumentosRecebidos" accesskey="" class="infraLabelCheckbox">Documentos Externos</label>
		</div>
		
		
		
		 <label id="lblParticipante" for="txtParticipante" accesskey=""  class="infraLabelOpcional">Interessado / Remetente:</label>
    	 <input type="text" id="txtParticipante" name="txtParticipante" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strNomeParticipante);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
   		 <input type="hidden" id="hdnIdParticipante" name="hdnIdParticipante" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strIdParticipante)?>" />
    
   
  	<label id="lblUnidade" for="txtUnidade" class="infraLabelOpcional">Unidade Geradora:</label>
  	<input type="text" id="txtUnidade" name="txtUnidade" class="infraText" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" value="<?=PaginaSEIExterna::tratarHTML($strDescricaoUnidade)?>" />
  	<input type="hidden" id="hdnIdUnidade" name="hdnIdUnidade" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strIdUnidade)?>" />

    <label id="lblTipoProcedimentoPesquisa" for="selTipoProcedimentoPesquisa" accesskey="" class="infraLabelOpcional">Tipo do Processo:</label>
    <select id="selTipoProcedimentoPesquisa" name="selTipoProcedimentoPesquisa" class="infraSelect" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" >
    <?=$strItensSelTipoProcedimento?>
    </select>
    
    <label id="lblSeriePesquisa" for="selSeriePesquisa" accesskey="" class="infraLabelOpcional">Tipo do Documento:</label>
    <select id="selSeriePesquisa" name="selSeriePesquisa" class="infraSelect" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" >
    <?=$strItensSelSerie?>
    </select>
    
    <label id="lblData" class="infraLabelOpcional">Data do Processo / Documento:</label>
    
    <div id="divOptPeriodoExplicito" class="infraDivRadio">
  	<input type="radio" name="rdoData" id="optPeriodoExplicito" value="0" onclick="tratarPeriodo(this.value);" <?=($strStaData=='0'?'checked="checked"':'')?> class="infraRadio"/>
    <label id="lblPeriodoExplicito" accesskey="" for="optPeriodoExplicito" class="infraLabelRadio" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>">Período explícito</label>
    </div>
  
    <div id="divOptPeriodo30" class="infraDivRadio">  
  	<input type="radio" name="rdoData" id="optPeriodo30" value="30" onclick="tratarPeriodo(this.value);" <?=($strStaData=='30'?'checked="checked"':'')?> class="infraRadio"/>
    <label id="lblPeriodo30" accesskey="" for="optPeriodo30" class="infraLabelRadio" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>">30 dias</label>
    </div>
    
    <div id="divOptPeriodo60" class="infraDivRadio">
  	<input type="radio" name="rdoData" id="optPeriodo60" value="60" onclick="tratarPeriodo(this.value);" <?=($strStaData=='60'?'checked="checked"':'')?> class="infraRadio"/>
    <label id="lblPeriodo60" accesskey="" for="optPeriodo60" class="infraLabelRadio" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>">60 dias</label>
    </div>
  </div>

  <div id="divPeriodoExplicito" class="infraAreaDados" style="height:2.5em;width:99%;top:50%;margin-top:-20px">
    <input type="text" id="txtDataInicio" name="txtDataInicio" onkeypress="return infraMascaraData(this, event)" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strDataInicio);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <img id="imgDataInicio" src="/infra_css/imagens/calendario.gif" onclick="infraCalendario('txtDataInicio',this);" alt="Selecionar Data Inicial" title="Selecionar Data Inicial" class="infraImg" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />	
    <label id="lblDataE" for="txtDataE" accesskey="" class="infraLabelOpcional">&nbsp;e&nbsp;</label>
    <input type="text" id="txtDataFim" name="txtDataFim" onkeypress="return infraMascaraData(this, event)" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strDataFim);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <img id="imgDataFim" src="/infra_css/imagens/calendario.gif" onclick="infraCalendario('txtDataFim',this);" alt="Selecionar Data Final" title="Selecionar Data Final" class="infraImg" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />	      	 
  </div>
 

  	<input type="hidden" id="txtNumeroDocumentoPesquisa" name="txtNumeroDocumentoPesquisa" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strNumeroDocumentoPesquisa);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <input type="hidden" id="txtAssinante" name="txtAssinante" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strNomeAssinante);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <input type="hidden" id="hdnIdAssinante" name="hdnIdAssinante" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strIdAssinante)?>" />
    <input type="hidden" id="txtDescricaoPesquisa" name="txtDescricaoPesquisa" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strDescricaoPesquisa);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <input type="hidden" id="txtAssunto" name="txtAssunto" class="infraText" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" value="<?=PaginaSEIExterna::tratarHTML($strDescricaoAssunto)?>" />
    <input type="hidden" id="hdnIdAssunto" name="hdnIdAssunto" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strIdAssunto)?>" />
    <input type="hidden" id="txtSiglaUsuario1" name="txtSiglaUsuario1" onfocus="sugerirUsuario(this);" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strSiglaUsuario1);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <input type="hidden" id="txtSiglaUsuario2" name="txtSiglaUsuario2" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strSiglaUsuario2);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <input type="hidden" id="txtSiglaUsuario3" name="txtSiglaUsuario3" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strSiglaUsuario3);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <input type="hidden" id="txtSiglaUsuario4" name="txtSiglaUsuario4" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strSiglaUsuario4);?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    <input type="hidden" id="hdnSiglasUsuarios" name="hdnSiglasUsuarios" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strUsuarios)?>" />
    <input type="hidden" id="hdnSiglasUsuarios" name="hdnSiglasUsuarios" class="infraText" value="<?=PaginaSEIExterna::tratarHTML($strUsuarios)?>" /> 
    <?if($bolCaptcha) { ?>
    	<input type="hidden" id="hdnCaptchaMd5" name="hdnCaptchaMd5" class="infraText" value="<?=md5(InfraCaptcha::gerar(PaginaSEIExterna::tratarHTML($strCodigoParaGeracaoCaptcha)));?>" />
  	<?} ?>
  	<input id="partialfields" name="partialfields" type="hidden" value="" />
  	<input id="requiredfields" name="requiredfields" type="hidden" value="" />
 	<input id="as_q" name="as_q" type="hidden" value="" />

  	<input type="hidden" id="hdnFlagPesquisa" name="hdnFlagPesquisa" value="1" />
<?

if($strResultado != ''){
	echo '<div id="conteudo" style="width:99%;" class="infraAreaTabela">';
	echo $strResultado;
}
	 
	  	

  
  PaginaSEIExterna::getInstance()->montarAreaDebug();
?> 
  </form>
<?  
PaginaSEIExterna::getInstance()->fecharBody();
PaginaSEIExterna::getInstance()->fecharHtml();
?>