<?php 

class GamePlay_model extends CI_Model {

    public function mgckey($gameSymbol) {
        $compactSessionUrl = "http://demogamesfree.pragmaticplay.net/gs2c/openGame.do?gameSymbol=".$gameSymbol."&websiteUrl=https%3A%2F%2Fdemogamesfree.pragmaticplay.net&jurisdiction=99&lobby_url=https%3A%2F%2Fwww.pragmaticplay.com%2Fen%2F&lang=PT&cur=BRL";
    
        // Inicializando a sessão cURL
        $ch = curl_init($compactSessionUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0",
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "Origin: http://demogamesfree.ppgames.net",
            "Referer: http://demogamesfree.ppgames.net/",
         );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Desativando o redirecionamento automático
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($ch); // Capturando o retorno da requisição
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Capturando o código de status HTTP
        $redirectURL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // Capturando a URL efetiva após redirecionamentos
        curl_close($ch); // Fechando a sessão cURL
    
        // Verificando se a requisição foi bem-sucedida
        if ($html === false) {
            // Se houve algum erro na requisição
            echo "Erro ao fazer a requisição cURL: " . curl_error($ch);
        } else {
            // Se a requisição foi bem-sucedida
            // Extrair o parâmetro "mgckey" da URL de redirecionamento
            $parsedUrl = parse_url($redirectURL);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $query);
                if (isset($query['mgckey'])) {
                    $mgckey = $query['mgckey'];
                    return $mgckey;
                } else {
                    echo "mgckey não encontrado na URL de redirecionamento.";
                }
            } else {
                echo "A URL de redirecionamento não contém parâmetros de consulta.";
            }
        }
    }

    public function wurlf(){
        $url = base_url()."/public/js/wurfl.js";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0",
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "Origin: http://demogamesfree.ppgames.net",
            "Referer: http://demogamesfree.ppgames.net/",
         );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Desativando o redirecionamento automático
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }

}