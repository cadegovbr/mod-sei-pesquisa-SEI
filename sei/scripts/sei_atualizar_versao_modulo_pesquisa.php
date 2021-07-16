<?
require_once dirname(__FILE__) . '/../web/SEI.php';

class MdPesqAtualizadorSeiRN extends InfraRN
{

    private $numSeg = 0;
    private $versaoAtualDesteModulo = '4.0.0';
    private $nomeDesteModulo = 'MÓDULO DE PESQUISA PÚBLICA';
    private $nomeParametroModulo = 'VERSAO_MODULO_PESQUISA_PUBLICA';
    private $historicoVersoes = array('3.0.0', '4.0.0');

    public function __construct()
    {
        parent::__construct();
    }

    protected function inicializarObjInfraIBanco()
    {
        return BancoSEI::getInstance();
    }

    private function inicializar($strTitulo)
    {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit', '-1');
        @ini_set('zlib.output_compression', '0');
        @ini_set('implicit_flush', '1');
        ob_implicit_flush();

        InfraDebug::getInstance()->setBolLigado(true);
        InfraDebug::getInstance()->setBolDebugInfra(true);
        InfraDebug::getInstance()->setBolEcho(true);
        InfraDebug::getInstance()->limpar();

        $this->numSeg = InfraUtil::verificarTempoProcessamento();

        $this->logar($strTitulo);
    }

    private function logar($strMsg)
    {
        InfraDebug::getInstance()->gravar($strMsg);
        flush();
    }

    private function finalizar($strMsg = null, $bolErro = false)
    {
        if (!$bolErro) {
            $this->numSeg = InfraUtil::verificarTempoProcessamento($this->numSeg);
            $this->logar('TEMPO TOTAL DE EXECUÇÃO: ' . $this->numSeg . ' s');
        } else {
            $strMsg = 'ERRO: ' . $strMsg;
        }

        if ($strMsg != null) {
            $this->logar($strMsg);
        }

        InfraDebug::getInstance()->setBolLigado(false);
        InfraDebug::getInstance()->setBolDebugInfra(false);
        InfraDebug::getInstance()->setBolEcho(false);
        $this->numSeg = 0;
        die;
    }

    protected function atualizarVersaoConectado()
    {

        try {
            $this->inicializar('INICIANDO A INSTALAÇÃO/ATUALIZAÇÃO DO ' . $this->nomeDesteModulo . ' NO SEI VERSÃO ' . SEI_VERSAO);

            //checando BDs suportados
            if (!(BancoSEI::getInstance() instanceof InfraMySql) &&
                !(BancoSEI::getInstance() instanceof InfraSqlServer) &&
                !(BancoSEI::getInstance() instanceof InfraOracle)) {
                $this->finalizar('BANCO DE DADOS NÃO SUPORTADO: ' . get_parent_class(BancoSEI::getInstance()), true);
            }

            //testando versao do framework
            $numVersaoInfraRequerida = '1.532.1';
            $versaoInfraFormatada = (int)str_replace('.', '', VERSAO_INFRA);
            $versaoInfraReqFormatada = (int)str_replace('.', '', $numVersaoInfraRequerida);

            if ($versaoInfraFormatada < $versaoInfraReqFormatada) {
                $this->finalizar('VERSÃO DO FRAMEWORK PHP INCOMPATÍVEL (VERSÃO ATUAL ' . VERSAO_INFRA . ', SENDO REQUERIDA VERSÃO IGUAL OU SUPERIOR A ' . $numVersaoInfraRequerida . ')', true);
            }


            //checando permissoes na base de dados
            $objInfraMetaBD = new InfraMetaBD(BancoSEI::getInstance());

            if (count($objInfraMetaBD->obterTabelas('sei_teste')) == 0) {
                BancoSEI::getInstance()->executarSql('CREATE TABLE sei_teste (id ' . $objInfraMetaBD->tipoNumero() . ' null)');
            }

            BancoSEI::getInstance()->executarSql('DROP TABLE sei_teste');

            $objInfraParametro = new InfraParametro(BancoSEI::getInstance());

            $strVersaoModuloPeticionamento = $objInfraParametro->getValor($this->nomeParametroModulo, false);

            switch ($strVersaoModuloPeticionamento) {
                case '':
                    $this->instalarv300();
                case '3.0.0':
                    $this->instalarv400();
                    break;

                default:
                    $this->finalizar('A VERSÃO MAIS ATUAL DO ' . $this->nomeDesteModulo . ' (v' . $this->versaoAtualDesteModulo . ') JÁ ESTÁ INSTALADA.');
                    break;

            }

            $this->finalizar('FIM');
            InfraDebug::getInstance()->setBolDebugInfra(true);
        } catch (Exception $e) {
            InfraDebug::getInstance()->setBolLigado(true);
            InfraDebug::getInstance()->setBolDebugInfra(true);
            InfraDebug::getInstance()->setBolEcho(true);
            throw new InfraException('Erro instalando/atualizando versão.', $e);
        }
    }

