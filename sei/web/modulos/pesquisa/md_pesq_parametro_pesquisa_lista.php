<?
/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECON�MICA - CADE
 * 29/11/2016
 * Vers�o do Gerador de C�digo: 1.39.0
 *
 */

try {
    require_once dirname(__FILE__) . '/../../SEI.php';

    session_start();

//	InfraDebug::getInstance()->setBolLigado(false);
//	InfraDebug::getInstance()->setBolDebugInfra(true);
//	InfraDebug::getInstance()->limpar();

	SessaoSEI::getInstance()->validarLink();
	SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

	switch ($_GET['acao']) {

        case 'md_pesq_parametro_listar':
            $strTitulo = 'Par�metros de Pesquisa P�blica';
            break;

        case 'md_pesq_parametro_alterar':
            $strTitulo = 'Par�metros de Pesquisa P�blica';
            if (isset($_POST['btnSalvar'])) {

                if(isset($_POST['txtDataCorte']) && !empty($_POST['txtDataCorte']) && implode('-', array_reverse(explode('/', trim($_POST['txtDataCorte'])))) > date('Y-m-d')){

                    PaginaSEI::getInstance()->adicionarMensagem("A Data de Corte da Pesquisa P�blica n�o pode ser uma data futura.", PaginaSEI::$TIPO_MSG_ERRO);

                }else{

                    $arrParametroPesquisaDTO = array(
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA, 'Valor' => $_POST['chkCapcthaPesquisa']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF, 'Valor' => $_POST['chkCapcthaGerarPdf']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO, 'Valor' => $_POST['chkListaAndamentoProcessoPublico']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO, 'Valor' => $_POST['chkMetaDadosProcessoRestrito']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO, 'Valor' => $_POST['chkListaAndamentoProcessoRestrito']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO, 'Valor' => trim($_POST['txtDescricaoProcessoAcessoRestrito'])),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_PESQUISA_DOCUMENTO_PROCESSO_RESTRITO, 'Valor' => $_POST['chkPesquisaDocumentoProcessoRestrito'] ?? 'N'),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO, 'Valor' => $_POST['chkListaDocumentoProcessoPublico']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO, 'Valor' => $_POST['chkListaDocumentoProcessoRestrito']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO, 'Valor' => $_POST['chkAutoCompletarInteressado']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO, 'Valor' => $_POST['chkMenuUsuarioExterno']),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA, 'Valor' => trim($_POST['txtChaveCriptografia'])),
                        array('Nome' => MdPesqParametroPesquisaRN::$TA_DATA_CORTE, 'Valor' => implode('-', array_reverse(explode('/', trim($_POST['txtDataCorte']))))),
                    );

                    $arrObjParametroPesquisaDTO = InfraArray::gerarArrInfraDTOMultiAtributos('MdPesqParametroPesquisaDTO', $arrParametroPesquisaDTO);

                    $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
                    $objParametroPesquisaRN->alterarParametros($arrObjParametroPesquisaDTO);

                    PaginaSEI::getInstance()->adicionarMensagem("Par�metros da Pesquisa P�blica salva com sucesso!", PaginaSEI::$TIPO_MSG_AVISO);

                }

            }
            break;

        default:
            throw new InfraException("A��o '" . $_GET['acao'] . "' n�o reconhecida.");
    }

    $arrComandos = array();

    $arrComandos[] = '<button type="submit" accesskey="S" id="btnSalvar" name="btnSalvar" value="Salvar"  class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';

    $objParametroPesquisaDTO = new MdPesqParametroPesquisaDTO();
    $objParametroPesquisaDTO->retStrNome();
    $objParametroPesquisaDTO->retStrValor();

    $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
    $arrObjParametroPesquisaDTO = $objParametroPesquisaRN->listar($objParametroPesquisaDTO);

    $arrParametroPesquisaDTO = InfraArray::converterArrInfraDTO($arrObjParametroPesquisaDTO, 'Valor', 'Nome');

} catch (Exception $e) {
    PaginaSEI::getInstance()->processarExcecao($e);
}

