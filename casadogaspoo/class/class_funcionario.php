<?php

require_once 'class/conexao.php';
require_once 'class_departamento.php';

class Funcionario {

    /** @var Departamento */
    private $Departamento;
    private $codigo;
    private $nome;

    public function getDepartamento() {
        return $this->Departamento;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setDepartamento(Departamento $Departamento) {
        $this->Departamento = $Departamento;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    private function selectAll() {
        $sSql = 'SELECT *
                   FROM MERCADO.TBFUNCIONARIO
                   JOIN MERCADO.TBDEPARTAMENTO
                        USING(DPTCODIGO)';

        $oResultado = pg_query(Conexao::conectar(), $sSql);

        $aDados = [];

        while ($aLinha = pg_fetch_assoc($oResultado)) {
            $oFuncionario = new Funcionario();
            $oDepartamento = new Departamento();

            $oDepartamento->setCodigo($aLinha['dptcodigo']);
            $oDepartamento->setDescricao($aLinha['dptdescricao']);

            $oFuncionario->setCodigo($aLinha['fcncodigo']);
            $oFuncionario->setNome($aLinha['fcnnome']);
            $oFuncionario->setDepartamento($oDepartamento);

            $aDados[] = $oFuncionario;
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
            echo '<th>Departamento - Nome</th>';
            echo '<th>Acoes</th>';
            echo '</tr>';

            foreach ($aDados as $oObjeto) {
                echo '<tr>';
                echo '<td>' . $oObjeto->getCodigo() . '</td>';
                echo '<td>' . $oObjeto->getNome() . '</td>';
                echo '<td>' . $oObjeto->getDepartamento()->getDescricao() . '</td>';
                echo '<td><a href="funcionario.php?acao=deletar&registro=' . $oObjeto->getCodigo() . '">Deletar</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }

    public function deletar() {
        $sSql = 'DELETE
                   FROM MERCADO.TBFUNCIONARIO
                  WHERE FCNCODIGO = ' . $this->getCodigo();

        pg_query(Conexao::conectar(), $sSql);
    }

}