    private function instalarv300()
    {
        $objInfraMetaBD = new InfraMetaBD(BancoSEI::getInstance());

        $this->logar('EXECUTANDO A INSTALAÇÃO/ATUALIZAÇÃO DA VERSÃO ' . $this->versaoAtualDesteModulo . ' DO ' . $this->nomeDesteModulo . ' NA BASE DO SEI');

        $this->logar('CRIANDO A TABELA md_pesq_parametro');

        BancoSEI::getInstance()->executarSql(' CREATE TABLE md_pesq_parametro (
					nome ' . $objInfraMetaBD->tipoTextoVariavel(100) . ' NOT NULL , 
					valor ' . $objInfraMetaBD->tipoTextoGrande() . '
					)');
        $objInfraMetaBD->adicionarChavePrimaria('md_pesq_parametro', 'pk_md_pesq_parametro', array('nome'));

        $this->logar('TABELA md_pesq_parametro CRIADA COM SUCESSO');
        $this->logar('INSERINDO DADOS NA TABELA md_pesq_parametro');

        $arrParametroPesquisaDTO = array(
            array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_CAPTCHA_PDF, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_PUBLICO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_PROCESSO_RESTRITO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_METADADOS_PROCESSO_RESTRITO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_ANDAMENTO_PROCESSO_RESTRITO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_DESCRICAO_PROCEDIMENTO_ACESSO_RESTRITO, 'Valor' => 'Processo ou Documento de Acesso Restrito - Para condições de acesso verifique a <a style="font-size: 1em;" href="http://[orgao]/link_condicao_acesso" target="_blank">Condição de Acesso</a> ou entre em contato pelo e-mail: sei@orgao.gov.br'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_DOCUMENTO_PROCESSO_PUBLICO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_PUBLICO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_LISTA_DOCUMENTO_PROCESSO_RESTRITO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_AUTO_COMPLETAR_INTERESSADO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_MENU_USUARIO_EXTERNO, 'Valor' => 'S'),
            array('Nome' => MdPesqParametroPesquisaRN::$TA_CHAVE_CRIPTOGRAFIA, 'Valor' => ''),
        );

        $arrObjParametroPesquisaDTO = InfraArray::gerarArrInfraDTOMultiAtributos('MdPesqParametroPesquisaDTO', $arrParametroPesquisaDTO);

        $objParametroPesquisaRN = new MdPesqParametroPesquisaRN();

        foreach ($arrObjParametroPesquisaDTO as $objParametroPesquisaDTO) {

            $objParametroPesquisaRN->cadastrar($objParametroPesquisaDTO);
        }

        $this->logar('ATUALIZANDO PARÂMETRO ' . $this->nomeParametroModulo . ' NA TABELA infra_parametro PARA CONTROLAR A VERSÃO DO MÓDULO');
        BancoSEI::getInstance()->executarSql('UPDATE infra_parametro SET valor = \'3.0.0\' WHERE nome = \'' . $this->nomeParametroModulo . '\' ');

