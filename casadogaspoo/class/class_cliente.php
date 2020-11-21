<?php

require_once 'class/conexao.php';
require_once 'class_cidade.php';

class Cliente {

    /** @var Cidade */
    private $Cidade;
    private $codigo;
    private $nome;
    private $cpf;

    public function getCidade() {
        return $this->Cidade;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCidade(Cidade $Cidade) {
        $this->Cidade = $Cidade;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    private function selectAll() {
        $sSql = 'SELECT *
                   FROM MERCADO.TBCLIENTE
                   JOIN MERCADO.TBCIDADE
                        USING(CIDCODIGO);';

        $oResultado = pg_query(Conexao::conectar(), $sSql);

        $aDados = [];

        while ($aLinha = pg_fetch_assoc($oResultado)) {
            $oCidade = new Cidade();
            $oCliente = new Cliente();

            $oCidade->setCodigo($aLinha['cidcodigo']);
            $oCidade->setNome($aLinha['cidnome']);

            $oCliente->setCodigo($aLinha['clicodigo']);
            $oCliente->setNome($aLinha['clinome']);
            $oCliente->setCpf($aLinha['clicpf']);
            $oCliente->setCidade($oCidade);

            $aDados[] = $oCliente;
        }

        return $aDados;
    }

    public function montaTabela() {
        $aDados = $this->selectAll();

        if (empty($aDados)) {
            echo 'Não existem registros';
        } else {
            echo '<table border=1>';
            echo '<tr>';
            echo '<th>Codigo</th>';
            echo '<th>Nome</th>';
            echo '<th>CPF</th>';
            echo '<th>Cidade - Nome</th>';
            echo '<th>Acoes</th>';
            echo '</tr>';

            foreach ($aDados as $oObjeto) {
                echo '<tr>';
                echo '<td>' . $oObjeto->getCodigo() . '</td>';
                echo '<td>' . $oObjeto->getNome() . '</td>';
                echo '<td>' . $oObjeto->getCpf() . '</td>';
                echo '<td>' . $oObjeto->getCidade()->getNome() . '</td>';
                echo '<td><a href="cliente.php?acao=deletar&registro=' . $oObjeto->getCodigo() . '">Deletar</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }

        public

        function deletar() {
            $sSql = 'DELETE
                   FROM MERCADO.TBCLIENTE
                  WHERE CLICODIGO = ' . $this->getCodigo();

            pg_query(Conexao::conectar(), $sSql);
        }

    }
    