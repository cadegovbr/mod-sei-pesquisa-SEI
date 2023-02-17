<?
/**
 * ANATEL
 *
 * 21/10/2021 - criado por Miguel Costa
 *
 */

require_once dirname(__FILE__).'/../../../SEI.php';

class MdPesqTipoProcessoINT extends InfraINT {


  public static function montarSelectTipoDocumento($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objMdPetTipoProcessoRN      = new MdPetTipoProcessoRN();

    $arrObjTipoDocumentoPeticionamentDTO = $objMdPetTipoProcessoRN->listarValoresTipoDocumento();

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoDocumentoPeticionamentDTO, 'TipoDoc', 'Descricao');

  }

  public static function montarSelectTipoProcesso($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTipoProcedimentoRN  = new TipoProcedimentoRN();

    $objTipoProcedimento      = new TipoProcedimentoDTO();
    $objTipoProcedimento->retTodos();
    //listarRN0244Conectado
    $arrObjTiposProcessoDTO = $objTipoProcedimentoRN->listarRN0244($objTipoProcedimento);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTiposProcessoDTO, 'IdTipoProcedimento', 'Nome');

  }


  public static function autoCompletarTipoProcedimento($strPalavrasPesquisa, $itensSelecionados = null){
    $objTipoProcedimentoDTO = new TipoProcedimentoDTO();
    $objTipoProcedimentoDTO->retNumIdTipoProcedimento();
    $objTipoProcedimentoDTO->retStrNome();
    $objTipoProcedimentoDTO->setOrd('Nome', InfraDTO::$TIPO_ORDENACAO_ASC);

    $objTipoProcedimentoRN = new TipoProcedimentoRN();
    $arrObjTipoProcedimentoDTO = $objTipoProcedimentoRN->listarRN0244($objTipoProcedimentoDTO);


    if ($strPalavrasPesquisa != '' || $itensSelecionados != null) {
      $ret = array();
      $strPalavrasPesquisa = strtolower($strPalavrasPesquisa);
      foreach($arrObjTipoProcedimentoDTO as $objTipoProcedimentoDTO){
        if($itensSelecionados != null && in_array($objTipoProcedimentoDTO->getNumIdTipoProcedimento(), $itensSelecionados)){
          continue;
        }
        if ($strPalavrasPesquisa != '' && strpos(strtolower($objTipoProcedimentoDTO->getStrNome()),$strPalavrasPesquisa)===false){
          continue;
        }

        //checando se o tipo de processo informado possui sugestao de assunto

        $rnAssunto = new RelTipoProcedimentoAssuntoRN();
        $dto = new RelTipoProcedimentoAssuntoDTO();
        $dto->retTodos();
        $dto->setNumIdTipoProcedimento( $objTipoProcedimentoDTO->getNumIdTipoProcedimento() );

        $arrAssuntos = $rnAssunto->listarRN0192( $dto );

        if( is_array( $arrAssuntos ) && count( $arrAssuntos ) > 0 ){
          $ret[] = $objTipoProcedimentoDTO;
        }
      }
    }
    return $ret;
  }

  public static function gerarXMLItensArrInfraApi($arr, $strAtributoId, $strAtributoDescricao, $strAtributoComplemento=null, $strAtributoGrupo=null){
    $metodoAtributoId = "get{$strAtributoId}";
    $metodoAtributoDescricao = "get{$strAtributoDescricao}";
    $metodoAtributoComplemento = "get{$strAtributoComplemento}";
    $metodoAtributoGrupo = "get{$strAtributoGrupo}";

    $xml = '';
    $xml .= '<itens>';
    if ($arr !== null ){
      foreach($arr as $dto){
        $xml .= '<item id="'.self::formatarXMLAjax($dto->$metodoAtributoId()).'"';
        $xml .= ' descricao="'.self::formatarXMLAjax($dto->$metodoAtributoDescricao()).'"';

        if ($strAtributoComplemento!==null){
          $xml .= ' complemento="'.self::formatarXMLAjax($dto->$metodoAtributoComplemento()).'"';
        }

        if ($strAtributoGrupo!==null){
          $xml .= ' grupo="'.self::formatarXMLAjax($dto->$metodoAtributoGrupo()).'"';
        }

        $xml .= '></item>';
      }
    }
    $xml .= '</itens>';
    return $xml;
  }

  private static function formatarXMLAjax($str){
    if (!is_numeric($str)){
      $str = str_replace('&','&amp;',$str);
      $str = str_replace('<','&amp;lt;',$str);
      $str = str_replace('>','&amp;gt;',$str);
      $str = str_replace('\"','&amp;quot;',$str);
      $str = str_replace('"','&amp;quot;',$str);
      //$str = str_replace("\n",'_',$str);
    }
    return $str;
  }

}