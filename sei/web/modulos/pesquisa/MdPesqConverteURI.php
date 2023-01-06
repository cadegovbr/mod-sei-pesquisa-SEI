<?
/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECON�MICA
 * 2014-10-02
 * Vers�o do Gerador de C�digo: 1.0
 * Vers�o no CVS/SVN:
 *
 * sei
 * pesquisa
 * ConverterURI
 *
 *
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 */

/**
 * Arquivo para convers�o de url.
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

require_once ("MdPesqCriptografia.php");
	class MdPesqConverteURI{
		
		public static function converterURI(){
			
			try {
				$arr = explode('?', $_SERVER['REQUEST_URI']);
				$arrParametros = MdPesqCriptografia::descriptografa($arr[1]);
				//$parametros = explode('&', $arrParametros[0]);
				$parametros = explode('&', $arrParametros);
				$chaves = array();
				$valores = array();
				foreach ($parametros as $parametro){
					$arrChaveValor = explode('=', $parametro);
					$chaves[] = $arrChaveValor[0];
					$valores[] = $arrChaveValor[1];
				
				}
				$novosParametros = array_combine($chaves, array_values($valores));
				$new_query_string = http_build_query($novosParametros);
				$_SERVER['REQUEST_URI'] = $arr[0].'?'.$new_query_string;
				$_GET = $novosParametros;
			}catch (Exception $e){
				throw new InfraException('Erro validando url.', $e);
			}
		}
	}

?>