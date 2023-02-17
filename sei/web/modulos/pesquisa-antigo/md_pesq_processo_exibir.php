<?
/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECON�MICA
*
* 29/09/2014 - criado por alex braga
*
* Vers�o do Gerador de C�digo:
*
* Vers�o no CVS:
*/

try {
  require_once dirname(__FILE__).'/../../SEI.php';

  SessaoSEIExterna::getInstance()->validarSessao();
  //session_start();
 
  //////////////////////////////////////////////////////////////////////////////
//   InfraDebug::getInstance()->setBolLigado(false);
//   InfraDebug::getInstance()->setBolDebugInfra(true);
//   InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////
  	MdPesqConverteURI::converterURI();
   	MdPesqPesquisaUtil::valiadarLink();
  	
  //  SessaoSEIExterna::getInstance()->validarLink();
    

  //carrega configura��es pesquisa
  
  $objParametroPesquisaDTO = new MdPesqParametroPesquisaDTO();
  $objParametroPesquisaDTO->retStrNome();
  $objParametroPesquisaDTO->retStrValor();
   	
  $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
  $arrObjParametroPesquisaDTO = $objParametroPesquisaRN->listar($objParametroPesquisaDTO);
  $arrParametroPesquisaDTO = InfraArray::converterArrInfraDTO($arrObjParametroPesquisaDTO,'Valor','Nome');
   
  $bolPesquisaProcessoRestrito = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_PROCESSO_RESTRITO] == 'S' ? true : false;
  $bolListaDocumentoProcessoPublico = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO] == 'S' ? true : false;
  $bolListaAndamentoProcessoPublico = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO] == 'S' ? true : false;
  $bolCaptchaGerarPdf = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF] == 'S' ? true : false;
  $bolLinkMetadadosProcessoRestrito =  $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO] == 'S' ? true : false;
  $bolListaAndamentoProcessoRestrito = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO] == 'S' ? true : false;
  $bolListaDocumentoProcessoRestrito = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO] == 'S' ? true : false;
  $txtDescricaoProcessoAcessoRestrito = $arrParametroPesquisaDTO[MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO];
  
  if($bolCaptchaGerarPdf) {
  	$strCodigoParaGeracaoCaptcha = InfraCaptcha::obterCodigo();
  	$md5Captcha = md5(InfraCaptcha::gerar($strCodigoParaGeracaoCaptcha));
  }else {
  	$md5Captcha = null;
  }

  PaginaSEIExterna::getInstance()->setTipoPagina(PaginaSEIExterna::$TIPO_PAGINA_SEM_MENU);
  
     $strTitulo = 'Pesquisa Processual';
 

    $dblIdProcedimento = $_GET['id_procedimento']; 
     
	//Carregar dados do cabe�alho
	$objProcedimentoDTO = new ProcedimentoDTO();
	$objProcedimentoDTO->retStrNomeTipoProcedimento();
	$objProcedimentoDTO->retStrProtocoloProcedimentoFormatado();
	$objProcedimentoDTO->retDtaGeracaoProtocolo();
	$objProcedimentoDTO->retStrStaNivelAcessoGlobalProtocolo();
	$objProcedimentoDTO->retStrStaNivelAcessoLocalProtocolo();
	$objProcedimentoDTO->retNumIdHipoteseLegalProtocolo();
	
	$objProcedimentoDTO->setDblIdProcedimento($dblIdProcedimento);
	$objProcedimentoDTO->setStrSinDocTodos('S');  
	$objProcedimentoDTO->setStrSinProcAnexados('S');
	//$objProcedimentoDTO->setStrSinDocAnexos('S');  
	//$objProcedimentoDTO->setStrSinDocConteudo('S');
	
	$objProcedimentoRN = new ProcedimentoRN();
	$arr = $objProcedimentoRN->listarCompleto($objProcedimentoDTO);
	
	if (count($arr)==0){
	  //SessaoSEIExterna::getInstance()->sair(null, 'Processo n�o encontrado.');
		die('Processo n�o encontrado.');
	}
	
	$objProcedimentoDTO = $arr[0];
	
	if($objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo() == ProtocoloRN::$NA_SIGILOSO  ){
	
		die('Processo n�o encontrado.');
	
	}

	if(!$bolLinkMetadadosProcessoRestrito || !$bolPesquisaProcessoRestrito){
		if ($objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo()!= ProtocoloRN::$NA_PUBLICO){
			die('Processo n�o encontrado.');
		}
	}
	 
	
	
	
	
	
	//Carregar interessados no processo
	$objInteressadosParticipanteDTO = new ParticipanteDTO();
	$objInteressadosParticipanteDTO->retStrNomeContato();
	$objInteressadosParticipanteDTO->setDblIdProtocolo($dblIdProcedimento);
	$objInteressadosParticipanteDTO->setStrStaParticipacao(ParticipanteRN::$TP_INTERESSADO);
	

	$objInteressadosParticipanteRN = new ParticipanteRN();
	
	$objInteressadosParticipanteDTO = $objInteressadosParticipanteRN->listarRN0189($objInteressadosParticipanteDTO);

	if (count($objInteressadosParticipanteDTO)==0){
	  $strInteressados = '&nbsp;';
	}else{
  		$strInteressados = '';
  		foreach($objInteressadosParticipanteDTO as $objInteressadoParticipanteDTO){
  			$strInteressados .= $objInteressadoParticipanteDTO->getStrNomeContato()."<br /> ";
  		}
	}
	
	
	//Mensagem Processo Restrito
	$strMensagemProcessoRestrito = '';
	$strHipoteseLegal = '';
	if($objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo() == ProtocoloRN::$NA_RESTRITO && $bolLinkMetadadosProcessoRestrito){
		
		$objHipoteseLegalDTO = new HipoteseLegalDTO();
		$objHipoteseLegalDTO->setNumIdHipoteseLegal($objProcedimentoDTO->getNumIdHipoteseLegalProtocolo());
		$objHipoteseLegalDTO->retStrBaseLegal();
		$objHipoteseLegalDTO->retStrNome();
		
		$objHipoteseLegalRN = new HipoteseLegalRN();
        $objHipoteseLegalDTO = $objHipoteseLegalRN->consultar($objHipoteseLegalDTO);
    				 
    	if($objHipoteseLegalDTO != null){
    		
    		$strHipoteseLegal .= '<img src="/infra_css/imagens/espaco.gif">';
    		$strHipoteseLegal .= '<img src="imagens/sei_chave_restrito.gif" align="absbottom"  title="Acesso Restrito.&#13'.PaginaSEIExterna::getInstance()->formatarXHTML($objHipoteseLegalDTO->getStrNome().' ('.$objHipoteseLegalDTO->getStrBaseLegal().')').'">';
   
    	}		
		
		$strMensagemProcessoRestrito = '<p style="font-size: 1.2em;"> '.$txtDescricaoProcessoAcessoRestrito.'</p>';
		
	}
	
 	
  $strResultadoCabecalho = '';
  $strResultadoCabecalho .= '<table id="tblCabecalho" width="99.3%" class="infraTable" summary="Cabe�alho de Processo" >'."\n";
  $strResultadoCabecalho .= '<tr><th class="infraTh" colspan="2">Autua��o</th></tr>'."\n";
  $strResultadoCabecalho .= '<tr class="infraTrClara"><td width="20%">Processo:</td><td>'.$objProcedimentoDTO->getStrProtocoloProcedimentoFormatado().$strHipoteseLegal.'</td></tr>'."\n";
  $strResultadoCabecalho .= '<tr class="infraTrClara"><td width="20%">Tipo:</td><td>'.PaginaSEIExterna::getInstance()->formatarXHTML($objProcedimentoDTO->getStrNomeTipoProcedimento()).'</td></tr>'."\n";
  $strResultadoCabecalho .= '<tr class="infraTrClara"><td width="20%">Data de Registro:</td><td>'.$objProcedimentoDTO->getDtaGeracaoProtocolo().'</td></tr>'."\n";
  $strResultadoCabecalho .= '<tr class="infraTrClara"><td width="20%">Interessados:</td><td> '.$strInteressados.'</td></tr>'."\n";
  $strResultadoCabecalho .= '</table>'."\n";
  
  
  
  
 	

	//$arrObjDocumentoDTO = InfraArray::indexarArrInfraDTO($objProcedimentoDTO->getArrObjDocumentoDTO(),'IdDocumento');
  $arrObjRelProtocoloProtocoloDTO = array();
  
  if($bolListaDocumentoProcessoPublico && $objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo() == ProtocoloRN::$NA_PUBLICO ){
  		$arrObjRelProtocoloProtocoloDTO = $objProcedimentoDTO->getArrObjRelProtocoloProtocoloDTO();
  }else if($bolListaDocumentoProcessoRestrito && $objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo() == ProtocoloRN::$NA_RESTRITO){
  		$arrObjRelProtocoloProtocoloDTO = $objProcedimentoDTO->getArrObjRelProtocoloProtocoloDTO();
  }
  
  // Objeto Fake para pagina��o.
  $objProtocoloPesquisaPublicaPaginacaoDTO = new MdPesqProtocoloPesquisaPublicaDTO();
  $objProtocoloPesquisaPublicaPaginacaoDTO->retTodos(true);
  PaginaSEIExterna::getInstance()->prepararOrdenacao($objProtocoloPesquisaPublicaPaginacaoDTO, 'Registro', InfraDTO::$TIPO_ORDENACAO_ASC);
  //PaginaSEIExterna::getInstance()->prepararPaginacao($objProtocoloPesquisaPublicaPaginacaoDTO,4);
  //PaginaSEIExterna::getInstance()->processarPaginacao($objProtocoloPesquisaPublicaPaginacaoDTO);
  $arrObjProtocoloPesquisaPublicaDTO = array();
	
  $objDocumentoRN = new DocumentoRN();
	
  $numProtocolos = 0;
  $numDocumentosPdf = 0;
  $strCssMostrarAcoes = '.colunaAcoes {display:none;}'."\n";
  
  $strThCheck = PaginaSEIExterna::getInstance()->getThCheck();
  
  foreach($arrObjRelProtocoloProtocoloDTO as $objRelProtocoloProtocoloDTO){

    if ($objRelProtocoloProtocoloDTO->getStrStaAssociacao()==RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO){
      
      	$objDocumentoDTO = $objRelProtocoloProtocoloDTO->getObjProtocoloDTO2();
      	//valida documentos para retornar
   	  	if ($objDocumentoRN->verificarSelecaoAcessoExterno($objDocumentoDTO)){
   	  	
   	  		$objProtocoloPesquisaPublicaDTO = new MdPesqProtocoloPesquisaPublicaDTO();
   	  		$objProtocoloPesquisaPublicaDTO->setStrNumeroSEI($objDocumentoDTO->getStrProtocoloDocumentoFormatado());
   	  		$objProtocoloPesquisaPublicaDTO->setStrTipoDocumento(PaginaSEIExterna::getInstance()->formatarXHTML($objDocumentoDTO->getStrNomeSerie().' '.$objDocumentoDTO->getStrNumero()));
   	  		
   	  		
   	  		if($objDocumentoDTO->getStrStaProtocoloProtocolo() == ProtocoloRN::$TP_DOCUMENTO_RECEBIDO){

   	  				$objAtributoAndamentoDTO = new AtributoAndamentoDTO();
  					$objAtributoAndamentoDTO->setDblIdProtocoloAtividade($objProcedimentoDTO->getDblIdProcedimento());
  					$objAtributoAndamentoDTO->setNumIdTarefaAtividade(TarefaRN::$TI_RECEBIMENTO_DOCUMENTO);
  					$objAtributoAndamentoDTO->setStrNome("DOCUMENTO");
  					$objAtributoAndamentoDTO->setStrIdOrigem($objDocumentoDTO->getDblIdDocumento());
  					
  					$objAtributoAndamentoDTO->retDthAberturaAtividade();
  					
  					$objAtributoAndamentoRN = new AtributoAndamentoRN();
  					
  					$objAtributoAndamentoDTO = $objAtributoAndamentoRN->consultarRN1366($objAtributoAndamentoDTO);
  					
  					if($objAtributoAndamentoDTO != null && $objAtributoAndamentoDTO->isSetDthAberturaAtividade()){
  					
  						$dtaRecebimento =  substr($objAtributoAndamentoDTO->getDthAberturaAtividade(),0,10);
  						
  						$objProtocoloPesquisaPublicaDTO->setDtaRegistro($dtaRecebimento);
  					
  					}else{
  						
  						$objProtocoloPesquisaPublicaDTO->setDtaRegistro($objDocumentoDTO->getDtaGeracaoProtocolo());
  					}
  					
  					$objProtocoloPesquisaPublicaDTO->setDtaDocumento($objDocumentoDTO->getDtaGeracaoProtocolo());
  			
   	  		}else if ($objDocumentoDTO->getStrStaProtocoloProtocolo() == ProtocoloRN::$TP_DOCUMENTO_GERADO){
   	  			
   	  				$objAssinaturaDTO = new AssinaturaDTO();
   	  				$objAssinaturaDTO->setDblIdDocumento($objDocumentoDTO->getDblIdDocumento());
   	  				$objAssinaturaDTO->setOrdNumIdAssinatura(InfraDTO::$TIPO_ORDENACAO_ASC);
   	  				$objAssinaturaDTO->retDthAberturaAtividade();
   	  				
   	  				$objAssinaturaRN = new AssinaturaRN();
   	  				$arrObjAssinaturaDTO = $objAssinaturaRN->listarRN1323($objAssinaturaDTO);
   	  				
   	  				if(is_array($arrObjAssinaturaDTO) && count($arrObjAssinaturaDTO) > 0) {
   	  					
   	  					$objAssinaturaDTO = $arrObjAssinaturaDTO[0];
   	  					
   	  					if($objAssinaturaDTO != null && $objAssinaturaDTO->isSetDthAberturaAtividade()){
   	  						 
   	  						$dtaAssinatura =  substr($objAssinaturaDTO->getDthAberturaAtividade(),0,10);
   	  						 
   	  						$objProtocoloPesquisaPublicaDTO->setDtaRegistro($dtaAssinatura);
   	  						$objProtocoloPesquisaPublicaDTO->setDtaDocumento($dtaAssinatura);
   	  						 
   	  					}else{
   	  						$objProtocoloPesquisaPublicaDTO->setDtaRegistro($objDocumentoDTO->getDtaGeracaoProtocolo());
   	  						$objProtocoloPesquisaPublicaDTO->setDtaDocumento($objDocumentoDTO->getDtaGeracaoProtocolo());
   	  					}
   	  				}else{
   	  					
   	  					$objProtocoloPesquisaPublicaDTO->setDtaRegistro($objDocumentoDTO->getDtaGeracaoProtocolo());
   	  					$objProtocoloPesquisaPublicaDTO->setDtaDocumento($objDocumentoDTO->getDtaGeracaoProtocolo());
   	  				}
   	  				
   	  				
   	  			
   	  					
   	  		}
   	  		
   	  		
   	  		$objProtocoloPesquisaPublicaDTO->setStrUnidade($objDocumentoDTO->getStrSiglaUnidadeGeradoraProtocolo());
   	  		$objProtocoloPesquisaPublicaDTO->setStrStaAssociacao($objRelProtocoloProtocoloDTO->getStrStaAssociacao());
   	  		$objProtocoloPesquisaPublicaDTO->setObjDocumentoDTO($objDocumentoDTO);
   	  		
   	  	
   	  		$arrObjProtocoloPesquisaPublicaDTO[] = $objProtocoloPesquisaPublicaDTO;
   	  		$numProtocolos++;
   	  	}
    }else if ($objRelProtocoloProtocoloDTO->getStrStaAssociacao()==RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO){

      	$objProcedimentoDTOAnexado = $objRelProtocoloProtocoloDTO->getObjProtocoloDTO2();
      	
      	$objProtocoloPesquisaPublicaDTO = new MdPesqProtocoloPesquisaPublicaDTO();
      	$objProtocoloPesquisaPublicaDTO->setStrNumeroSEI($objProcedimentoDTOAnexado->getStrProtocoloProcedimentoFormatado());
      	$objProtocoloPesquisaPublicaDTO->setStrTipoDocumento(PaginaSEIExterna::getInstance()->formatarXHTML($objProcedimentoDTOAnexado->getStrNomeTipoProcedimento()));
      	$objProtocoloPesquisaPublicaDTO->setDtaDocumento($objProcedimentoDTOAnexado->getDtaGeracaoProtocolo());
      	$objProtocoloPesquisaPublicaDTO->setDtaRegistro($objProcedimentoDTOAnexado->getDtaGeracaoProtocolo());
      	$objProtocoloPesquisaPublicaDTO->setStrUnidade($objProcedimentoDTOAnexado->getStrSiglaUnidadeGeradoraProtocolo());
      	$objProtocoloPesquisaPublicaDTO->setStrStaAssociacao($objRelProtocoloProtocoloDTO->getStrStaAssociacao());
      	$objProtocoloPesquisaPublicaDTO->setObjProcedimentoDTO($objProcedimentoDTOAnexado);
      	
      	$arrObjProtocoloPesquisaPublicaDTO[] = $objProtocoloPesquisaPublicaDTO;
      
      
      	$numProtocolos++;
    }
  }
  
  
  if ($numProtocolos > 0){
  	
  	
  	
   	$strResultado = '<table id="tblDocumentos" width="99.3%" class="infraTable" summary="Lista de Documentos" >
  					  									<caption class="infraCaption" >'.PaginaSEIExterna::getInstance()->gerarCaptionTabela("Protocolos",$numProtocolos).'</caption> 
  					 										<tr>
                                  <th class="infraTh" width="1%">'.$strThCheck.'</th>  					  									    
  					  										<th class="infraTh" width="15%">'.PaginaSEIExterna::getInstance()->getThOrdenacao($objProtocoloPesquisaPublicaPaginacaoDTO,'Documento / Processo','NumeroSEI',$arrObjProtocoloPesquisaPublicaDTO,true).'</th>
  					  										<th class="infraTh" width="15%">'.PaginaSEIExterna::getInstance()->getThOrdenacao($objProtocoloPesquisaPublicaPaginacaoDTO,'Tipo de Documento','TipoDocumento',$arrObjProtocoloPesquisaPublicaDTO,true).'</th>
  					  										<th class="infraTh" width="15%">'.PaginaSEIExterna::getInstance()->getThOrdenacao($objProtocoloPesquisaPublicaPaginacaoDTO,'Data do Documento','Documento',$arrObjProtocoloPesquisaPublicaDTO,true).'</th>
                                  							<th class="infraTh" width="15%">'.PaginaSEIExterna::getInstance()->getThOrdenacao($objProtocoloPesquisaPublicaPaginacaoDTO,'Data de Registro','Registro',$arrObjProtocoloPesquisaPublicaDTO,true).'</th>
  					  										<th class="infraTh" width="15%">'.PaginaSEIExterna::getInstance()->getThOrdenacao($objProtocoloPesquisaPublicaPaginacaoDTO,'Unidade','Unidade',$arrObjProtocoloPesquisaPublicaDTO,true).'</th>
  					  										
  					  									</tr>';
   	
   	// monta tabela documentos
   	foreach ($arrObjProtocoloPesquisaPublicaDTO as $objProtocoloPesquisaPublicaDTO){
   		 
   		if($objProtocoloPesquisaPublicaDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO){
   	
   			$objDocumentoDTO = $objProtocoloPesquisaPublicaDTO->getObjDocumentoDTO();
   			$urlCripografadaDocumeto = MdPesqCriptografia::criptografa('acao_externa=documento_exibir&id_documento='.$objDocumentoDTO->getDblIdDocumento().'&id_orgao_acesso_externo=0');
   			$strLinkDocumento = PaginaSEI::getInstance()->formatarXHTML(SessaoSEI::getInstance()->assinarLink('md_pesq_documento_consulta_externa.php?'.$urlCripografadaDocumeto));

			//Protege acesso � documento p�blico de intima��o eletr�nica
			$bolValidaIntimacaoEletronica = true;

			$objInfraParametroDTO = $objParametroPesquisaRN->consultarVersaoPeticionamento('2.0.0');
			if( !is_null($objInfraParametroDTO) ){
				$objMdPetIntCertidaoRN =  new MdPetIntCertidaoRN();
				if( !$objMdPetIntCertidaoRN->verificaDocumentoEAnexoIntimacaoNaoCumprida( array($objDocumentoDTO->getDblIdDocumento(),false,false,true) ) ){
					$bolValidaIntimacaoEletronica = false;	
				}
			}

			$strResultado .= '<tr class="infraTrClara">';

   			//Cria checkbox para gerar PDF, verifica se o Processo � p�blico e o Acesso Local do Protocolo � P�blico
			if($objDocumentoDTO->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_PUBLICO && $objProcedimentoDTO->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_PUBLICO){
				if($objDocumentoRN->verificarSelecaoGeracaoPdf($objDocumentoDTO) && $bolValidaIntimacaoEletronica){
					$strResultado .= '<td align="center">'.PaginaSEIExterna::getInstance()->getTrCheck($numDocumentosPdf++, $objDocumentoDTO->getDblIdDocumento(), $objDocumentoDTO->getStrNomeSerie()).'</td>';
				}else{
   					$strResultado .= '<td>&nbsp;</td>';
   				}
   			}else{
   				$strResultado .= '<td>&nbsp;</td>';
   			}
   			
   	
   			//Exibe link de documentos com nivel de acesso local P�blico de processo p�blico
			if($objDocumentoDTO->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_PUBLICO && $objProcedimentoDTO->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_PUBLICO ){

				if($bolValidaIntimacaoEletronica){
					$strResultado .= '<td align="center" style="padding-right:22px"><a href="javascript:void(0);" onclick="window.open(\''.$strLinkDocumento.'\');" alt="'.PaginaSEIExterna::getInstance()->formatarXHTML($objDocumentoDTO->getStrNomeSerie()).'" title="'.PaginaSEIExterna::getInstance()->formatarXHTML($objDocumentoDTO->getStrNomeSerie()).'" class="ancoraPadraoAzul">'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'</a></td>';
				}else{
					$strResultado .= '<td align="center"><span class="retiraAncoraPadraoAzul">'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'</span>';
					$strResultado .= '<img src="/infra_css/imagens/espaco.gif">';
					$strResultado .= '<img src="../peticionamento/imagens/intimacao_nao_cumprida_doc_anexo.png" align="absbottom"  title="Acesso Restrito.&#13'.'Documento com acesso restrito provisoriamente em raz�o de Intima��o Eletr�nica ainda n�o cumprida">';
				}

			}else{
				if($objDocumentoDTO->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_RESTRITO){
   					
   					//necessario para retornar id hipotese legal do documento
   					$strHipoteseLegalDocumento = '';
   					$objProtocoloDocumentoDTO = new ProtocoloDTO();
   					$objProtocoloDocumentoDTO->setDblIdProtocolo($objDocumentoDTO->getDblIdDocumento());
   					$objProtocoloDocumentoDTO->retNumIdHipoteseLegal();
   					
   					$objProtocoloRN = new ProtocoloRN();
   					$objProtocoloDocumentoDTO = $objProtocoloRN->consultarRN0186($objProtocoloDocumentoDTO);
   					
   					if($objProtocoloDocumentoDTO != null){
   						
   						$objHipoteseLegaDocumentoDTO = new HipoteseLegalDTO();
   						$objHipoteseLegaDocumentoDTO->setNumIdHipoteseLegal($objProtocoloDocumentoDTO->getNumIdHipoteseLegal());
   						$objHipoteseLegaDocumentoDTO->retStrNome();
   						$objHipoteseLegaDocumentoDTO->retStrBaseLegal();
   						
   						$objHipoteseLegalRN = new HipoteseLegalRN();
   						$objHipoteseLegaDocumentoDTO = $objHipoteseLegalRN->consultar($objHipoteseLegaDocumentoDTO);
   						
   						
   						if($objHipoteseLegaDocumentoDTO != null){
   								
   							$strHipoteseLegalDocumento .= $objHipoteseLegaDocumentoDTO->getStrNome().' ('.$objHipoteseLegaDocumentoDTO->getStrBaseLegal().')';
   						}
   					}
   					

   					
   					$strResultado .= '<td align="center" ><span class="retiraAncoraPadraoAzul">'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'</span>';
   					$strResultado .= '<img src="/infra_css/imagens/espaco.gif">';
   					$strResultado .= '<img src="imagens/sei_chave_restrito.gif" align="absbottom"  title="Acesso Restrito.&#13'.PaginaSEIExterna::getInstance()->formatarXHTML($strHipoteseLegalDocumento).'">';
   					$strResultado .= '</td>';
   					
   				}else{
   					$strResultado .= '<td align="center" style="padding-right:22px" ><span class="retiraAncoraPadraoAzul">'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'</span>';
   				}
   				
   				
   			}
   			
   			$strResultado .= '<td align="center">'.PaginaSEIExterna::getInstance()->formatarXHTML($objDocumentoDTO->getStrNomeSerie().' '.$objDocumentoDTO->getStrNumero()).'</td>
  																	<td align="center">'.$objProtocoloPesquisaPublicaDTO->getDtaDocumento().'</td>
  																	<td align="center">'.$objProtocoloPesquisaPublicaDTO->getDtaRegistro().'</td>
  																	<td align="center"><a alt="'.$objDocumentoDTO->getStrDescricaoUnidadeGeradoraProtocolo().'" title="'.$objDocumentoDTO->getStrDescricaoUnidadeGeradoraProtocolo().'" class="ancoraSigla">'.$objDocumentoDTO->getStrSiglaUnidadeGeradoraProtocolo().'</a></td>
  																	<td align="center" class="colunaAcoes">';
   				
   			$strResultado .='</td></tr>';
   	
   		}else if($objProtocoloPesquisaPublicaDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO){
   	
   			
   			$strResultado .= '<tr class="infraTrClara">';
   			$strResultado .= '<td>&nbsp;</td>';
   			$strHipoteseLegalAnexo = '';
   			$strProtocoloRestrito = '';
   			
   			$objProcedimentoDTOAnexado = $objProtocoloPesquisaPublicaDTO->getObjProcedimentoDTO();
   			
   			// cria indica��o de acesso restrito com hipotese legal.
   			if($objProcedimentoDTOAnexado->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_RESTRITO){
   					
   				$strHipoteseLegalAnexo = '';
   				$objProtocoloAnexoDTO = new ProtocoloDTO();
   				$objProtocoloAnexoDTO->setDblIdProtocolo($objProcedimentoDTOAnexado->getDblIdProcedimento());
   				$objProtocoloAnexoDTO->retNumIdHipoteseLegal();
   					
   				$objProtocoloRN = new ProtocoloRN();
   				$objProtocoloAnexoDTO = $objProtocoloRN->consultarRN0186($objProtocoloAnexoDTO);
   					
   				if($objProtocoloAnexoDTO != null){
   			
   					$objHipoteseLegaAnexoDTO = new HipoteseLegalDTO();
   					$objHipoteseLegaAnexoDTO->setNumIdHipoteseLegal($objProtocoloAnexoDTO->getNumIdHipoteseLegal());
   					$objHipoteseLegaAnexoDTO->retStrNome();
   					$objHipoteseLegaAnexoDTO->retStrBaseLegal();
   			
   					$objHipoteseLegalRN = new HipoteseLegalRN();
   					$objHipoteseLegaDocumentoDTO = $objHipoteseLegalRN->consultar($objHipoteseLegaAnexoDTO);
   			
   			
   					if($objHipoteseLegaDocumentoDTO != null){
   							
   						$strHipoteseLegalAnexo .= $objHipoteseLegaDocumentoDTO->getStrNome().' ('.$objHipoteseLegaDocumentoDTO->getStrBaseLegal().')';
   					}
   				}
   				$strProtocoloRestrito .= '<img src="imagens/sei_chave_restrito.gif" align="absbottom"  title="Acesso Restrito.&#13'.$strHipoteseLegalAnexo.'">';
   			}
   			
   			if($objProcedimentoDTOAnexado->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_PUBLICO && $objProcedimentoDTO->getStrStaNivelAcessoLocalProtocolo() == ProtocoloRN::$NA_PUBLICO ){
   				$parametrosCriptografadosProcesso = MdPesqCriptografia::criptografa('id_orgao_acesso_externo=0&id_procedimento='.$objProcedimentoDTOAnexado->getDblIdProcedimento());
   				$urlPesquisaProcesso = 'md_pesq_processo_exibir.php?'.$parametrosCriptografadosProcesso;
   				
   				// $strLinkProcessoAnexado = PaginaSEIExterna::getInstance()->formatarXHTML(SessaoSEIExterna::getInstance()->assinarLink('processo_acesso_externo_consulta.php?id_acesso_externo='.$_GET['id_acesso_externo'].'&id_acesso_externo_assinatura='.$_GET['id_acesso_externo_assinatura'].'&id_procedimento_anexado='.$objProcedimentoDTOAnexado->getDblIdProcedimento()));
   					
   				$strLinkProcessoAnexado = PaginaSEI::getInstance()->formatarXHTML(SessaoSEI::getInstance()->assinarLink(MdPesqSolrUtilExterno::prepararUrl($urlPesquisaProcesso)));
   				
   				
   				$strResultado .= '<td align="center"><a href="javascript:void(0);" onclick="window.open(\''.$strLinkProcessoAnexado.'\');" alt="'.$objProcedimentoDTOAnexado->getStrNomeTipoProcedimento().'" title="'.$objProcedimentoDTOAnexado->getStrNomeTipoProcedimento().'" class="ancoraPadraoAzul">'.$objProcedimentoDTOAnexado->getStrProtocoloProcedimentoFormatado().'</a>'.$strProtocoloRestrito.'</td>';
   				
   			}else{
   				
   				$strResultado .= '<td align="center" style="padding-right:22px" ><span class="retiraAncoraPadraoAzul">'.PaginaSEIExterna::getInstance()->formatarXHTML($objProcedimentoDTOAnexado->getStrProtocoloProcedimentoFormatado()).' </span>'.$strProtocoloRestrito.'</td>';
   						
   			}
   			
  			$strResultado.=	'<td align="center">'.PaginaSEIExterna::getInstance()->formatarXHTML($objProcedimentoDTOAnexado->getStrNomeTipoProcedimento()).'</td>
  																	<td align="center">'.$objProtocoloPesquisaPublicaDTO->getDtaDocumento().'</td>
  																	<td align="center">'.$objProtocoloPesquisaPublicaDTO->getDtaRegistro().'</td>
  																	<td align="center"><a alt="'.$objProcedimentoDTOAnexado->getStrDescricaoUnidadeGeradoraProtocolo().'" title="'.$objProcedimentoDTOAnexado->getStrDescricaoUnidadeGeradoraProtocolo().'" class="ancoraSigla">'.$objProcedimentoDTOAnexado->getStrSiglaUnidadeGeradoraProtocolo().'</a></td>
  																	<td align="center" class="colunaAcoes">&nbsp;</td>';
   			$strResultado .='</tr>';
   	
   		}
   	}
   	
   	$strResultado.='</table>';
  									
	}	


	$arrComandos = array();
	if ($numDocumentosPdf > 0){
		if($bolCaptchaGerarPdf){
			$strComando = '<button type="button" accesskey="G" name="btnGerarPdfModal" value="Gerar PDF" onclick="gerarPdfModal();" class="infraButton"><span class="infraTeclaAtalho">G</span>erar PDF</button>';
		}else{
			$strComando = '<button type="button" accesskey="G" name="btnGerarPdfModal" value="Gerar PDF" onclick="gerarPdf();" class="infraButton"><span class="infraTeclaAtalho">G</span>erar PDF</button>';
		}
		
		$arrComandos[] = $strComando;
		
	}
 	
 	//Carregar hist�rico
 
  $numRegistrosAtividades = 0;

  
  if(($bolListaAndamentoProcessoPublico && $objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo() == ProtocoloRN::$NA_PUBLICO) || 
  	 ($bolListaAndamentoProcessoRestrito && $objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo() == ProtocoloRN::$NA_RESTRITO) ){
  
  	$objProcedimentoHistoricoDTO = new ProcedimentoHistoricoDTO();
  	$objProcedimentoHistoricoDTO->setDblIdProcedimento($dblIdProcedimento);
  	$objProcedimentoHistoricoDTO->setStrStaHistorico(ProcedimentoRN::$TH_EXTERNO);
  	$objProcedimentoHistoricoDTO->setStrSinGerarLinksHistorico('N');
  	 
  	$objProcedimentoRN = new ProcedimentoRN();
  	$objProcedimentoDTORet = $objProcedimentoRN->consultarHistoricoRN1025($objProcedimentoHistoricoDTO);
  	$arrObjAtividadeDTO = $objProcedimentoDTORet->getArrObjAtividadeDTO();
  	 
  	$numRegistrosAtividades = count($arrObjAtividadeDTO);
  }
  	
	
 

  if ($numRegistrosAtividades > 0){
    
    $bolCheck = false;

    $strResultadoAndamentos = '';

    $strResultadoAndamentos .= '<table id="tblHistorico" width="99.3%" class="infraTable" summary="Hist�rico de Andamentos">'."\n";    
    $strResultadoAndamentos .= '<caption class="infraCaption">'.PaginaSEIExterna::getInstance()->gerarCaptionTabela('Andamentos',$numRegistrosAtividades).'</caption>';
		$strResultadoAndamentos .= '<tr>';
		$strResultadoAndamentos .= '<th class="infraTh" width="20%">Data/Hora</th>';
		$strResultadoAndamentos .= '<th class="infraTh" width="10%">Unidade</th>';
		$strResultadoAndamentos .= '<th class="infraTh">Descri��o</th>';
		$strResultadoAndamentos .= '</tr>'."\n";					

		$strQuebraLinha = '<span style="line-height:.5em"><br /></span>';
		 
		
    foreach($arrObjAtividadeDTO as $objAtividadeDTO){    	
        
        //InfraDebug::getInstance()->gravar($objAtividadeDTO->getNumIdAtividade());
      
        $strResultadoAndamentos .= "\n\n".'<!-- '.$objAtividadeDTO->getNumIdAtividade().' -->'."\n";
        
				if ($objAtividadeDTO->getStrSinUltimaUnidadeHistorico() == 'S'){		
					$strAbertas = 'class="andamentoAberto"';
				}else{
					$strAbertas = 'class="andamentoConcluido"';
				}	
				
				$strResultadoAndamentos .= '<tr '.$strAbertas.'>';		
				$strResultadoAndamentos .= "\n".'<td align="center">';
			  $strResultadoAndamentos .= substr($objAtividadeDTO->getDthAbertura(),0,16);
				$strResultadoAndamentos .= '</td>';
				
				$strResultadoAndamentos .= "\n".'<td align="center">';
			  $strResultadoAndamentos .= '<a alt="'.$objAtividadeDTO->getStrDescricaoUnidade().'" title="'.$objAtividadeDTO->getStrDescricaoUnidade().'" class="ancoraSigla">'.$objAtividadeDTO->getStrSiglaUnidade().'</a>';
				$strResultadoAndamentos .= '</td>';
				
				$strResultadoAndamentos .= "\n";
			  $strResultadoAndamentos .= "\n".'<td>';

				if (!InfraString::isBolVazia($objAtividadeDTO->getStrNomeTarefa())){
					$strResultadoAndamentos .= nl2br($objAtividadeDTO->getStrNomeTarefa()).$strQuebraLinha;
				}
					
				$strResultadoAndamentos .= '</td>';
					
				$strResultadoAndamentos .= '</tr>';				
  	}
    $strResultadoAndamentos .= '</table><br />';
  }
  
  
  
  AuditoriaSEI::getInstance()->auditar('processo_consulta_externa', __FILE__, strip_tags($strResultadoCabecalho)."\n".strip_tags($strResultado));
  
  if ($_POST['hdnFlagGerar']=='1'){

  		if(md5($_POST['txtCaptcha']) != $_POST['hdnCaptchaMd5'] && $_GET['hash'] !=  $_POST['hdnCaptchaMd5'] && $bolCaptchaGerarPdf == true){
  			PaginaSEIExterna::getInstance()->setStrMensagem('C�digo de confirma��o inv�lido.');
  		
  		}else {

			$objDocumentoRN = new DocumentoRN();

  			$parArrObjDocumentoDTO = InfraArray::converterArrInfraDTO(InfraArray::gerarArrInfraDTO('DocumentoDTO','IdDocumento',PaginaSEIExterna::getInstance()->getArrStrItensSelecionados()),'IdDocumento');
  			$objDocumentoDTO = new DocumentoDTO();
  			$objDocumentoDTO->retDblIdDocumento();
  			$objDocumentoDTO->setDblIdDocumento($parArrObjDocumentoDTO, InfraDTO::$OPER_IN);
  			$objDocumentoDTO->retDblIdProcedimento();
  			$objDocumentoDTO->retStrStaNivelAcessoGlobalProtocolo();
  			$objDocumentoDTO->retStrStaNivelAcessoLocalProtocolo();
			$arrObjDocumentoDTO = $objDocumentoRN->listarRN0008($objDocumentoDTO);

			$arrSelecionados = PaginaSEIExterna::getInstance()->getArrStrItensSelecionados();

			foreach ($arrObjDocumentoDTO as $objDocumentoDTO){

  				//Alterardo para atender o pedido da anatel para gerar pdf de documentos de nivel de acesso local = P�blico e de Procedimentos P�blicos mesmo se o nivel global for restrito
  				if($bolListaDocumentoProcessoRestrito){
  					if($objDocumentoDTO->getDblIdProcedimento() != $dblIdProcedimento || $objDocumentoDTO->getStrStaNivelAcessoLocalProtocolo() != ProtocoloRN::$NA_PUBLICO || $objProcedimentoDTO->getStrStaNivelAcessoLocalProtocolo() != ProtocoloRN::$NA_PUBLICO){
  						die ("Erro ao Gerar Pdf");
  					}

					//Protege acesso � documento p�blico de intima��o eletr�nica
					$objInfraParametroDTO = $objParametroPesquisaRN->consultarVersaoPeticionamento('2.0.0');
					if( !is_null($objInfraParametroDTO) ){
						$objMdPetIntCertidaoRN =  new MdPetIntCertidaoRN();
						if( !$objMdPetIntCertidaoRN->verificaDocumentoEAnexoIntimacaoNaoCumprida( array($objDocumentoDTO->getDblIdDocumento(),false,false,true) ) ){
							$idx_documento = array_search($objDocumentoDTO->getDblIdDocumento(), $arrSelecionados);
							unset($arrSelecionados[$idx_documento]);
						}
					}
				}else if($bolListaDocumentoProcessoPublico){
					if($objDocumentoDTO->getDblIdProcedimento() != $dblIdProcedimento || $objDocumentoDTO->getStrStaNivelAcessoGlobalProtocolo() != ProtocoloRN::$NA_PUBLICO){
  						die ("Erro ao Gerar Pdf");
  					}
  				}else{
  					die ("Erro ao Gerar Pdf");
  				}
  				
  			
			}

			if (count($arrSelecionados)==0){
				die ("Sem documento a gerar");
			}

			$arrSelecionados = array_values($arrSelecionados);

			$objDocumentoRN = new DocumentoRN();
			$objAnexoDTO = $objDocumentoRN->gerarPdf(InfraArray::gerarArrInfraDTO('DocumentoDTO','IdDocumento',$arrSelecionados));

			$bolGeracaoOK = true;
  		
  		}
  
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
echo $strCssMostrarAcoes;
?>

div.infraBarraSistemaE {width:90%}
div.infraBarraSistemaD {width:5%}
div.infraBarraComandos {width:99%}

table caption {
  text-align:left !important;
  font-size: 1.2em;
  font-weight:bold;
}

.andamentoAberto {
  background-color:white;
}

.andamentoConcluido {
  background-color:white;
}


#tblCabecalho{margin-top:1;}
#tblDocumentos {margin-top:1.5em;}
#tblHistorico {margin-top:1.5em;}

<? if($bolCaptchaGerarPdf) { ?>
#lblCaptcha {position: absolute; top:30%; left: 20%; width: 80%}
#txtCaptcha{position: absolute; top:56%; left: 20%; height:15%; width:56%;font-size: 3em;}
#btnEnviarCaptcha {position: absolute; top:80%; left: 20%; width:56%}

#divInfraModal{
	
	display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 50%; 
    height: 50%; 
    overflow: auto;
   
}



.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-image: url("imagens/bg_barra_sistema.jpg");
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
<? } ?>

