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

  //Tipo Processo
  $strLinkTipoProcessoSelecao = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_procedimento_selecionar&tipo_selecao=2&id_object=objLupaTipoProcesso');
  $strLinkAjaxTipoProcesso = SessaoSEI::getInstance()->assinarLink('controlador_ajax.php?acao_ajax=md_pesq_tipo_processo_auto_completar');

  //Preparar Preenchimento Alteração
  $idMdPetTipoProcesso = '';
  $idTipoProcesso = '';
  $strTipoProcesso = '';
  $arrTipoProcesso = [];
  $optionTemplate = '<option value="%s" %s>%s</option>';
  $strCssTr='';

  switch($_GET['acao']){


    case 'md_pesq_parametro_listar':
      $strTitulo = 'Parâmetros Pesquisa Pública';
      break;

    case 'md_pesq_parametro_alterar':

      $strTitulo = 'Parâmetros Pesquisa Pública';
      if(isset($_POST['btnSalvar'])) {
        $arrHdnIdTipoProcesso = PaginaSEI::getInstance()->getArrItensTabelaDinamica($_POST['hdnIdTipoProcesso']);
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
        $arrTipoProcessoDTO = array();
        foreach($arrHdnIdTipoProcesso as $tipoProcesso) {
          $idTipoProcessoDtO = $tipoProcesso[0];


          $tipoProcessoDTO = new MdPesqTipoProcessoDTO();
          $tipoProcessoDTO->setNumId($idTipoProcessoDtO);
          $tipoProcessoDTO->setDtaInicio($_POST['txtPeriodoDe'][$idTipoProcessoDtO]);
          $tipoProcessoDTO->setDtaFim($_POST['txtPeriodoA'][$idTipoProcessoDtO]);
          $tipoProcessoDTO->setStrSinAtivo('S');
          array_push($arrTipoProcessoDTO, $tipoProcessoDTO);
        }

        $arrObjParametroPesquisaDTO = InfraArray::gerarArrInfraDTOMultiAtributos('MdPesqParametroPesquisaDTO', $arrParametroPesquisaDTO);

        $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
        $objParametroPesquisaRN->alterarParametros($arrObjParametroPesquisaDTO);


        $objPesquisaTipoProcessoRN = new MdPesqTipoProcessoRN();
        $objPesquisaTipoProcessoRN->alterarParametros($arrTipoProcessoDTO);


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

  $tipoProcessoDTO = new MdPesqTipoProcessoDTO();
  $tipoProcessoDTO->retNumId();
  $tipoProcessoDTO->retStrNome();
  $tipoProcessoDTO->retDtaInicio();
  $tipoProcessoDTO->retDtaFim();

  $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
  $arrObjParametroPesquisaDTO = $objParametroPesquisaRN->listar($objParametroPesquisaDTO);

  $arrParametroPesquisaDTO = InfraArray::converterArrInfraDTO($arrObjParametroPesquisaDTO,'Valor','Nome');

  $objPesquisaTipoProcessoRN = new MdPesqTipoProcessoRN();
  $arrTipoProcessoDTO = $objPesquisaTipoProcessoRN->listar($tipoProcessoDTO);

  foreach($arrTipoProcessoDTO as $tipoProcesso) {
    $strTipoProcesso .= sprintf($optionTemplate, $tipoProcesso->getNumId(), 'selected="selected"', $tipoProcesso->getStrNome());
  }
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
  <h3 style='font-weight:bold; font-style: italic;' id="lblTipoProcesso" for="txtTipoProcesso"
      class="infraLabelObrigatorio">Selecionar tipos de processos para acesso ao conteúdo de Documentos: </h3>
  <h3 style='font-weight:bold; color: red' id="lblTipoProcesso" for="txtTipoProcesso"
      class="infraLabelObrigatorio">* Para que o conteúdo dos documentos dos tipos de processos selecionados seja exibido é necessário habilitar parâmetro de acesso aos Documentos: </h3>

  <!--  Tipo de Processo  -->
  <div class="fieldsetClear" >
    <label style='font-weight:bold; font-style: italic;' id="lblTipoProcesso" for="txtTipoProcesso"
           class="infraLabelObrigatorio">Tipos de Processos: </label>
    <br>
    <input type="text" onchange="removerProcessoAssociado(0);" id="txtTipoProcesso" name="txtTipoProcesso"
           style="width: 40%" class="infraText InfraAutoCompletar"
           tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
    <select hidden name="selTipoProcesso" id="selTipoProcesso" size="8" multiple="multiple"
            tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>">
      <?= $strTipoProcesso; ?>
    </select>
    <table name="selTipoProcessos" id="selTipoProcessos" width="80%" class="infraTable">
      <tr>
        <th class="infraTh" width="1%" style="display:none"><?= PaginaSEI::getInstance()->getThCheck()?></th>
        <th class="infraTh">Tipo de Processo Selecionado</th>
        <th class="infraTh">Definir Período de Autuação</th>
        <th class="infraTh">Remover</th>

        <? for($i = 0;$i < count($arrTipoProcessoDTO); $i++) {
        $strCssTr = ($strCssTr=='infraTrClara')? 'infraTrEscura':'infraTrClara';?>
      <tr id="tdId<?= $arrTipoProcessoDTO[$i]->getNumId()?>" class="<?=$strCssTr?>" >
        <td align="center"><?= $arrTipoProcessoDTO[$i]->getStrNome() ?></td>
        <td align="center">
          <label id="lblPeriodoDe<?= $arrTipoProcessoDTO[$i]->getNumId()?>" for="txtPeriodoDe<?= $arrTipoProcessoDTO[$i]->getNumId()?>" accesskey="" class="infraLabelOpcional">De:</label>
          <input type="text" id="txtPeriodoDe<?= $arrTipoProcessoDTO[$i]->getNumId()?>" name="txtPeriodoDe[<?= $arrTipoProcessoDTO[$i]->getNumId()?>]" class="infraText" value="<?= $arrTipoProcessoDTO[$i]->getDtaInicio()?>" onchange="validarDatas(<?= $arrTipoProcessoDTO[$i]->getNumId()?>)" onkeypress="return infraMascaraData(this, event)" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
          <img id="imgCalPeriodoD" title="Selecionar Data Inicial" alt="Selecionar Data Inicial" src="<?=PaginaSEI::getInstance()->getDiretorioImagensGlobal()?>/calendario.gif" class="infraImg" onclick="infraCalendario('txtPeriodoDe<?= $arrTipoProcessoDTO[$i]->getNumId()?>',this);" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
          <label id="lblPeriodoA<?= $arrTipoProcessoDTO[$i]->getNumId()?>" for="txtPeriodoA<?= $arrTipoProcessoDTO[$i]->getNumId()?>" accesskey="" class="infraLabelObrigatorio">até</label>
          <input type="text" id="txtPeriodoA<?= $arrTipoProcessoDTO[$i]->getNumId()?>" name="txtPeriodoA[<?= $arrTipoProcessoDTO[$i]->getNumId()?>]" class="infraText" value="<?= $arrTipoProcessoDTO[$i]->getDtaFim()?>" onchange="validarDatas(<?= $arrTipoProcessoDTO[$i]->getNumId()?>)" onkeypress="return infraMascaraData(this, event)" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
          <img id="imgCalPeriodoA" title="Selecionar Data Final" alt="Selecionar Data Final" src="<?=PaginaSEI::getInstance()->getDiretorioImagensGlobal()?>/calendario.gif" class="infraImg" onclick="infraCalendario('txtPeriodoA<?= $arrTipoProcessoDTO[$i]->getNumId()?>',this);" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
        </td>
        <td align="center">
          <img id="imgExcluirTipoProcesso" onclick="removerProcessoAssociado(<?= $arrTipoProcessoDTO[$i]->getNumId()?>);objLupaTipoProcesso.remover();" src="/infra_css/imagens/remover.gif" alt="Remover Tipo de Processo" title="Remover Tipo de Processo" class="infraImg"/>
        </td>
      </tr>
      <? } ?>

      </tr>
    </table>
    <input type="hidden" id="hdnIdTipoProcesso" name="hdnIdTipoProcesso" value="<?php echo $idTipoProcesso ?>"/>
    <input type="hidden" id="hdnIdCriterioIntercorrentePeticionamento" name="hdnIdCriterioIntercorrentePeticionamento" value="<?php echo $IdCriterioIntercorrentePeticionamento ?>"/>
  </div>
  <!--  Fim do Tipo de Processo -->
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

<script type="text/javascript">
    //Processo
    var objLupaTipoProcesso = null;
    var objAutoCompletarTipoProcesso = null;
    var objAjaxIdNivelAcesso = null;
    var infraTr = '';

    function inicializar() {
        carregarComponenteTipoProcessoNovo();
        infraEfeitoTabelas();
    }

    function carregarComponenteTipoProcessoNovo() {
        objLupaTipoProcesso = new infraLupaSelect('selTipoProcesso', 'hdnIdTipoProcesso', '<?=$strLinkTipoProcessoSelecao?>');

        objLupaTipoProcesso.finalizarSelecao = function () {
            var options = document.getElementById('selTipoProcesso').options;
            if(options.length < 1){
                return;
            }
            for(var i = 0; i < options.length; i++){
                options[i].selected = true;
            }
            objLupaTipoProcesso.atualizar();
        };

        objAutoCompletarTipoProcesso = new infraAjaxAutoCompletar('hdnIdTipoProcesso', 'txtTipoProcesso', '<?=$strLinkAjaxTipoProcesso?>');
        objAutoCompletarTipoProcesso.limparCampo = false;
        objAutoCompletarTipoProcesso.tamanhoMinimo = 1;
        objAutoCompletarTipoProcesso.prepararExecucao = function () {
            var itensSelecionados = '';
            var options = document.getElementById('selTipoProcesso').options;

            if (options.length > 0){
                for(var i = 0; i < options.length; i++){
                    itensSelecionados += '&itens_selecionados[]=' + options[i].value;
                }
            }
            return 'palavras_pesquisa=' + document.getElementById('txtTipoProcesso').value + '&' + itensSelecionados;
        };

        objAutoCompletarTipoProcesso.processarResultado = function (id, descricao, complemento) {
            if (id!=''){
                var options = document.getElementById('selTipoProcesso').options;

                for(var i=0;i < options.length;i++){
                    if (options[i].value == id){
                        self.setTimeout('alert(\'Tipo de Processo [' + descricao + '] já consta na lista.\')',100);
                        break;
                    }
                }

                if (i==options.length){

                    for(i=0;i < options.length;i++){
                        options[i].selected = false;
                    }
                    atualizarTabela(id, descricao);
                    opt = infraSelectAdicionarOption(document.getElementById('selTipoProcesso'),descricao,id);

                    objLupaTipoProcesso.atualizar();

                    opt.selected = true;
                }

                document.getElementById('txtTipoProcesso').value = '';
                document.getElementById('txtTipoProcesso').focus();
            }
        }
        objAutoCompletarTipoProcesso.selecionar('<?=$strIdTipoProcesso?>', '<?=PaginaSEI::getInstance()->formatarParametrosJavascript(PaginaSEI::tratarHTML($strNomeRemetente));?>');
    }

    function atualizarTabela(id, descricao) {
        var tabela = document.getElementById('selTipoProcessos');

        if(infraTr === '') {
            infraTr = '<?=$strCssTr?>';
        }
        infraTr = (infraTr==='infraTrClara')? 'infraTrEscura':'infraTrClara';
        var row = tabela.insertRow();
        row.id = 'tdId'+id;
        row.className = infraTr;

        var cellProcesso = row.insertCell(0);
        var cellData = row.insertCell(1);
        var cellRemover = row.insertCell(2);

        cellProcesso.setAttribute('align','center' );
        cellData.setAttribute('align','center' );
        cellRemover.setAttribute('align','center' );

        cellProcesso.innerHTML = descricao;
        cellData.innerHTML =
            '<label id="lblPeriodoDe'+id+'" for="txtPeriodoDe'+id+'" accesskey="" class="infraLabelOpcional">De:</label>'+
            '<input type="text" id="txtPeriodoDe'+id+'" name="txtPeriodoDe['+id+']" class="infraText" onchange="validarDatas('+id+')" onkeypress="return infraMascaraData(this, event)" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />' +
            '<img id="imgCalPeriodoD" title="Selecionar Data Inicial" alt="Selecionar Data Inicial" src="<?=PaginaSEI::getInstance()->getDiretorioImagensGlobal()?>/calendario.gif" class="infraImg" onclick="infraCalendario(\'txtPeriodoDe'+id+'\',this);" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />' +
            '<label id="lblPeriodoA'+id+'" for="txtPeriodoA'+id+'" accesskey="" class="infraLabelObrigatorio">até</label>'+
            '<input type="text" id="txtPeriodoA'+id+'" name="txtPeriodoA['+id+']" class="infraText" onchange="validarDatas('+id+')" onkeypress="return infraMascaraData(this, event)" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />'+
            '<img id="imgCalPeriodoA" title="Selecionar Data Final" alt="Selecionar Data Final" src="<?=PaginaSEI::getInstance()->getDiretorioImagensGlobal()?>/calendario.gif" class="infraImg" onclick="infraCalendario(\'txtPeriodoA'+id+'\',this);" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />';
        cellRemover.innerHTML =
            '<img id="imgExcluirTipoProcesso" onclick="removerProcessoAssociado('+id+');objLupaTipoProcesso.remover();" src="/infra_css/imagens/remover.gif" alt="Remover Tipo de Processo" title="Remover Tipo de Processo" class="infraImg"/>'

    }
    function removerProcessoAssociado(remover) {
        var options = document.getElementById('selTipoProcesso').options;


        for(var i=0;i < options.length;i++) {
            options[i].selected = false;
            if(options[i].value == remover){
                options[i].selected = true;
            }

        }
        document.getElementById('tdId'+remover).remove();

        if (remover === '1') {
            objLupaTipoProcesso.remover();
        }
    }

    function validarCadastro() {
        objLupaTipoProcesso.atualizar();

        var valorHipoteseLegal = document.getElementById('hdnParametroHipoteseLegal').value;

        if (document.getElementById('selTipoProcesso').options < 1) {
            alert('Informe o Tipo de Processo.');
            return false;
        }

        //Validar Nível Acesso
        var elemsNA = document.getElementsByName("rdNivelAcesso[]");

        var validoNA = false, valorNA = 0;

        for (var i = 0; i < elemsNA.length; i++) {
            if (elemsNA[i].checked === true) {
                validoNA = true;
                valorNA = parseInt(elemsNA[i].value);
            }
        }

        if (validoNA === false) {
            alert('Informe o Nível de Acesso.');
            return false;
        }

        if (infraTrim(document.getElementById('selNivelAcesso').value) == '' && valorNA != 1) {
            alert('Informe o Nível de Acesso.');
            document.getElementById('selNivelAcesso').focus();
            return false;
        } else if (document.getElementById('selNivelAcesso').value == 'I' && valorHipoteseLegal != '0') {

            //validar hipotese legal
            if (document.getElementById('selHipoteseLegal').value == '') {
                alert('Informe a Hipótese legal padrão.');
                document.getElementById('selHipoteseLegal').focus();
                return false;
            }
        }

        if(valorNA == 2) {
            var validacaoSelNivelAcesso = false;
            $.ajax({
                url: '<?=$strUrlAjaxValidarNivelAcesso?>',
                type: 'POST',
                dataType: 'XML',
                data: $('form#frmCriterioCadastro').serialize(),
                async: false,
                success: function (r) {
                    if ($(r).find('MensagemValidacao').text()) {
                        alert($(r).find('MensagemValidacao').text());
                    } else {
                        validacaoSelNivelAcesso = true;
                    }
                },
                error: function (e) {
                    if ($(e.responseText).find('MensagemValidacao').text()) {
                        alert($(e.responseText).find('MensagemValidacao').text());
                    }
                }
            });

            if(validacaoSelNivelAcesso == false ){
                return validacaoSelNivelAcesso;
            }
        }

        return true;
    }

    function OnSubmitForm() {
        return validarCadastro();
    }

    function validarDatas(id) {
        var dataInicio = 'txtPeriodoDe'+id;
        var dataFim = 'txtPeriodoA'+id;
        if (infraCompararDatas(document.getElementById(dataInicio).value,document.getElementById(dataFim).value) < 0){
            alert('Intervalo de datas inválido.');
            document.getElementById(dataInicio).focus();
            return false;
        }
    }
    function getPercentTopStyle(element) {
        var parent = element.parentNode,
            computedStyle = getComputedStyle(element),
            value;

        parent.style.display = 'none';
        value = computedStyle.getPropertyValue('top');
        parent.style.removeProperty('display');

        if (value != '') {
            valor = value.replace('%', '');
            return parseInt(valor);
        }

        return false;
    }
</script>
