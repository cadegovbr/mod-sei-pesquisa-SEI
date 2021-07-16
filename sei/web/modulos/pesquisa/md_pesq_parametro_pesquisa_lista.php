<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 29/11/2016 - criado por alex
 *
 * Vers�o do Gerador de C�digo: 1.39.0
 */

try {
    require_once dirname(__FILE__) . '/../../SEI.php';

    session_start();

    //////////////////////////////////////////////////////////////////////////////
    //InfraDebug::getInstance()->setBolLigado(false);
    //InfraDebug::getInstance()->setBolDebugInfra(true);
    //InfraDebug::getInstance()->limpar();
    //////////////////////////////////////////////////////////////////////////////

    SessaoSEI::getInstance()->validarLink();
    SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

    switch ($_GET['acao']) {


        case 'md_pesq_parametro_listar':
            $strTitulo = 'Par�metros Pesquisa P�blica';
            break;

        case 'md_pesq_parametro_alterar':

            $strTitulo = 'Par�metros Pesquisa P�blica';
            if (isset($_POST['btnSalvar'])) {
                $arrParametroPesquisaDTO = array(
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA, 'Valor' => $_POST['chkCapcthaPesquisa']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF, 'Valor' => $_POST['chkCapcthaGerarPdf']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO, 'Valor' => $_POST['chkListaAndamentoProcessoPublico']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_PROCESSO_RESTRITO, 'Valor' => $_POST['chkProcessoRestrito']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO, 'Valor' => $_POST['chkMetaDadosProcessoRestrito']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO, 'Valor' => $_POST['chkListaAndamentoProcessoRestrito']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO, 'Valor' => trim($_POST['txtDescricaoProcessoAcessoRestrito'])),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_DOCUMENTO_PROCESSO_PUBLICO, 'Valor' => $_POST['chkDocumentoProcessoPublico']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO, 'Valor' => $_POST['chkListaDocumentoProcessoPublico']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO, 'Valor' => $_POST['chkListaDocumentoProcessoRestrito']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO, 'Valor' => $_POST['chkAutoCompletarInteressado']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO, 'Valor' => $_POST['chkMenuUsuarioExterno']),
                    array('Nome' => MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA, 'Valor' => trim($_POST['txtChaveCriptografia'])),
                );

                $arrObjParametroPesquisaDTO = InfraArray::gerarArrInfraDTOMultiAtributos('MdPesqParametroPesquisaDTO', $arrParametroPesquisaDTO);

                $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
                $objParametroPesquisaRN->alterarParametros($arrObjParametroPesquisaDTO);

                PaginaSEI::getInstance()->adicionarMensagem("Parametros da Pesquisa P�blica salva com sucesso!", PaginaSEI::$TIPO_MSG_AVISO);
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


<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo, 'onload="inicializar();"');
PaginaSEI::getInstance()->abrirAreaDados(null);
?>
    <form id="frmParametroPesquisaLista" method="post" onsubmit="return OnSubmitForm();"
          action="<?= SessaoSEI::getInstance()->assinarLink('controlador.php?acao=md_pesq_parametro_alterar&acao_origem=' . $_GET['acao']) ?>">

        <?
        //PaginaSEI::getInstance()->montarBarraLocalizacao($strTitulo);
        PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
        //PaginaSEI::getInstance()->montarAreaValidacao();
        ?>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <fieldset class="infraFieldset sizeFieldset form-control" style="height: auto">
                    <legend class="infraLegend">Captcha</legend>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar Captcha na pesquisa p�blica:</h6>
                            <input id="chkCapcthaPesquisa" name="chkCapcthaPesquisa" type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblCapcthaPesquisa" for="chkCapcthaPesquisa"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkCapcthaPesquisaNao" name="chkCapcthaPesquisa" type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblCapcthaPesquisaNao" for="chkCapcthaPesquisaNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar Captcha gerar PDF:</h6>
                            <input id="chkCapcthaGerarPdf" name="chkCapcthaGerarPdf" type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblCapcthaGerarPdf" for="chkCapcthaGerarPdf"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkCapcthaGerarPdfNao" name="chkCapcthaGerarPdf" type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblCapcthaGerarPdfNao" for="chkCapcthaGerarPdfNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <fieldset class="infraFieldset sizeFieldset form-control" style="height: auto">
                    <legend class="infraLegend">Processos</legend>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar a exibi��o dos Andamentos nos processos com n�vel de
                                acesso global "Restrito":</h6>
                            <input id="chkListaAndamentoProcessoRestrito" name="chkListaAndamentoProcessoRestrito"
                                   type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaAndamentoProcessoRestrito" for="chkListaAndamentoProcessoRestrito"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkListaAndamentoProcessoRestritoNao" name="chkListaAndamentoProcessoRestrito"
                                   type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaAndamentoProcessoRestritoNao" for="chkListaAndamentoProcessoRestritoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar a exibi��o dos Andamentos nos processos com n�vel de acesso global
                                "P�blico":</h6>
                            <input id="chkListaAndamentoProcessoPublico" name="chkListaAndamentoProcessoPublico"
                                   type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaAndamentoProcessoPublico" for="chkListaAndamentoProcessoPublico"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkListaAndamentoProcessoPublicoNao" name="chkListaAndamentoProcessoPublico"
                                   type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaAndamentoProcessoPublicoNao" for="chkListaAndamentoProcessoPublicoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar a pesquisa em processos com n�vel de acesso global "Restrito":</h6>
                            <input id="chkProcessoRestrito" name="chkProcessoRestrito" type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblProcessoRestrito" for="chkProcessoRestrito"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkProcessoRestritoNao" name="chkProcessoRestrito" type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblProcessoRestritoNao" for="chkProcessoRestritoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar o acesso aos metadados dos Processos com n�vel de
                                acesso global "Restrito"</h6>
                            <input id="chkMetaDadosProcessoRestrito" name="chkMetaDadosProcessoRestrito" type="radio"
                                   value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblMetaDadosProcessoRestrito" for="chkMetaDadosProcessoRestrito"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkMetaDadosProcessoRestritoNao" name="chkMetaDadosProcessoRestrito" type="radio"
                                   value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblMetaDadosProcessoRestritoNao" for="chkMetaDadosProcessoRestritoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Descri��o de justificativa de restri��o de acesso e
                                orienta��es para meios alternativos de solicita��o de acesso:</h6>
                            <textarea id="txtDescricaoProcessoAcessoRestrito" name="txtDescricaoProcessoAcessoRestrito"
                                      class="infraTextarea" rows="5" style="width: 90%"
                                      tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"><?= $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO] ?></textarea>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <fieldset class="infraFieldset sizeFieldset form-control" style="height: auto">
                    <legend class="infraLegend">Documentos</legend>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar a pesquisa em Documentos que est�o associados �
                                processos com n�vel de acesso global "P�blico":</h6>
                            <input id="chkDocumentoProcessoPublico" name="chkDocumentoProcessoPublico" type="radio"
                                   value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DOCUMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblDocumentoProcessoPublico" for="chkDocumentoProcessoPublico"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkDocumentoProcessoPublicoNao" name="chkDocumentoProcessoPublico" type="radio"
                                   value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DOCUMENTO_PROCESSO_PUBLICO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblDocumentoProcessoPublicoNao" for="chkDocumentoProcessoPublicoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar o acesso aos Documentos nos processos com n�vel de
                                acesso global "P�blico":</h6>
                            <input id="chkListaDocumentoProcessoPublico" name="chkListaDocumentoProcessoPublico"
                                   type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaDocumentoProcessoPublico" for="chkListaDocumentoProcessoPublico"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkListaDocumentoProcessoPublicoNao" name="chkListaDocumentoProcessoPublico"
                                   type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaDocumentoProcessoPublicoNao" for="chkListaDocumentoProcessoPublicoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar o acesso aos Documentos nos processos com n�vel de
                                acesso global "Restrito":</h6>
                            <input id="chkListaDocumentoProcessoRestrito" name="chkListaDocumentoProcessoRestrito"
                                   type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaDocumentoProcessoRestrito" for="chkListaDocumentoProcessoRestrito"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkListaDocumentoProcessoRestritoNao" name="chkListaDocumentoProcessoRestrito"
                                   type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblListaDocumentoProcessoRestritoNao" for="chkListaDocumentoProcessoRestritoNao"
                                   class="infraLabelRadio">N�o</label>
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
                            <h6>Habilitar a fun��o auto completar no campo "Interessado /
                                Remetente" na p�gina principal da Pesquisa P�blica:</h6>
                            <input id="chkAutoCompletarInteressado" name="chkAutoCompletarInteressado" type="radio"
                                   value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblAutoCompletarInteressado" for="chkAutoCompletarInteressado"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkAutoCompletarInteressadoNao" name="chkAutoCompletarInteressado" type="radio"
                                   value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblAutoCompletarInteressadoNao" for="chkAutoCompletarInteressadoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Habilitar o link da pesquisa p�blica no menu de usu�rio
                                externo:</h6>
                            <input id="chkMenuUsuarioExterno" name="chkMenuUsuarioExterno" type="radio" value="S"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO] == 'S') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblMenuUsuarioExterno" for="chkMenuUsuarioExterno"
                                   class="infraLabelRadio">Sim</label>
                            <input id="chkMenuUsuarioExternoNao" name="chkMenuUsuarioExterno" type="radio" value="N"
                                   class="infraRadio" <?= ($arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO] == 'N') ? "checked" : "" ?>
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
                            <label id="lblMenuUsuarioExternoNao" for="chkMenuUsuarioExternoNao"
                                   class="infraLabelRadio">N�o</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-11">
                            <h6>Chave para criptografia dos links de processos e
                                documentos: <img src="<?= PaginaSEI::getInstance()->getDiretorioSvgGlobal() ?>/ajuda.svg" name="ajuda" <?= PaginaSEI::montarTitleTooltip("Este campo deve estar preenchido para que a p�gina da Pesquisa P�blica do SEI possa funcionar.\n\nN�o utilize a mesma Chave em ambientes do SEI distintos, n�o divulgue esta Chave para terceiros e se alterar esta Chave todos os links j� existentes que usu�rios tenham n�o funcionar�o. \n\n\n\n\n\n Defina uma Chave forte, preferencialmente maior que 12 caracteres, utilizando letras mai�sculas e min�sculas, n�meros e caracteres especiais.", 'Ajuda') ?> alt="Ajuda" class="infraImgModulo"/></h6>
                            <input id="txtChaveCriptografia" name="txtChaveCriptografia" type="text" class="infraText "
                                   maxlength="100"
                                   style="width: 40%"
                                   value="<?= $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA] ?>"
                                   tabindex="<?= PaginaSEI::getInstance()->getProxTabDados() ?>"/>
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