span.retiraAncoraPadraoAzul{font-size: 1.2em;}

<?
PaginaSEIExterna::getInstance()->fecharStyle();
PaginaSEIExterna::getInstance()->montarJavaScript();
PaginaSEIExterna::getInstance()->abrirJavaScript();
?>

function inicializar(){

  <?if ($bolGeracaoOK){?>
    
  	window.open('<?=SessaoSEI::getInstance()->assinarLink('md_pesq_processo_exibe_arquivo.php?'.MdPesqCriptografia::criptografa('acao_externa=usuario_externo_exibir_arquivo&acao_origem_externa=protocolo_pesquisar&id_orgao_acesso_externo=0&nome_arquivo='.$objAnexoDTO->getStrNome().'&nome_download=SEI-'.$objProcedimentoDTO->getStrProtocoloProcedimentoFormatado().'.pdf'));?>');
  	
  <?}?>

  infraEfeitoTabelas();
}


<?
if($bolCaptchaGerarPdf){ 
?>

$(document).unbind("keyup").keyup(function(e){
	e.preventDefault();
    var code = e.which;
    if(code==13){
    	var modal = document.getElementById('divInfraModal');
        if(modal.style.display == "block"){
        	fecharPdfModal();
        	gerarPdf();
    		
    	}
    }
});



function gerarPdfModal(){

	if (document.getElementById('hdnInfraItensSelecionados').value==''){
    	alert('Nenhum documento selecionado.');
    	return;
  	}
	var modal = document.getElementById('divInfraModal');
	modal.style.display = "block";

}

function fecharPdfModal(){
	
    var modal = document.getElementById('divInfraModal');
	modal.style.display = "none";
}

window.onclick = function(event) {
	var modal = document.getElementById('divInfraModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

<?
}
?>

function gerarPdf() {
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum documento selecionado.');
    return;
  }
  
  <?
	if($bolCaptchaGerarPdf){ 
  ?>
  	fecharPdfModal();
  <?
	}
  ?>

  infraExibirAviso(false);
  
 document.getElementById('hdnFlagGerar').value = '1';
 document.getElementById('frmProcessoAcessoExternoConsulta').submit();
}

<?
PaginaSEIExterna::getInstance()->fecharJavaScript();
PaginaSEIExterna::getInstance()->fecharHead();
PaginaSEIExterna::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>

<form id="frmProcessoAcessoExternoConsulta" method="post">
<?
if($bolCaptchaGerarPdf){
	echo ' 
 		<div id="divInfraModal" class="infraFundoTransparente" style="position: fixed; width: 100%; height: 100%; visibility: visible;">
 		   <div id="divCaptcha"  class="infraAreaDados" style="height: 220px; width: 230px; background-color:white">
 				<div class="modal-header">
      				<span id="spnClose" class="close" onclick="fecharPdfModal();">�</span>
      				<h2 style ="color: white;font-size: 1.2em;font-weight: bold;">Digite o C�digo da Imagem</h2>
    			</div>
 				<div class="modal-body">
 		   			<label id="lblCaptcha" accesskey="" class="infraLabelObrigatorio">
		   			<img src="/infra_js/infra_gerar_captcha.php?codetorandom='.$strCodigoParaGeracaoCaptcha.'" alt="N�o foi poss�vel carregar imagem de confirma��o" /> </label>
		   			<input type="text" id="txtCaptcha" name="txtCaptcha" class="infraText" maxlength="4" value="" />
  					<button id="btnEnviarCaptcha" type="submit" accesskey="G" name="btnEnviarCaptcha" value="Enviar" onclick="gerarPdf();" class="infraButton"><span class="infraTeclaAtalho">E</span>nviar</button>
  		   		</div>
    			
  			</div>
    	</div>
  			';
			
}
PaginaSEIExterna::getInstance()->montarBarraComandosSuperior($arrComandos);
echo $strResultadoCabecalho;
echo $strMensagemProcessoRestrito;
PaginaSEIExterna::getInstance()->montarAreaTabela($strResultado,$numProtocolos);
echo $strResultadoAndamentos;
?>
<input type="hidden" id="hdnFlagGerar" name="hdnFlagGerar" value="0" />
 <?if($bolCaptchaGerarPdf) { ?>
    	<input type="hidden" id="hdnCaptchaMd5" name="hdnCaptchaMd5" class="infraText" value="<?=md5(InfraCaptcha::gerar($strCodigoParaGeracaoCaptcha));?>" />
  	<?} ?>
</form>
<?
PaginaSEIExterna::getInstance()->montarAreaDebug();

if($bolGeracaoOK){
	?>
	<script>
	if (navigator.userAgent.match(/msie/i) || navigator.userAgent.match(/trident/i) ){
	
		window.open('<?=SessaoSEI::getInstance()->assinarLink('md_pesq_processo_exibe_arquivo.php?'.MdPesqCriptografia::criptografa('acao_externa=usuario_externo_exibir_arquivo&acao_origem_externa=protocolo_pesquisar&id_orgao_acesso_externo=0&nome_arquivo='.$objAnexoDTO->getStrNome().'&nome_download=SEI-'.$objProcedimentoDTO->getStrProtocoloProcedimentoFormatado().'.pdf'));?>');     
			<?
					if($bolCaptchaGerarPdf){ 
					?>

					$(document).unbind("keyup").keyup(function(e){
						e.preventDefault();
					    var code = e.which;
					    if(code==13){
					    	var modal = document.getElementById('divInfraModal');
					        if(modal.style.display == "block"){
					        	fecharPdfModal();
					        	gerarPdf();
					    		
					    	}
					    }
					});



					function gerarPdfModal(){

						if (document.getElementById('hdnInfraItensSelecionados').value==''){
					    	alert('Nenhum documento selecionado.');
					    	return;
					  	}
						var modal = document.getElementById('divInfraModal');
						modal.style.display = "block";

					}

					function fecharPdfModal(){
						
					    var modal = document.getElementById('divInfraModal');
						modal.style.display = "none";
					}

					window.onclick = function(event) {
						var modal = document.getElementById('divInfraModal');
					    if (event.target == modal) {
					        modal.style.display = "none";
					    }
					}

					<?
					}
					?>

					function gerarPdf() {

					  if (document.getElementById('hdnInfraItensSelecionados').value==''){
					    alert('Nenhum documento selecionado.');
					    return;
					  }
					  
					  <?
						if($bolCaptchaGerarPdf){ 
					  ?>
					  	fecharPdfModal();
					  <?
						}
					  ?>

					  infraExibirAviso(false);
					  
					 document.getElementById('hdnFlagGerar').value = '1';
					 document.getElementById('frmProcessoAcessoExternoConsulta').submit();
					}
	}
	</script>
<?
}
PaginaSEIExterna::getInstance()->fecharBody();
PaginaSEIExterna::getInstance()->fecharHtml();
?>