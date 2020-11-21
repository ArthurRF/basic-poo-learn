<?php

class Conexao {

    public static function conectar() {
        return pg_connect('host=127.0.0.1
                port=5432
                dbname=GAS
                user=postgres
                password=IPM@1234567');
    }

}
