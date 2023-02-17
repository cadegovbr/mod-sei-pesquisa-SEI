<?
/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECON�MICA
 * 2014-09-29
 * Vers�o do Gerador de C�digo: 1.0
 * Vers�o no CVS/SVN:
 *
 * sei
 * pesquisa
 * controlador_ajax_externo
 *
 *
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 */

/**
 * Arquivo para realizar criptografia de parametros.
 *
 *
 * @package institucional_pesquisa_controlador_ajax_externo
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 * @license Creative Commons Atribui��o 3.0 n�o adaptada
 *          <http://creativecommons.org/licenses/by/3.0/deed.pt_BR>
 * @ignore Este c�digo � livre para uso sem nenhuma restri��o,
 *         salvo pelas informa��es a seguir referentes
 *         a @author e @copyright que devem ser mantidas inalteradas!
 * @copyright Conselho Administrativo de Defesa Econ�mica �2014-2018
 *            <http://www.cade.gov.br>
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 */

/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECON�MICA
*
* 01/09/2014 - criado por alex braga
*
* Vers�o do Gerador de C�digo:
*
* Vers�o no CVS:
*/

	
	 class MdPesqCriptografia{
	 	
	 	private static $KEY = 'c@d3s3mp@p3l';
	 	
	 	public static function criptografa($texto){
	 		try {
	 			
	 			return strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(MdPesqCriptografia::getChaveCriptografia()), serialize($texto), MCRYPT_MODE_CBC, md5(md5(MdPesqCriptografia::getChaveCriptografia())))), '+/=', '-_,');
	 			
	 			
	 		} catch (Exception $e) {
	 		
	 			throw new InfraException('Erro validando link externo.',$e);
	 		}
	 	}
	 	
	 	public static  function descriptografa($texto){
	 		try {
	 		
	 			return unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(MdPesqCriptografia::getChaveCriptografia()), base64_decode(strtr($texto, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5(MdPesqCriptografia::getChaveCriptografia()))), "\0"));
	 		} catch (Exception $e) {
	 			
	 			throw new InfraException('Erro validando link externo.',$e);
	 		}
	 	}
	 	
	 	private static function getChaveCriptografia(){
	 		
	 		$objParametroPesquisaDTO = new MdPesqParametroPesquisaDTO();
	 		$objParametroPesquisaDTO->setStrNome(MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA);
	 		$objParametroPesquisaDTO->retStrValor();
	 		$objParametroPesquisaDTO->retStrNome();
	 		
	 		$objParametroPesquisaRN = new MdPesqParametroPesquisaRN();
	 		
	 		$objParametroPesquisaDTO = $objParametroPesquisaRN->consultar($objParametroPesquisaDTO);
	 		
	 		if($objParametroPesquisaDTO != null && !empty($objParametroPesquisaDTO->getStrValor())){
	 			
	 			return  $objParametroPesquisaDTO->getStrValor();
	 		}
	 		
	 		return $KEY;
	 	}
		
	 	//Esta criptografia � usada no site do cade;
	 	//Alterar metodo de criptografia por uma criptografia php.
	 	public static function criptografaSiteCade($texto){
	 	
	 		$caminho = dirname(__FILE__).'/criptografia/mascaraArgumentos.jar';
	 		$instrucao = 'java -jar '.$caminho.' \'criptografa\' \''.$texto.'\' \''.MdPesqCriptografia::$KEY.'\' ';
	 		
	 		exec( $instrucao, $saida, $retorno);
	 		if($retorno !=0){
	 			throw new InfraException('Erro validando link externo.',$e);
	 		}else{
	 			return $saida;
	 		}
	 		
	 	}
	 	//Esta criptografia � usada no site do cade;
	 	//Alterar metodo de criptografia por uma criptografia php.
	 	public static function descriptografaSiteCade($texto){
	 	   
	 		$caminho = dirname(__FILE__).'/criptografia/mascaraArgumentos.jar';
	 		$instrucao = 'java -jar '.$caminho.' \'descriptografa\' \''.$texto.'\' \''.MdPesqCriptografia::$KEY.'\' ';
	 	
	 		exec( $instrucao, $saida, $retorno);
	 		if($retorno !=0){
	 			throw new InfraException('Erro validando link externo.',$e);
	 		}else{
	 			return $saida;
	 		}
	 	
	 	}
	 	
	 	//Esta criptografia � usada no site do cade;
	 	//Alterar metodo de criptografia por uma criptografia php.
	 	public static function descriptografaArgumentos($parametro){
	 		
	 		$parametrosCriptografados = $_SERVER['QUERY_STRING'];
	 		$parametrosDescriptografados = MdPesqCriptografia::descriptografa($parametrosCriptografados);
	 		$arrParametros = explode("&", $parametrosDescriptografados[0]);
	 		$bolRecuperParametro = false;
	 		$valorParametro = '';
	 		foreach ($arrParametros as $arrParametro){
	 			$parametroRetorno = explode("=", $arrParametro);
	 			if($parametroRetorno[0] == $parametro){
	 				$bolRecuperParametro = true;
	 				$valorParametro = $parametroRetorno[1];
	 				break;
	 			}else{
	 				$bolRecuperParametro = false;
	 			}
	 		}
	 		
	 		if($bolRecuperParametro){
	 			return $valorParametro;
	 		}else{
	 			throw new InfraException('Erro recuperando par�metro.');
	 		}
	 		
	 		
	 	}

	 } 	



?>