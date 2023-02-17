<?
/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECONOMICA
 *
 * 21/10/2021 - criado por Miguel Costa
 *
 * Versão do Gerador de Código: 1.39.0
 */

require_once dirname(__FILE__).'/../../../SEI.php';

class MdPesqTipoProcessoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  protected function consultarConectado(MdPesqTipoProcessoDTO $objParametroPesquisaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_consultar',__METHOD__,$objParametroPesquisaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      $ret = $objParametroPesquisaBD->consultar($objParametroPesquisaDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Parâmetro da Pesquisa.',$e);
    }
  }

  protected function alterarParametrosControlado($objArrParametroPesquisaDTO){

    try {

      // validaPermissao
      SessaoSEI::getInstance()->validarAuditarPermissao('md_pesq_parametro_alterar',__METHOD__,$objArrParametroPesquisaDTO);

      $objetoDTO = new MdPesqTipoProcessoDTO();
      $objetoDTO->retNumIdPesqTipoProcesso();
      $objetoDTO->retNumId();
      $objetoDTO->retStrSinAtivo();
      $objetoDTO->setBolExclusaoLogica(false);


      $objBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());

      $listarDtoBD =$objBD->listar($objetoDTO);

      foreach ($objArrParametroPesquisaDTO as $lista){

        $filtro = array_values(array_filter($listarDtoBD, function ($dtoBD) use ($lista) {;
          return $dtoBD->getNumId() === $lista->getNumId();
        }));

        if(!$filtro){
          $objBD->cadastrar($lista);
        } else{
          $lista->setNumIdPesqTipoProcesso($filtro[0]->getNumIdPesqTipoProcesso());
          $objBD->alterar($lista);
          $listarDtoBD = (array_diff($listarDtoBD, $filtro));

        }
      }
      foreach ($listarDtoBD as $dtoBD){
        $dtoBD->setStrSinAtivo('N');
        $objBD->alterar($dtoBD);

      }
    } catch (Exception $e) {
      throw new InfraException('Erro alterando Configurações da Pesquisa.',$e);
    }
  }


  protected function listarConectado(MdPesqTipoProcessoDTO $objParametroPesquisaDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_listar',__METHOD__,$objParametroPesquisaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      $ret = $objParametroPesquisaBD->listar($objParametroPesquisaDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Parâmetro da Pesquisas.',$e);
    }
  }


}
?>