        $this->logar('INSTALAÇÃO/ATUALIZAÇÃO DA VERSÃO ' . $this->versaoAtualDesteModulo . ' DO ' . $this->nomeDesteModulo . ' REALIZADA COM SUCESSO NA BASE DO SEI');

    }

    private function instalarv400()
    {

        $this->logar('EXECUTANDO A INSTALAÇÃO/ATUALIZAÇÃO DA VERSÃO ' . $this->versaoAtualDesteModulo . ' DO ' . $this->nomeDesteModulo . ' NA BASE DO SEI');

        $objInfraMetaBD = new InfraMetaBD(BancoSEI::getInstance());
        $objInfraMetaBD->setBolValidarIdentificador(true);

        $arrTabelas = array('md_pet_acesso_externo', 'md_pet_criterio', 'md_pet_ext_arquivo_perm', 'md_pet_hipotese_legal', 'md_pet_indisp_doc', 'md_pet_indisponibilidade', 'md_pet_int_aceite', 'md_pet_int_dest_resposta', 'md_pet_int_prazo_tacita', 'md_pet_int_prot_disponivel', 'md_pet_int_protocolo', 'md_pet_int_rel_dest', 'md_pet_int_rel_intim_resp', 'md_pet_int_rel_resp_doc', 'md_pet_int_rel_tipo_resp', 'md_pet_int_rel_tpo_res_des', 'md_pet_int_serie', 'md_pet_int_tipo_intimacao', 'md_pet_int_tipo_resp', 'md_pet_intimacao', 'md_pet_rel_recibo_docanexo', 'md_pet_rel_recibo_protoc', 'md_pet_rel_tp_ctx_contato', 'md_pet_rel_tp_proc_serie', 'md_pet_rel_tp_processo_unid', 'md_pet_tamanho_arquivo', 'md_pet_tipo_processo', 'md_pet_tp_processo_orientacoes', 'md_pet_usu_externo_menu',
            //Lista de 13 tabelas que faltou processar o indice na versao 3.0.1
            'md_pet_adm_integ_funcion', 'md_pet_adm_integ_param', 'md_pet_adm_integracao', 'md_pet_adm_tipo_poder', 'md_pet_adm_vinc_rel_serie', 'md_pet_adm_vinc_tp_proced', 'md_pet_int_tp_int_orient', 'md_pet_rel_int_dest_extern', 'md_pet_rel_vincrep_protoc', 'md_pet_rel_vincrep_tipo_poder', 'md_pet_vinculo', 'md_pet_vinculo_documento', 'md_pet_vinculo_represent');

        $this->fixIndices($objInfraMetaBD, $arrTabelas);

        $this->logar('ATUALIZANDO PARÂMETRO ' . $this->nomeParametroModulo . ' NA TABELA infra_parametro PARA CONTROLAR A VERSÃO DO MÓDULO');
        BancoSEI::getInstance()->executarSql('UPDATE infra_parametro SET valor = \'4.0.0\' WHERE nome = \'' . $this->nomeParametroModulo . '\' ');

        $this->logar('INSTALAÇÃO/ATUALIZAÇÃO DA VERSÃO ' . $this->versaoAtualDesteModulo . ' DO ' . $this->nomeDesteModulo . ' REALIZADA COM SUCESSO NA BASE DO SEI');

    }

}

try {
    SessaoSEI::getInstance(false);
    BancoSEI::getInstance()->setBolScript(true);

    if (!ConfiguracaoSEI::getInstance()->isSetValor('BancoSEI', 'UsuarioScript')) {
        throw new InfraException('Chave BancoSEI/UsuarioScript não encontrada.');
    }

    if (InfraString::isBolVazia(ConfiguracaoSEI::getInstance()->getValor('BancoSEI', 'UsuarioScript'))) {
        throw new InfraException('Chave BancoSEI/UsuarioScript não possui valor.');
    }

    if (!ConfiguracaoSEI::getInstance()->isSetValor('BancoSEI', 'SenhaScript')) {
        throw new InfraException('Chave BancoSEI/SenhaScript não encontrada.');
    }

    if (InfraString::isBolVazia(ConfiguracaoSEI::getInstance()->getValor('BancoSEI', 'SenhaScript'))) {
        throw new InfraException('Chave BancoSEI/SenhaScript não possui valor.');
    }

    $configuracaoSEI = new ConfiguracaoSEI();
    $arrConfig = $configuracaoSEI->getInstance()->getArrConfiguracoes();

    if (!isset($arrConfig['SEI']['Modulos'])) {
        throw new InfraException('PARÂMETROS DE MÓDULOS NO CONFIGURAÇÃO DO SEI NÃO DECLARADO');
    } else {
        $arrModulos = $arrConfig['SEI']['Modulos'];
        if (!key_exists('PesquisaIntegracao', $arrModulos)) {
            throw new InfraException('MÓDULO DO PESQUISA PÚBLICA NÃO DECLARADO NA CONFIGURAÇÃO DO SEI');
        }
    }

    if (!class_exists('PesquisaIntegracao')) {
        throw new InfraException('A CLASSE PRINCIPAL "PESQUISAINTEGRACAO" DO MÓDULO DO PESQUISA PÚBLICA NÃO ENCONTRADA');
    }

    $objVersaoSeiRN = new MdPesqAtualizadorSeiRN();
    $objVersaoSeiRN->atualizarVersao();
    exit;

} catch (Exception $e) {
    echo(InfraException::inspecionar($e));
    try {
        LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
    } catch (Exception $e) {
    }
    exit(1);
}


?>
