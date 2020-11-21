<?php

require_once 'class/conexao.php';
require_once 'class_cidade.php';

class Fornecedor {

    /** @var Cidade */
    private $Cidade;
    private $codigo;
    private $nome;
    private $cnpj;

    public function getCidade() {
        return $this->Cidade;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCnpj() {
        return $this->cnpj;
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

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    private function selectAll() {
        $sSql = 'SELECT *
                   FROM MERCADO.TBFORNECEDOR
                   JOIN MERCADO.TBCIDADE
                        USING(CIDCODIGO);';

        $oResultado = pg_query(Conexao::conectar(), $sSql);

        $aDados = [];

        while ($aLinha = pg_fetch_assoc($oResultado)) {
            $oCidade = new Cidade();
            $oFornecedor = new Fornecedor();

            $oCidade->setCodigo($aLinha['cidcodigo']);
            $oCidade->setNome($aLinha['cidnome']);

            $oFornecedor->setCodigo($aLinha['forcodigo']);
            $oFornecedor->setNome($aLinha['fornome']);
            $oFornecedor->setCnpj($aLinha['forcnpj']);
            $oFornecedor->setCidade($oCidade);

            $aDados[] = $oFornecedor;
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
            echo '<th>CNPJ</th>';
            echo '<th>Cidade - Nome</th>';
            echo '<th>Acoes</th>';
            echo '</tr>';

            foreach ($aDados as $oObjeto) {
                echo '<tr>';
                echo '<td>' . $oObjeto->getCodigo() . '</td>';
                echo '<td>' . $oObjeto->getNome() . '</td>';
                echo '<td>' . $oObjeto->getCnpj() . '</td>';
                echo '<td>' . $oObjeto->getCidade()->getNome() . '</td>';
                echo '<td><a href="fornecedor.php?acao=deletar&registro=' . $oObjeto->getCodigo() . '">Deletar</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }

    public function deletar() {
        $sSql = 'DELETE
                   FROM MERCADO.TBFORNECEDOR
                  WHERE FORCODIGO = ' . $this->getCodigo();

        pg_query(Conexao::conectar(), $sSql);
    }

}
