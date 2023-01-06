<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4ª REGIÃO
*
* 29/11/2016 - criado por alex
*
* Versão do Gerador de Código: 1.39.0
*/

try {
  require_once dirname(__FILE__).'/../../SEI.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  //InfraDebug::getInstance()->setBolLigado(false);
  //InfraDebug::getInstance()->setBolDebugInfra(true);
  //InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoSEI::getInstance()->validarLink();
  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  switch($_GET['acao']){
 

    case 'md_pesq_parametro_listar':
      $strTitulo = 'Parâmetros Pesquisa Pública';
      break;
      
    case 'md_pesq_parametro_alterar':
    
      $strTitulo = 'Parâmetros Pesquisa Pública';
      if(isset($_POST['btnSalvar'])) {
      	$arrParametroPesquisaDTO = array(
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkCapcthaPesquisa'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkCapcthaGerarPdf'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkListaAndamentoProcessoPublico'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_PROCESSO_RESTRITO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkProcessoRestrito'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkMetaDadosProcessoRestrito'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkListaAndamentoProcessoRestrito'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO , 'Valor' => trim($_POST['txtDescricaoProcessoAcessoRestrito'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_DOCUMENTO_PROCESSO_PUBLICO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkDocumentoProcessoPublico'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkListaDocumentoProcessoPublico'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkListaDocumentoProcessoRestrito'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkAutoCompletarInteressado'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO , 'Valor' => PaginaSEI::getInstance()->getCheckbox($_POST['chkMenuUsuarioExterno'])),
      			array('Nome' => MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA , 'Valor' => trim($_POST['txtChaveCriptografia'])),
      	
      	
      	);
      		
      	$arrObjParametroPesquisaDTO = InfraArray::gerarArrInfraDTOMultiAtributos('MdPesqParametroPesquisaDTO', $arrParametroPesquisaDTO);
      		
      	$objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
      	$objParametroPesquisaRN->alterarParametros($arrObjParametroPesquisaDTO);
      		
      	PaginaSEI::getInstance()->adicionarMensagem("Parametros da Pesquisa Pública salva com sucesso!",PaginaSEI::$TIPO_MSG_AVISO);
      }
     

  	  break;
    	
    	

    default:
      throw new InfraException("Ação '".$_GET['acao']."' não reconhecida.");
  }

  $arrComandos = array();
 
   $arrComandos[] = '<button type="submit" accesskey="S" id="btnSalvar" name="btnSalvar" value="Salvar"  class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
  

  $objParametroPesquisaDTO = new MdPesqParametroPesquisaDTO();
  $objParametroPesquisaDTO->retStrNome();
  $objParametroPesquisaDTO->retStrValor();


  $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
  $arrObjParametroPesquisaDTO = $objParametroPesquisaRN->listar($objParametroPesquisaDTO);
 
  $arrParametroPesquisaDTO = InfraArray::converterArrInfraDTO($arrObjParametroPesquisaDTO,'Valor','Nome');
  

}catch(Exception $e){
  PaginaSEI::getInstance()->processarExcecao($e);
} 

PaginaSEI::getInstance()->montarDocType();
PaginaSEI::getInstance()->abrirHtml();
PaginaSEI::getInstance()->abrirHead();
PaginaSEI::getInstance()->montarMeta();
PaginaSEI::getInstance()->montarTitle(PaginaSEI::getInstance()->getStrNomeSistema().' - '.$strTitulo);
PaginaSEI::getInstance()->montarStyle();
PaginaSEI::getInstance()->abrirStyle();





PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>

function inicializar(){
 
}

function validarCadastro() {

  if (infraTrim(document.getElementById('txtChaveCriptografia').value)=='') {
    alert('Informe a Chave para criptografia.');
    document.getElementById('txtChaveCriptografia').focus();
    return false;
  }
	
  return true;
}

function OnSubmitForm() {
  return validarCadastro();
}


<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
PaginaSEI::getInstance()->abrirAreaDados(null);
?>
<form id="frmParametroPesquisaLista" method="post" onsubmit="return OnSubmitForm();" action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao=md_pesq_parametro_alterar&acao_origem='.$_GET['acao'])?>">
 
  <?
  //PaginaSEI::getInstance()->montarBarraLocalizacao($strTitulo); 
  PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
  //PaginaSEI::getInstance()->montarAreaValidacao();
  ?>
 
  <h2 style='font-weight:bold;text-decoration: underline;'>Captcha</h2>
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar Captcha na pesquisa pública:</h3>
  <input id="chkCapcthaPesquisa" name="chkCapcthaPesquisa" type="checkbox" class="infraCheckBox" <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA] == 'S') ? "checked" : ""?> tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblCapcthaPesquisa" for="chkCapcthaPesquisa" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar Captcha gerar PDF:</h3>
  <input id="chkCapcthaGerarPdf" name="chkCapcthaGerarPdf" type="checkbox" class="infraCheckBox" <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF] == 'S') ? "checked" : ""?>  tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblCapcthaGerarPdf" for="chkCapcthaGerarPdf" class="infraLabelCheckBox">Sim</label>
  <hr/>
  
  <h2 style='font-weight:bold;text-decoration: underline;'>Processos</h2>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar a exibição dos Andamentos nos processos com nível de acesso global "Público":</h3>
  <input id="chkListaAndamentoProcessoPublico" name="chkListaAndamentoProcessoPublico" type="checkbox" class="infraCheckBox" <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : ""?> tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblListaAndamentoProcessoPublico" for="chkListaAndamentoProcessoPublico" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar a pesquisa em processos com nível de acesso global "Restrito":</h3>
  <input id="chkProcessoRestrito" name="chkProcessoRestrito" type="checkbox" class="infraCheckBox" <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_PROCESSO_RESTRITO] == 'S') ? "checked" : ""?>  tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblProcessoRestrito" for="chkProcessoRestrito" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar o acesso aos metadados dos Processos com nível de acesso global "Restrito"</h3>
  <input id="chkMetaDadosProcessoRestrito" name="chkMetaDadosProcessoRestrito" type="checkbox" class="infraCheckBox" <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'S') ? "checked" : ""?> tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblMetaDadosProcessoRestrito" for="chkMetaDadosProcessoRestrito" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar a exibição dos Andamentos nos processos com nível de acesso global "Restrito":</h3>
  <input id="chkListaAndamentoProcessoRestrito" name="chkListaAndamentoProcessoRestrito" type="checkbox" class="infraCheckBox"  <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO] == 'S') ? "checked" : ""?> tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblListaAndamentoProcessoRestrito" for="chkListaAndamentoProcessoRestrito" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Descrição de justificativa de restrição de acesso e orientações para meios alternativos de solicitação de acesso:</h3>
  <textarea id="txtDescricaoProcessoAcessoRestrito" name="txtDescricaoProcessoAcessoRestrito" class="infraTextarea" rows="5" style="width: 90%" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" ><?=$arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO]?></textarea>
  <hr>
  
  <h2 style='font-weight:bold;text-decoration: underline;'>Documentos</h2>
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar a pesquisa em Documentos que estão associados à processos com nível de acesso global "Público":</h3>
  <input id="chkDocumentoProcessoPublico" name="chkDocumentoProcessoPublico" type="checkbox" class="infraCheckBox" <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DOCUMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : ""?> tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblDocumentoProcessoPublico" for="chkDocumentoProcessoPublico" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar o acesso aos Documentos nos processos com nível de acesso global "Público":</h3>
  <input id="chkListaDocumentoProcessoPublico" name="chkListaDocumentoProcessoPublico" type="checkbox" class="infraCheckBox"  <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : ""?> tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblListaDocumentoProcessoPublico" for="chkListaDocumentoProcessoPublico" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar o acesso aos Documentos nos processos com nível de acesso global "Restrito":</h3>
  <input id="chkListaDocumentoProcessoRestrito" name="chkListaDocumentoProcessoRestrito" type="checkbox" class="infraCheckBox" <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO] == 'S') ? "checked" : ""?>  tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblListaDocumentoProcessoRestrito" for="chkListaDocumentoProcessoRestrito" class="infraLabelCheckBox">Sim</label>
  
  <hr/>
 
  
  <h2 style='font-weight:bold;text-decoration: underline;'>Configurações Gerais</h2>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar a função auto completar no campo "Interessado / Remetente" na página principal da Pesquisa Pública:</h3>
  <input id="chkAutoCompletarInteressado" name="chkAutoCompletarInteressado" type="checkbox" class="infraCheckBox"  <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO] == 'S') ? "checked" : ""?>   tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblAutoCompletarInteressado" for="chkAutoCompletarInteressado" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Habilitar o link da pesquisa pública no menu de usuário externo:</h3>
  <input id="chkMenuUsuarioExterno" name="chkMenuUsuarioExterno" type="checkbox" class="infraCheckBox"  <?=($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO] == 'S') ? "checked" : ""?>  tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <label id="lblMenuUsuarioExterno" for="chkMenuUsuarioExterno" class="infraLabelCheckBox">Sim</label>
  
  <h3 style='font-weight:bold; font-style: italic;'>Chave para criptografia dos links de processos e documentos:</h3>
  <input id="txtChaveCriptografia" name="txtChaveCriptografia" type="text" class="infraText" maxlength="100" style="width: 40%" value="<?=$arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA]?>" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />

  <?
  //PaginaSEI::getInstance()->montarBarraLocalizacao($strTitulo); 
  PaginaSEI::getInstance()->montarBarraComandosInferior($arrComandos);
  //PaginaSEI::getInstance()->montarAreaValidacao();
  ?>
  

</form>
<?
PaginaSEI::getInstance()->fecharAreaDados();
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
?>