PaginaSEI::getInstance()->montarDocType();
PaginaSEI::getInstance()->abrirHtml();
PaginaSEI::getInstance()->abrirHead();
PaginaSEI::getInstance()->montarMeta();
PaginaSEI::getInstance()->montarTitle(PaginaSEI::getInstance()->getStrNomeSistema() . ' - ' . $strTitulo);
PaginaSEI::getInstance()->montarStyle();
PaginaSEI::getInstance()->abrirStyle();
?>
    h6{font-weight: bold; margin-bottom: 0px !important; padding-top:10px}
    .infraImgModulo{width:20px;}
<?php
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

    $(document).ready(function(){
        $('input[name=chkMetaDadosProcessoRestrito]').change(function(e){
            if($(this).val() == 'N'){
                $("input[name=chkPesquisaDocumentoProcessoRestrito][value=N]").prop('checked', true);
                $('input[name=chkPesquisaDocumentoProcessoRestrito]').prop({disabled: true});
            }else{
                $('input[name=chkPesquisaDocumentoProcessoRestrito]').prop({disabled: false});
            }
        });
    });



<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo, 'onload="inicializar();"');
PaginaSEI::getInstance()->abrirAreaDados(null);
?>
    <form id="frmParametroPesquisaLista" method="post" onsubmit="return OnSubmitForm();"
          action="<?= SessaoSEI::getInstance()->assinarLink('controlador.php?acao=md_pesq_parametro_alterar&acao_origem=' . $_GET['acao']) ?>">

        <?
        PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
        ?>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <fieldset class="infraFieldset sizeFieldset form-control" style="height: auto">
                    <legend class="infraLegend">Captcha</legend>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblCapcthaPesquisa" for="chkCapcthaPesquisa" class="infraLabelObrigatorio">
                                        Habilitar Captcha na Pesquisa P�blica:
                                    </label>
                                </div>
                                <input id="chkCapcthaPesquisa" name="chkCapcthaPesquisa" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblCapcthaPesquisa" for="chkCapcthaPesquisa" class="infraLabelRadio">Sim</label>
                                <input id="chkCapcthaPesquisaNao" name="chkCapcthaPesquisa" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblCapcthaPesquisaNao" for="chkCapcthaPesquisaNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblCapcthaGerarPdf" for="chkCapcthaGerarPdf" class="infraLabelObrigatorio">
                                        Habilitar Captcha no bot�o Gerar PDF do processo:
                                    </label>
                                </div>
                                <input id="chkCapcthaGerarPdf" name="chkCapcthaGerarPdf" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblCapcthaGerarPdf" for="chkCapcthaGerarPdf" class="infraLabelRadio">Sim</label>
                                <input id="chkCapcthaGerarPdfNao" name="chkCapcthaGerarPdf" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblCapcthaGerarPdfNao" for="chkCapcthaGerarPdfNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <fieldset class="infraFieldset sizeFieldset form-control" style="height: auto">
                    <legend class="infraLegend">Par�metros de Pesquisa</legend>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblListaAndamentoProcessoPublico" for="chkListaAndamentoProcessoPublico" class="infraLabelObrigatorio">
                                        Exibir Lista de Andamentos nos processos com n�vel de acesso global P�blico:
                                        <a id="btAjuda" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"
                                           onmouseover="return infraTooltipMostrar('Quando habilitado (Op��o Padr�o), na tela do Processo na Pesquisa P�blica ser� exibida a Lista de Andamentos quando o processo tiver n�vel de acesso global &quot;P�blico&quot;.\n \n Quando desabilitado, a Lista de Andamentos n�o ser� exibida mesmo quando o processo tiver n�vel de acesso global &quot;P�blico&quot;.','Ajuda');" onmouseout="return infraTooltipOcultar();">
                                            <img border="0" class="infraImgModulo" src="/infra_css/svg/ajuda.svg?11">
                                        </a>
                                    </label>
                                </div>
                                <input id="chkListaAndamentoProcessoPublico" name="chkListaAndamentoProcessoPublico" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                                <label id="lblListaAndamentoProcessoPublico" for="chkListaAndamentoProcessoPublico" class="infraLabelRadio">Sim</label>
                                <input id="chkListaAndamentoProcessoPublicoNao" name="chkListaAndamentoProcessoPublico" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                                <label id="lblListaAndamentoProcessoPublicoNao" for="chkListaAndamentoProcessoPublicoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblListaAndamentoProcessoPublico" for="chkListaAndamentoProcessoPublico" class="infraLabelObrigatorio">
                                        Exibir Lista de Andamentos nos processos com n�vel de acesso global Restrito:
                                        <a id="btAjuda" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"
                                           onmouseover="return infraTooltipMostrar('Quando habilitado (Op��o Padr�o), na tela do Processo na Pesquisa P�blica ser� exibida a Lista de Andamentos mesmo quando o processo tiver n�vel de acesso global &quot;Restrito&quot;.\n \n Quando desabilitado, a Lista de Andamentos n�o ser� exibida quando o processo tiver n�vel de acesso global &quot;Restrito&quot;.','Ajuda');" onmouseout="return infraTooltipOcultar();">
                                            <img border="0" class="infraImgModulo" src="/infra_css/svg/ajuda.svg?11">
                                        </a>
                                    </label>
                                </div>
                                <input id="chkListaAndamentoProcessoRestrito" name="chkListaAndamentoProcessoRestrito" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblListaAndamentoProcessoRestrito" for="chkListaAndamentoProcessoRestrito" class="infraLabelRadio">Sim</label>
                                <input id="chkListaAndamentoProcessoRestritoNao" name="chkListaAndamentoProcessoRestrito" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblListaAndamentoProcessoRestritoNao" for="chkListaAndamentoProcessoRestritoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblListaDocumentoProcessoPublico" for="chkListaDocumentoProcessoPublico" class="infraLabelObrigatorio">
                                        Exibir Lista de Protocolos e pesquisar nos processos com n�vel de acesso global P�blico:
                                        <a id="btAjuda" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"
                                           onmouseover="return infraTooltipMostrar('Quando habilitado (Op��o Padr�o), na tela do processo na Pesquisa P�blica ser� exibida a Lista de Protocolos quando o processo tiver n�vel de acesso global &quot;P�blico&quot; e, por consequ�ncia, permitir� a pesquisa pelos protocolos dos documentos e dentro do conte�do dos documentos. \n \n Quando desabilitado, a Lista de Protocolos n�o ser� exibida mesmo o processo sendo integralmente &quot;P�blico&quot; e n�o retornar� a pesquisa pelos protocolos dos documentos e dentro do conte�do dos documentos. Retornar� a pesquisa apenas pelo protocolo do processo.','Ajuda');" onmouseout="return infraTooltipOcultar();">
                                            <img border="0" class="infraImgModulo" src="/infra_css/svg/ajuda.svg?11">
                                        </a>
                                    </label>
                                </div>
                                <input id="chkListaDocumentoProcessoPublico" name="chkListaDocumentoProcessoPublico" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                                <label id="lblListaDocumentoProcessoPublico" for="chkListaDocumentoProcessoPublico" class="infraLabelRadio">Sim</label>
                                <input id="chkListaDocumentoProcessoPublicoNao" name="chkListaDocumentoProcessoPublico" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                                <label id="lblListaDocumentoProcessoPublicoNao" for="chkListaDocumentoProcessoPublicoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblchkListaDocumentoProcessoRestrito" for="chkListaDocumentoProcessoRestrito" class="infraLabelObrigatorio">
                                        Exibir Lista de Protocolos e pesquisar nos processos com n�vel de acesso global Restrito:
                                        <a id="btAjuda" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"
                                           onmouseover="return infraTooltipMostrar('Quando habilitado (Op��o Padr�o), na tela do processo na Pesquisa P�blica ser� exibida a Lista de Protocolos mesmo quando o processo tiver n�vel de acesso global &quot;Restrito&quot; e, por consequ�ncia, permitir� a pesquisa pelos protocolos dos documentos e dentro do conte�do dos documentos p�blicos. \n \n Quando desabilitado, a Lista de Protocolos n�o ser� exibida quando o processo tiver n�vel de acesso global &quot;Restrito&quot; e n�o retornar� a pesquisa pelos protocolos dos documentos e dentro do conte�do dos documentos p�blicos. Retornar� a pesquisa apenas pelo protocolo do processo.','Ajuda');" onmouseout="return infraTooltipOcultar();">
                                            <img border="0" class="infraImgModulo" src="/infra_css/svg/ajuda.svg?11">
                                        </a>
                                    </label>
                                </div>
                                <input id="chkListaDocumentoProcessoRestrito" name="chkListaDocumentoProcessoRestrito" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                                <label id="lblListaDocumentoProcessoRestrito" for="chkListaDocumentoProcessoRestrito" class="infraLabelRadio">Sim</label>
                                <input id="chkListaDocumentoProcessoRestritoNao" name="chkListaDocumentoProcessoRestrito" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                                <label id="lblListaDocumentoProcessoRestritoNao" for="chkListaDocumentoProcessoRestritoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblMetaDadosProcessoRestrito" for="chkMetaDadosProcessoRestrito" class="infraLabelObrigatorio">
                                        Pesquisar e acessar processos com n�vel de acesso global Restrito:
                                        <a id="btAjuda" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"
                                           onmouseover="return infraTooltipMostrar('Quando habilitado (Op��o Padr�o), no caso de processos com n�vel de acesso global &quot;Restrito&quot;, permite a pesquisa e acesso ao processo, pelo menos para ver seus metadados. \n \n Quando desabilidado, de forma geral e sobrepondo outros par�metros, n�o permite a pesquisa e acesso aos processos com n�vel de acesso global &quot;Restrito&quot;, pesquisando apenas por protocolo de processo e de documento para confirmar exist�ncia, exibindo o tipo, o protocolo e o texto configurado no campo &quot;Justificativa de restri��o de acesso e orienta��es para solicitar acesso&quot;. \n \n Quando desabilitado, automaticamente desabilita tamb�m o par�metro &quot;Pesquisar no conte�do de documentos p�blicos nos processos com n�vel de acesso global Restrito&quot;.','Ajuda');" onmouseout="return infraTooltipOcultar();">
                                            <img border="0" class="infraImgModulo" src="/infra_css/svg/ajuda.svg?11">
                                        </a>
                                    </label>
                                </div>
                                <input id="chkMetaDadosProcessoRestrito" name="chkMetaDadosProcessoRestrito" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblMetaDadosProcessoRestrito" for="chkMetaDadosProcessoRestrito" class="infraLabelRadio">Sim</label>
                                <input id="chkMetaDadosProcessoRestritoNao" name="chkMetaDadosProcessoRestrito" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblMetaDadosProcessoRestritoNao" for="chkMetaDadosProcessoRestritoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblDocumentoProcessoPublico" for="chkPesquisaDocumentoProcessoRestrito" class="infraLabelObrigatorio">
                                        Pesquisar no conte�do de documentos p�blicos nos processos com n�vel de acesso global Restrito:
                                        <a id="btAjuda" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"
                                           onmouseover="return infraTooltipMostrar('Quando habilitado (Op��o Padr�o), permite a pesquisa dentro do conte�do de documentos p�blicos nos processos com n�vel de acesso global &quot;Restrito&quot;. \n \n Quando desabilitado, n�o permite a pesquisa dentro do conte�do de documentos p�blicos nos processo com n�vel de acesso global &quot;Restrito&quot;, mas n�o impede a pesquisa pelo protocolo do processo e dos documentos e na tela do processo na Lista de Protocolos dar� acesso aos documentos p�blicos normalmente.','Ajuda');" onmouseout="return infraTooltipOcultar();">
                                            <img border="0" class="infraImgModulo" src="/infra_css/svg/ajuda.svg?11">
                                        </a>
                                    </label>
                                </div>
                                <input id="chkPesquisaDocumentoProcessoRestrito" name="chkPesquisaDocumentoProcessoRestrito" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_PESQUISA_DOCUMENTO_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?> <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'N') ? "disabled" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblPesquisaDocumentoProcessoRestrito" for="chkPesquisaDocumentoProcessoRestrito" class="infraLabelRadio">Sim</label>
                                <input id="chkPesquisaDocumentoProcessoRestritoNao" name="chkPesquisaDocumentoProcessoRestrito" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_PESQUISA_DOCUMENTO_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?> <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'N') ? "disabled" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblPesquisaDocumentoProcessoRestritoNao" for="chkPesquisaDocumentoProcessoRestritoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblDocumentoProcessoPublico" for="txtDescricaoProcessoAcessoRestrito" class="infraLabelObrigatorio">
                                        Justificativa de restri��o de acesso e orienta��es para solicitar acesso:
                                    </label>
                                </div>
                                <textarea id="txtDescricaoProcessoAcessoRestrito" name="txtDescricaoProcessoAcessoRestrito" class="infraTextarea" rows="5" style="width: 90%" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"><?= $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO] ?></textarea>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <fieldset class="infraFieldset sizeFieldset form-control" style="height: auto">
                    <legend class="infraLegend">Configura��es Gerais</legend>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblAutoCompletarInteressado" for="chkAutoCompletarInteressado" class="infraLabelObrigatorio">
                                        Habilitar auto completar no campo "Interessado/Remetente" na Pesquisa P�blica:
                                    </label>
                                </div>
                                <input id="chkAutoCompletarInteressado" name="chkAutoCompletarInteressado" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblAutoCompletarInteressado" for="chkAutoCompletarInteressado" class="infraLabelRadio">Sim</label>
                                <input id="chkAutoCompletarInteressadoNao" name="chkAutoCompletarInteressado" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblAutoCompletarInteressadoNao" for="chkAutoCompletarInteressadoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblMenuUsuarioExterno" for="chkMenuUsuarioExterno" class="infraLabelObrigatorio">
                                        Habilitar menu para a Pesquisa P�blica no Acesso Externo do SEI:
                                    </label>
                                </div>
                                <input id="chkMenuUsuarioExterno" name="chkMenuUsuarioExterno" type="radio" value="S" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO] == 'S') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblMenuUsuarioExterno" for="chkMenuUsuarioExterno" class="infraLabelRadio">Sim</label>
                                <input id="chkMenuUsuarioExternoNao" name="chkMenuUsuarioExterno" type="radio" value="N" class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO] == 'N') ? "checked" : "" ?> tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
								<label id="lblMenuUsuarioExternoNao" for="chkMenuUsuarioExternoNao" class="infraLabelRadio">N�o</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblChaveCriptografia" for="txtChaveCriptografia" class="infraLabelObrigatorio">
                                        Chave para criptografia dos links de processos e documentos:
                                        <img src="<?= PaginaSEI::getInstance()->getDiretorioSvgGlobal() ?>/ajuda.svg" name="ajuda" <?= PaginaSEI::montarTitleTooltip("Este campo deve estar preenchido para que a p�gina da Pesquisa P�blica do SEI possa funcionar. \n \n N�o utilize a mesma Chave em ambientes do SEI distintos, n�o divulgue esta Chave para terceiros e se alterar esta Chave todos os links j� existentes que usu�rios tenham n�o funcionar�o mais. \n \n Defina uma Chave forte, preferencialmente maior que 12 caracteres, utilizando letras mai�sculas e min�sculas, n�meros e caracteres especiais.", 'Ajuda') ?> alt="Ajuda" class="infraImgModulo"/>
                                    </label>
                                </div>
                                <input id="txtChaveCriptografia" name="txtChaveCriptografia" type="text" class="infraText" maxlength="100" style="width: 40%" value="<?= $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA] ?>" tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <div class="form-group">
                                <div>
                                    <label id="lblCapcthaPesquisa" for="chkCapcthaPesquisa" class="infraLabelOpcional">
                                        Data de Corte Opcional:
                                        <img src="<?= PaginaSEI::getInstance()->getDiretorioSvgGlobal() ?>/ajuda.svg" name="ajuda" <?= PaginaSEI::montarTitleTooltip("Quando informada, o m�dulo de Pesquisa P�blica protege a pesquisa dentro do conte�do e o acesso aos documentos com n�vel de acesso P�blico que tenham data de inclus�o (no caso de Documento Externo ou Autom�tico) ou data da primeira assinatura (no caso de Documento Gerado ou Formul�rio) anterior � data de corte informada. \n \n Nesse cen�rio, no acesso ao processo, ao lado do protocolo do documento constar� o �cone de uma chave azul indicando a situa��o de restri��o provis�ria em raz�o de necessidade de reclassifica��o de n�vel de acesso.", 'Ajuda') ?> alt="Ajuda" class="infraImgModulo"/>
                                    </label>
                                </div>
                                <div class="input-group mb-3 data">
                                    <input type="text" id="txtDataCorte" name="txtDataCorte" onkeypress="return infraMascaraData(this, event);" class="infraText" value="<?= implode('/', array_reverse(explode('-', $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DATA_CORTE]))) ?>" tabindex="511">
                                    <img id="imgDataInicio" src="/infra_css/svg/calendario.svg" onclick="infraCalendario('txtDataCorte',this);" alt="Selecionar Data de Corte" title="Selecionar Data de Corte" class="infraImgModulo" tabindex="512">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
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