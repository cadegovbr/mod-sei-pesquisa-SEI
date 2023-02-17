<?
/**
* CONSELHO ADMINISTRATIVO DE DEFESA ECONOMICA
*
* 29/11/2016 - criado por alex
*
* Vers�o do Gerador de C�digo: 1.39.0
*/

require_once dirname(__FILE__).'/../../../SEI.php';

class MdPesqParametroPesquisaRN extends InfraRN {
	
  public static $TA_AUTO_COMPLETAR_INTERESSADO = 'AUTO_COMPLETAR_INTERESSADO';
  public static $TA_CAPTCHA = 'CAPTCHA';
  public static $TA_CAPTCHA_PDF = 'CAPTCHA_PDF';
  public static $TA_CHAVE_CRIPTOGRAFIA = 'CHAVE_CRIPTOGRAFIA';
  public static $TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO = 'DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO';
  public static $TA_DOCUMENTO_PROCESSO_PUBLICO = 'DOCUMENTO_PROCESSO_PUBLICO';
  public static $TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO = 'LISTA_ANDAMENTO_PROCESSO_PUBLICO';
  public static $TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO = 'LISTA_ANDAMENTO_PROCESSO_RESTRITO';
  public static $TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO = 'LISTA_DOCUMENTO_PROCESSO_PUBLICO';
  public static $TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO = 'LISTA_DOCUMENTO_PROCESSO_RESTRITO';
  public static $TA_MENU_USUARIO_EXTERNO = 'MENU_USUARIO_EXTERNO';
  public static $TA_METADADOS_PROCESSO_RESTRITO = 'METADADOS_PROCESSO_RESTRITO';
  public static $TA_PROCESSO_RESTRITO = 'PROCESSO_RESTRITO';

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }
  
  protected function consultarConectado(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO){
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
  		throw new InfraException('Erro consultando Par�metro da Pesquisa.',$e);
  	}
  }
  
  protected function alterarParametrosControlado($objArrParametroPesquisaDTO){
  	
  	try {
  		
  		// validaPermissao
  		SessaoSEI::getInstance()->validarAuditarPermissao('md_pesq_parametro_alterar',__METHOD__,$objArrParametroPesquisaDTO);
  		foreach ($objArrParametroPesquisaDTO as $objParametroPesquisaDTO){
  			$this->alterar($objParametroPesquisaDTO);
  		}
  		
  	} catch (Exception $e) {
  		throw new InfraException('Erro alterando Configura��es da Pesquisa.',$e);
  	}
  }


  protected function alterarControlado(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO){
    try {

      //Valida Permissao
		SessaoSEI::getInstance()->validarAuditarPermissao('md_pesq_parametro_alterar',__METHOD__,$objParametroPesquisaDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objParametroPesquisaDTO->isSetStrNome()){
        $this->validarStrNome($objParametroPesquisaDTO, $objInfraException);
      }
      if ($objParametroPesquisaDTO->isSetStrValor()){
        $this->validarStrValor($objParametroPesquisaDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      $objParametroPesquisaBD->alterar($objParametroPesquisaDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Par�metro da Pesquisa.',$e);
    }
  }


  protected function listarConectado(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO) {
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
      throw new InfraException('Erro listando Par�metro da Pesquisas.',$e);
    }
  }


  protected function consultarVersaoPeticionamentoConectado($versao=null){
	$arrModulos = ConfiguracaoSEI::getInstance()->getValor('SEI','Modulos');
	if(is_array($arrModulos) && array_key_exists('PeticionamentoIntegracao', $arrModulos)){
		$objInfraParametroDTO = new InfraParametroDTO();
		$objInfraParametroDTO->setStrNome('VERSAO_MODULO_PETICIONAMENTO');
		$objInfraParametroDTO->retStrValor();

		$objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
		$arrObjInfraParametroDTO = $objInfraParametroBD->consultar($objInfraParametroDTO);

		//vers�o do parametro � igual ou maior que a enviada
		if (!is_null($versao)){
			if (count($arrObjInfraParametroDTO)>0){
				$arr_versao_parametro = explode('.',$arrObjInfraParametroDTO->getStrValor());
				$arr_versao = explode('.',$versao);
				for ($i=0;$i<count($arr_versao_parametro);$i++){
					if (isset($arr_versao[$i])) {
						if( intval($arr_versao_parametro[$i]) < intval($arr_versao[$i]) ){
							return null;
						}else if( intval($arr_versao_parametro[$i]) > intval($arr_versao[$i]) ){
							return $arrObjInfraParametroDTO;
						}
					}
				}
			}
		}
		return $arrObjInfraParametroDTO;
	}else{
		return null;
	}
  }

  private function validarStrNome(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO, InfraException $objInfraException){
  	if (InfraString::isBolVazia($objParametroPesquisaDTO->getStrNome())){
  		$objInfraException->adicionarValidacao('Nome n�o informado.');
  	}else{
  		$objParametroPesquisaDTO->setStrNome(trim($objParametroPesquisaDTO->getStrNome()));
  
  		if (strlen($objParametroPesquisaDTO->getStrNome())>100){
  			$objInfraException->adicionarValidacao('Nome possui tamanho superior a 100 caracteres.');
  		}
  	}
  }
  
  private function validarStrValor(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO, InfraException $objInfraException){
  	if (InfraString::isBolVazia($objParametroPesquisaDTO->getStrValor())){
  		$objParametroPesquisaDTO->setStrValor(null);
  	}else{
  		$objParametroPesquisaDTO->setStrValor(trim($objParametroPesquisaDTO->getStrValor()));
  	}
  }
 
 
 protected function cadastrarControlado(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('md_pesq_parametro_cadastrar',__METHOD__,$objParametroPesquisaDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrNome($objParametroPesquisaDTO, $objInfraException);
      $this->validarStrValor($objParametroPesquisaDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      $ret = $objParametroPesquisaBD->cadastrar($objParametroPesquisaDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Par�metro da Pesquisa.',$e);
    }
  }
 
  /*
  
  protected function consultarConectado(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      $ret = $objParametroPesquisaBD->consultar($objParametroPesquisaDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Par�metro da Pesquisa.',$e);
    }
  }
  
  protected function contarConectado(MdPesqParametroPesquisaDTO $objParametroPesquisaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_listar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      $ret = $objParametroPesquisaBD->contar($objParametroPesquisaDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Par�metro da Pesquisas.',$e);
    }
  }
  
  protected function excluirControlado($arrObjParametroPesquisaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_excluir');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjParametroPesquisaDTO);$i++){
        $objParametroPesquisaBD->excluir($arrObjParametroPesquisaDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Par�metro da  Pesquisa.',$e);
    }
  }
 
  protected function desativarControlado($arrObjParametroPesquisaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjParametroPesquisaDTO);$i++){
        $objParametroPesquisaBD->desativar($arrObjParametroPesquisaDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Par�metro da Pesquisa.',$e);
    }
  }

  protected function reativarControlado($arrObjParametroPesquisaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjParametroPesquisaDTO);$i++){
        $objParametroPesquisaBD->reativar($arrObjParametroPesquisaDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Par�metro da Pesquisa.',$e);
    }
  }

  protected function bloquearControlado(ParametroPesquisaDTO $objParametroPesquisaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarPermissao('md_pesq_parametro_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroPesquisaBD = new MdPesqParametroPesquisaBD($this->getObjInfraIBanco());
      $ret = $objParametroPesquisaBD->bloquear($objParametroPesquisaDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Par�metro da Pesquisa.',$e);
    }
  }

 */
}
?>